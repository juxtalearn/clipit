<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   18/07/14
 * Last update:     18/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$activity = elgg_extract('entity', $vars);
?>
<div class="row">
    <?php echo elgg_view("input/hidden", array(
        'name' => 'entity-id',
        'value' => $activity->id,
    ));
    ?>
    <div class="col-md-6">
        <div class="form-group">
            <label for="activity-title"><?php echo elgg_echo("activity:title");?></label>
            <?php echo elgg_view("input/text", array(
                'name' => 'activity-title',
                'class' => 'form-control',
                'value' => $activity->name,
                'required' => true
            ));
            ?>
        </div>
        <div class="form-group margin-top-10">
            <label for="activity-description"><?php echo elgg_echo("activity:description");?></label>
            <?php echo elgg_view("input/plaintext", array(
                'name'  => 'activity-description',
                'class' => 'form-control',
                'value' => $activity->description,
                'required' => true,
                'rows'  => 8,
            ));
            ?>
        </div>
    </div>
    <div class="col-md-6">
        <label><?php echo elgg_echo("tricky_topic");?></label>
        <div style="background: #fafafa;padding: 10px;" class="content-block">
            <?php echo elgg_view('tricky_topic/list', array('tricky_topic' => $activity->tricky_topic));?>
        </div>
    </div>
    <div class="col-md-12">
        <?php
            echo elgg_view('input/submit', array(
                'value' => elgg_echo('update'),
                'class' => "btn btn-primary pull-right",
                'style' => "margin-top: 20px;"
            ));
        ?>
    </div>
</div>