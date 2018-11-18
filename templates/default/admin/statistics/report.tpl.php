<?php
$report = $vars['report'];

$level = 1;
if (!empty($vars['level']))
    $level = (int) $vars['level'];

if (empty($report))
    $report = [];

foreach ($report as $label => $value) {

    if (is_array($value)) {
        ?>

        <div class="form-group">
            <h<?= $level; ?>><?= $label ?></h<?= $level; ?>>
        <?= $this->__(['report' => $value, 'level' => $level + 1])->draw('admin/statistics/report'); ?>
        </div>
        
        <?php 
        if ($level>1) { ?>
            <hr style="clear: both" />    
        <?php
        }
    } else {
        ?>

        <div class="form-group">
            <div class="col-md-3">
                <label class="control-label" for="inputName"><?= $label; ?></label>
            </div>
            <div class="col-md-9">
                <pre><?= $value; ?></pre>
            </div>
        </div>
        <?php
    }
}