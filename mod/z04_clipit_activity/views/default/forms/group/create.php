<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 25/02/14
 * Time: 10:41
 * To change this template use File | Settings | File Templates.
 */
$activity = elgg_extract('entity', $vars);
?>
<?php echo elgg_view("input/hidden", array(
    'name' => 'activity-id',
    'value' => $activity->id,
));
?>
<div class="form-group">
    <label><?php echo elgg_echo("group:name"); ?></label>
    <?php echo elgg_view("input/text", array(
        'name' => 'group-name',
        'class' => 'form-control'
    ));
    ?>
</div>
<p class="text-left">
<?php echo elgg_view('input/submit',
    array(
        'value' => elgg_echo('create'),
        'class' => "btn btn-primary"
    ));
?>
</p>