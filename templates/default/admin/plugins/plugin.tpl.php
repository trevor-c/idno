<?php
$plugin_description = $vars['plugin']['Plugin description'];
$shortname = $vars['plugin']['shortname'];

// Construct requirements array
$requirements = [];
foreach (['php', 'known', 'idno', 'build', 'extension', 'plugin'] as $field) {
    if (isset($vars['plugin']['requirements'][$field]))
        $requirements[$field] = $vars['plugin']['requirements'][$field];
    else if (isset($plugin_description[$field]))
        $requirements[$field] = $plugin_description[$field];
}
?>
<div class="well well-large" id="plugin-<?=strtolower($shortname)?>">
    <div class="row">
        <div class="col-md-2">
            <p>
                <strong><?= $plugin_description['name'] ?></strong> <?= $plugin_description['version'] ?><br/>
                <small>
                    by <a href="<?php

                    if (!empty($plugin_description['author_url'])) {
                        echo htmlspecialchars($plugin_description['author_url']);
                    } else {
                        echo '#';
                    }

                    ?>"><?= $plugin_description['author'] ?></a>
                </small>
                <br/>
                <?php

                if (array_key_exists($shortname, $vars['plugins_loaded'])) {
                    echo '<span class="label label-success">Enabled</span>';
                } else {
                    echo '<span class="label">Disabled</span>';
                }

                ?>
            </p>
        </div>
        <div class="col-md-5">
            <?php

            if (!empty($plugin_description['description'])) echo $this->autop($plugin_description['description']);

            if (isset($requirements)) {

                ?>
                <div class="requirements">

                    <?php
                    if (isset($requirements['known'])) {
                        ?>
                        <p><label>Known
                                Version: <?php echo $this->__(array('version' => $requirements['known']))->draw('admin/dependencies/idno'); ?> </label>
                        </p>
                        <?php
                    }
                    ?>

                    <?php
                    if (isset($requirements['build'])) {
                        ?>
                        <p><label>Known
                                Build: <?php echo $this->__(array('version' => $requirements['build']))->draw('admin/dependencies/build'); ?> </label>
                        </p>
                        <?php
                    }
                    ?>

                    <?php
                    if (isset($requirements['php'])) {
                        ?>
                        <p><label>PHP
                                Version: <?php echo $this->__(array('version' => $requirements['php']))->draw('admin/dependencies/php'); ?> </label>
                        </p>
                        <?php
                    }
                    ?>

                    <?php
                    if (isset($requirements['extension'])) {
                        if (!is_array($requirements['extension']))
                            $requirements['extension'] = array($requirements['extension']);
                        ?>
                        <p><label>Extensions: <?php
                                foreach ($requirements['extension'] as $extension)
                                    echo $this->__(array('extension' => $extension))->draw('admin/dependencies/extension');
                                ?> </label></p>
                        <?php
                    }
                    ?>

                    <?php
                    if (isset($requirements['plugin'])) {
                        if (!is_array($requirements['plugin']))
                            $requirements['plugin'] = array($requirements['plugin']);
                        ?>
                        <p><label>Plugins: <?php
                                foreach ($requirements['plugin'] as $plugin) {
                                    @list($plugin, $version) = explode(',', $plugin);
                                    echo $this->__(array('plugin' => $plugin, 'version' => $version))->draw('admin/dependencies/plugin');
                                }
                                ?> </label></p>
                        <?php
                    }
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="col-md-1 col-md-offset-1">
            <?php
            if (!in_array($shortname, \Idno\Core\Idno::site()->config()->alwaysplugins)) {
                if (array_key_exists($shortname, $vars['plugins_loaded'])) {
                    ?>
                    <form action="<?= \Idno\Core\Idno::site()->config()->getDisplayURL() ?>admin/plugins/"
                          method="post">
                        <p>
                            <input type="hidden" name="plugin" value="<?= $shortname ?>"/>
                            <input type="hidden" name="container" value="plugin-<?= strtolower($shortname) ?>"/>
                            <input type="hidden" name="plugin_action" value="uninstall"/>
                            <input class="btn btn-default plugin-button" type="submit" value="Disable"/>
                        </p>
                        <?= \Idno\Core\Idno::site()->actions()->signForm(\Idno\Core\Idno::site()->config()->getDisplayURL() . 'admin/plugins/') ?>
                    </form>
                    <?php
                } else {
                    ?>
                    <form action="<?= \Idno\Core\Idno::site()->config()->getDisplayURL() ?>admin/plugins/"
                          method="post">
                        <p>
                            <input type="hidden" name="plugin" value="<?= $shortname ?>"/>
                            <input type="hidden" name="container" value="plugin-<?= strtolower($shortname) ?>"/>
                            <input type="hidden" name="plugin_action" value="install"/>
                            <input class="btn btn-primary plugin-button" type="submit" value="Enable"/>
                        </p>
                        <?= \Idno\Core\Idno::site()->actions()->signForm(\Idno\Core\Idno::site()->config()->getDisplayURL() . 'admin/plugins/') ?>
                    </form>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>
