<link href="<?= \Idno\Core\Idno::site()->config()->getStaticURL() ?>css/<?= $this->getModifiedTS('css/default.min.css'); ?>/default.min.css" rel="stylesheet">
<link href="<?= \Idno\Core\Idno::site()->config()->getStaticURL() ?>css/<?= $this->getModifiedTS('css/defaultb3.min.css'); ?>/defaultb3.min.css" rel="stylesheet">

<!-- Syndication -->
<link
    href="<?= \Idno\Core\Idno::site()->config()->getStaticURL() ?>external/bootstrap-toggle/css/bootstrap-toggle.min.css"
    rel="stylesheet"/>

<!-- Mention styles -->
<link rel="stylesheet" type="text/css"
      href="<?= \Idno\Core\Idno::site()->config()->getDisplayURL() ?>external/mention/recommended-styles.css">

<?php
    // Load style assets
    if ((\Idno\Core\Idno::site()->currentPage()) && $style = \Idno\Core\Idno::site()->currentPage->getAssets('css')) {
        foreach ($style as $css) {
            ?>
            <link href="<?= $css; ?>" rel="stylesheet">
            <?php
        }
    }
?>

