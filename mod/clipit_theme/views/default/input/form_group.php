<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 12/02/14
 * Time: 11:59
 * To change this template use File | Settings | File Templates.
 */
if (empty($vars['width'])) {
    $vars['width'] = "6";
}
if (!empty($vars['label'])) {
    $vars['label'] = '<label for="'.$vars["name"].'" class="col-sm-3 control-label">
                        '.$vars["label"].'
                      </label>';
}


?>
<div class="form-group">
    <?php echo $vars['label'] ?>
    <div class="col-sm-<?php echo $vars['width'] ?>">
        <?php echo $vars['input'] ?>
    </div>
</div>