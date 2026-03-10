# webapp — Project Setup and Management Tool

`webapp` is a convention-based bash tool that replaces the old `hidev-webapp` PHP tool.
It handles project setup, Docker initialization, and environment management for all
hisite projects (hiapi, hipanel, hiam, etc.).

## Installation

Installed via Composer `"bin"` directive in `hiqdev/hidev`. Available as:

```bash
vendor/bin/webapp
```

Root projects typically delegate through a Makefile:

```makefile
TIER ?= local

setup:
 @test -d vendor || composer install
 vendor/bin/webapp setup $(TIER)
```

The `composer install` bootstrap ensures `vendor/bin/webapp` exists before first use.

## Commands

### `webapp setup <tier>`

Full project setup. Performs the following steps in order:

1. **Symlink `.env`** — links `.env` → `.env.<tier>`
2. **Symlink `docker-compose.yml`** — uses the [fallback chain](#docker-compose-fallback-chain) to find the best match
3. **Create directories** — `runtime/`, `public/`, `.docker/php/var/log/php`, `.docker/nginx/var/log/nginx`
4. **Symlink public entry points** — links `public/index.php`, `robots.txt`, `favicon.ico` from `core/public/` (skips existing)
5. **Set permissions** — `chmod a+w` on `runtime/` and `public/assets/`
6. **Check `/etc/hosts`** — reads `REAL_IP` and `HOSTS` from `.env`; if `REAL_IP` is a loopback address (`127.*`), adds the entry automatically (with sudo)
7. **Composer dump-autoload** — rebuilds autoload and merged config
8. **Docker init** — creates external networks and volumes (see below)

### `webapp status`

Shows current project root, `.env` target, `docker-compose.yml` target, and `docker compose ps` output.

### `webapp docker-init`

Parses `docker-compose.yml` (via `docker compose config --format json`) and creates any
external networks and volumes declared in it. Requires `jq`.

External resources are identified by `external: true` in the compose file.
The actual resource name comes from the `name` field (falls back to the YAML key).

External Docker networks and volumes are discovered from `docker-compose.yml` at
runtime — their names come from the `name` field in the compose file, not from env vars.

### `webapp help`

Prints usage summary.

## Tier System

A **tier** is a named environment configuration. Each tier corresponds to:
- An env file: `.env.<tier>`
- A docker-compose variant (via fallback chain)

Standard tiers:

| Tier | Purpose |
|------|---------|
| `local` | Local development with containerized services |
| `dev` | Shared development server |
| `beta` | Staging with monitoring (NewRelic, Blackfire, SSL) |
| `prod` (dist) | Full production stack |

### Personal tiers

Personal tiers follow the pattern `<user>-<base>` (e.g. `sol-beta`, `john-dev`).
The base tier is extracted by taking everything after the last hyphen:
`sol-beta` → base tier `beta`.

Personal tiers require their own `.env.<user>-<base>` file but reuse the base tier's
docker-compose variant via the fallback chain.

## Docker-Compose Fallback Chain

When resolving which docker-compose file to use for a tier, webapp checks these paths
in order and uses the first one found:

1. `core/docker-compose.yml.<tier>` — exact tier match (e.g. `core/docker-compose.yml.sol-beta`)
2. `core/docker-compose.yml.<base>` — base tier match (e.g. `core/docker-compose.yml.beta`)
3. `core/docker-compose.yml.dist` — default in core package
4. `docker-compose.yml.dist` — fallback in project root

Step 2 only applies to personal tiers (where tier contains a hyphen).

## Environment Variables

The following `.env` variables are used by webapp during setup:

| Variable | Used by | Purpose |
|----------|---------|---------|
| `REAL_IP` | `/etc/hosts` check | IP address for the hosts entry (only acts on `127.*`) |
| `HOSTS` | `/etc/hosts` check | Hostname to add (e.g. `local.hiapi.advancedhosting.com`) |
