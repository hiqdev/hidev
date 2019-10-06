<?php

namespace hidev\components;

class Deployer
{
    private $dir;
    private $path;
    private $name;
    private $tier;
    private $dotenv;

    public function __construct(string $path)
    {
        $path = trim($path);
        if (strncmp($path, '/', 1) !== 0) {
            $path = getcwd() . '/' . $path;
        }
        if (!file_exists($path)) {
            throw new \Exception("no env file at $path");
        }

        $this->dir = dirname($path);
        $this->path = $path;

        $this->getComposer()->autoload();

        $file = basename($path);
        $ps = explode('.', $file, 3);
        $name = $ps[2];
        $ps = explode('-', $name);

        $this->file = $file;
        $this->name = $name;
        $this->tier = $ps[1] ?? $name;

        $this->dotenv = $this->createDotenv($this->dir, $this->file);
        $this->dotenv->load();

        $this->checkHost();
    }

    private function checkHost()
    {
        $dir = basename($this->dir);
        $host = $this->getHost();
        if ($dir !== $host) {
            die("Dir:$dir and Host:$host doesn't match\n");
        }
    }

    /**
     * Creates Dotenv object.
     * Supports both 2 and 3 version of `phpdotenv`
     * @param mixed $dir
     * @param mixed $file
     * @return Dotenv
     */
    private function createDotenv($dir, $file)
    {
        if (method_exists(Dotenv::class, 'create')) {
            return Dotenv::create($dir, $file);
        } else {
            return new Dotenv($dir, $file);
        }
    }

    public function call(string $name = null)
    {
        $name = $name ?: 'all';
        if (!method_exists($this, $name)) {
            throw new \Exception("wrong command: $name");
        }

        $this->{$name}();
    }

    public function all()
    {
        $this->symlinks();
        $this->chmod();
        $this->phplog();
        $this->up();
    }

    public function symlinks()
    {
        $envSrc = $this->getPath($this->file);
        $envDst = $this->getPath('.env');
        $docSrc = $this->findDocker();
        $docDst = $this->getPath('docker-compose.yml');

        sys::passthru("ln -sf $envSrc $envDst");
        sys::passthru("ln -sf $docSrc $docDst");
    }

    private function findDocker(): string
    {
        $path = $this->getPath("core/docker-compose.yml.{$this->name}");
        if (file_exists($path)) {
            return $path;
        }
        $path = $this->getPath("core/docker-compose.yml.{$this->tier}");
        if (file_exists($path)) {
            return $path;
        }
        $tier = $this->getAltTier();
        $path = $this->getPath("core/docker-compose.yml.$tier");
        if (file_exists($path)) {
            return $path;
        }

        throw new \Exception("no docker-compose file: $path");
    }

    private function getAltTier()
    {
        //return $this->tier === 'beta' ? 'dist' : $this->tier;
        return 'dist';
    }

    public function chmod()
    {
        sys::chmod('a+w', 'runtime public/assets');
    }

    public function phplog()
    {
        $phplog = $this->getPath('.docker/php/var/log/php/php.log');
        $dir = dirname($phplog);
        if (!file_exists($dir)) {
            sys::mkdir($dir);
        }
        if (!file_exists($phplog)) {
            sys::passthru("sudo touch $phplog");
        }
        sys::chmod('a+w', $phplog);
    }

    private $composer;

    private function getComposer()
    {
        if ($this->composer === null) {
            $this->composer = new Composer($this->dir);
        }

        return $this->composer;
    }

    private function up()
    {
        $this->refresh();
        $this->getSystemd()->up($this->genSystemdConfig());
    }

    private function down()
    {
        $this->getSystemd()->down();
    }

    private function restart()
    {
        $this->refresh();
        $this->getSystemd()->restart();
        $this->getSystemd()->status();
    }

    private function status()
    {
        $this->refresh();
        $this->getSystemd()->status();
    }

    private $systemd;

    private function getSystemd()
    {
        if ($this->systemd === null) {
            $this->systemd = new Systemd($this->getHost());
        }

        return $this->systemd;
    }

    public function refresh()
    {
        $this->getComposer()->dump();
    }

    private $systemdTemplate = 'core/systemd.service';

    private function genSystemdConfig()
    {
        return $this->genByTemplate($this->systemdTemplate);
    }

    private function genByTemplate($file): string
    {
        $tpl = file_get_contents($this->findTemplatePath($file));
        $subs = [];
        foreach ($this->getConfig() as $key => $value) {
            $subs["{{$key}}"] = $value;
        }

        return strtr($tpl, $subs);
    }

    /**
     * undocumented function
     *
     * @return void
     */
    private function findTemplatePath($file)
    {
        $path = $this->getPath($file);
        if (file_exists($path)) {
            return $path;
        }
        $path = __DIR__ . DIRECTORY_SEPARATOR . $file;
        if (file_exists($path)) {
            return $path;
        }
        $path = __DIR__ . DIRECTORY_SEPARATOR . basename($file);
        if (file_exists($path)) {
            return $path;
        }

        throw new \Exception("failed find `$file` template");
    }

    public function getConfig(): array
    {
        return array_merge(
            [
                'HOST'  => $this->getHost(),
                'DIR'   => $this->dir,
            ],
            $this->getEnv(),
        );
    }

    public function getEnv(): array
    {
        return $_ENV;
    }

    public function getHost(): string
    {
        $hosts = $this->getHosts();
        return $_ENV['HOST'] ?? reset($hosts);
    }

    public function getHosts(): array
    {
        if (!empty($_ENV['HOSTS'])) {
            $hosts = explode(',', $_ENV['HOSTS']);
        } elseif (!empty($_ENV['HOST'])) {
            $hosts = [$_ENV['HOSTS']];
        } else {
            throw new \Exception('no HOST given');
        }
        foreach ($hosts as &$host) {
            $host = trim($host);
        }

        return $hosts;
    }

    public function getPath(string $file): string
    {
        if (strncmp($file, '/', 1) === 0) {
            $path = $file;
        } else {
            $path = $this->dir . DIRECTORY_SEPARATOR . $file;
        }

        return $this->extractCwd($path);
    }

    private function extractCwd(string $path): string
    {
        $cwd = $this->getCwd();
        $len = strlen($cwd);
        if (strncmp($path, $cwd, $len) === 0) {
            $path = substr($path, $len+1);
        }

        return $path;
    }

    private $cwd;

    private function getCwd(): string
    {
        if ($this->cwd === null) {
            $this->cwd = \getcwd();
        }

        return $this->cwd;
    }
}
