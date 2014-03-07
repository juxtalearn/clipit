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
    <label><?php echo elgg_echo("activity:group_create:name"); ?></label>
    <?php echo elgg_view("input/text", array(
        'name' => 'group-name',
        'placeholder' => 'Los manolos',
        'class' => 'form-control'
    ));
    ?>
</div>
<div class="form-group">
    <label><?php echo elgg_echo("activity:group_create:description"); ?> <small>(<?php echo elgg_echo("optional"); ?>)</small></label>
    <?php echo elgg_view("input/plaintext", array(
        'name' => 'group-description',
        'class' => 'form-control',
        'rows'  => 4,
    ));
    ?>
</div>
<?php echo elgg_view('input/submit', array('value' => elgg_echo('Create'))); ?>