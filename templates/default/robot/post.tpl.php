<div class="row idno-entry idno-entry-helper">
    <div
        class="col-md-10 col-md-offset-1 idno-helper idno-object idno-content">
        <div class="e-content entry-content">

            <div class="robot-head" style="width: 100px; height: 130px; float: left">
                <p style="text-align: center">
                    <img src="<?php echo \Idno\Core\Idno::site()->config()->getDisplayURL()?>gfx/robots/1.png"/></a><br/>
                    Aleph
                </p>
            </div>

            <div class="col-md-10 robot-murmur">
                <?php echo $this->autop($vars['body']) ?>
                <div class="robot-footer">
                    <p>
                        <?php

                            echo \Idno\Core\Idno::site()->actions()->createLink(\Idno\Core\Idno::site()->config()->getDisplayURL() . 'robot/remove', \Idno\Core\Idno::site()->language()->_("Power down robots. I can take it from here."));

                        ?>
                    </p>
                </div>
            </div>
            <br class="clearall">
        </div>
    </div>
</div>