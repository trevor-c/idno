<?= $this->draw('js/known'); ?>

<!-- Default Known JavaScript -->
<script src="<?= \Idno\Core\Idno::site()->config()->getStaticURL() ?>js/<?= $this->getModifiedTS('js/default.min.js'); ?>/default.min.js"></script>

<script
    src="<?= \Idno\Core\Idno::site()->config()->getStaticURL() ?>external/bootstrap-toggle/js/bootstrap-toggle.js"></script>

<script src="<?= \Idno\Core\Idno::site()->config()->getStaticURL() ?>external/fragmention/fragmention.min.js"></script> 
