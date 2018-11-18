<?php

    $path = false;
    $url = false;

    if (!empty($vars['theme'])) {
        if (!empty($vars['theme']['Theme description']['path'])) {
            $path = $vars['theme']['Theme description']['path'];
        }
        if (!empty($vars['theme']['Theme description']['url'])) {
            $url = $vars['theme']['Theme description']['url'];
        }
    }

?>
<div class="col-md-4 theme">

    <?php

        if (!empty($vars['theme']['shortname'])) {
            if (file_exists($path . 'preview.png')) {
                $src = $url . 'preview.png';
            }
        } else {
            $vars['theme']['shortname'] = 'default';
            $src = \Idno\Core\Idno::site()->config()->getDisplayURL() . 'gfx/themes/default.png';
        }
        if (!empty($src)) {

    ?>
    <p><?php

            echo '<img src="' . $src . '" style="width: 100%">';
            //echo \Idno\Core\Idno::site()->actions()->createLink(\Idno\Core\Idno::site()->config()->getDisplayURL() . 'admin/themes/', '<img src="' . $src . '" style="width: 100%">', array('theme' => $vars['theme']['shortname'], 'action' => 'install'), array('class' => ''));

        ?></p>
    <?php
        }
    ?>
    <h4><?= $vars['theme']['Theme description']['name'] ?> <?php if (\Idno\Core\Idno::site()->themes()->get() == $vars['theme']['shortname']) {
            echo '(Selected)';
        } else {
            echo \Idno\Core\Idno::site()->actions()->createLink(\Idno\Core\Idno::site()->config()->getDisplayURL() . 'admin/themes/', 'Enable', array('theme' => $vars['theme']['shortname'], 'action' => 'install'), array('class' => 'pull-right btn btn-primary'));
        }
?></h4>

    <p>
        <strong>Version <?= $vars['theme']['Theme description']['version'] ?></strong> by
        <a href="<?= $vars['theme']['Theme description']['author_url'] ?>"><?= $vars['theme']['Theme description']['author'] ?></a>
    </p>

    <p>
        <?= $vars['theme']['Theme description']['description'] ?>
    </p>

</div>