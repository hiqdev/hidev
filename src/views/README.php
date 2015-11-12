<?= $config->readme->renderH1($config->package->headline ?: $config->package->title) ?>
<?php if ($config->package->headline) { ?>
<?= $config->readme->renderBold($config->package->title) ?>
<?php } ?>
<?= $config->readme->renderBadges() ?>
<?= $config->readme->renderText($config->package->description) ?>
<?= $config->readme->renderSections() ?>
