<?= $config->readme->renderH1($config->package->headline) ?>
<? if ($config->package->headline != $config->package->title) { ?>
<?= $config->readme->renderBold($config->package->title) ?>
<? } ?>
<?= $config->readme->renderBadges() ?>
<?= $config->readme->renderText($config->package->description) ?>
<?= $config->readme->renderSections() ?>
