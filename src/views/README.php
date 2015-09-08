<?= $config->package->title ?>

<?= str_repeat('-', mb_strlen($config->package->title, \Yii::$app->charset)) ?>


<?= $config->package->description ?>


<?= $config->readme->renderBadges() ?>

## Installation

The preferred way to install this <?= $config->package->type ?> is through [composer](http://getcomposer.org/download/).

<?php if ($config->package->type === 'project') { ?>
```
php composer.phar create-project "<?= $config->package->fullName ?>:*" directory2install
```
<?php } else { ?>
Either run

```
php composer.phar require "<?= $config->package->fullName ?>"
```

or add

```json
"<?= $config->package->fullName ?>": "*"
```

to the require section of your composer.json.
<?php } ?>
<?= $config->readme->renderSection('Configuration') ?>
<?= $config->readme->renderSection('Usage') ?>

## Licence

[<?= $config->package->license ?>](<?= $config->license->url ?>)

Copyright © <?= $config->package->years ?>, <?= $config->vendor->titleAndHomepage ?>

