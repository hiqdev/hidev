<?= $config->readme->renderH1($config->package->title) ?>
<?= $config->readme->renderText($config->package->description) ?>
<?= $config->readme->renderBadges() ?>
<?= $config->readme->renderSection('Installation') ?>
<?= $config->readme->renderSection('Configuration') ?>
<?= $config->readme->renderSection('Usage') ?>
<?= $config->readme->renderSection('License') ?>
