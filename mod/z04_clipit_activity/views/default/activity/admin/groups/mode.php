<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   2/09/14
 * Last update:     2/09/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$activity = elgg_extract('activity', $vars);
$disabled = false;
if($activity->public){
    $disabled = true;
}
?>
<script>
$(function(){
    $('select[name="group-mode"]').change(function(){
       if($(this).val() == '<?php echo ClipitActivity::GROUP_MODE_TEACHER;?>'){
           $('.max-users').hide();
       } else {
           $('.max-users').show();
       }
    });
});
</script>
<?php echo elgg_view("input/hidden", array(
    'name' => "entity-id",
    'value' => $activity->id,
));
?>
<div class="bg-info">
    <div class="row">
        <div class="col-xs-9">
            <div class="pull-right max-users"
                 style="display: <?php echo $activity->group_mode != ClipitActivity::GROUP_MODE_TEACHER ? 'block':'none';?>;">
                <label class="show"><?php echo elgg_echo('group:max_size');?></label>
                <?php
                    echo elgg_view("input/text", array(
                        'name' => 'max-users',
                        'value' => $activity->max_group_size,
                        'class' => 'form-control',
                        'style' => 'width: 50%;',
                    ));
                ?>
            </div>
            <div class="pull-left">
                <label><?php echo elgg_echo('activity:grouping_mode');?></label>
                <?php
                    echo elgg_view('input/dropdown', array(
                        'name' => 'group-mode',
                        'class' => 'form-control',
                        'style' => 'width: auto;padding: 2px;',
                        'value' => $activity->group_mode,
                        'disabled' => $disabled,
                        'options_values' => array(
                            ClipitActivity::GROUP_MODE_TEACHER => elgg_echo('activity:grouping_mode:teacher'),
                            ClipitActivity::GROUP_MODE_STUDENT => elgg_echo('activity:grouping_mode:student'),
                            ClipitActivity::GROUP_MODE_SYSTEM => elgg_echo('activity:grouping_mode:system'),
                        )
                    ));
                ?>
                <?php if($disabled):?>
                    <label class="margin-top-5"><?php echo elgg_echo('activity:register:title');?></label>
                    <?php echo elgg_view('output/url', array(
                        'href'  => "clipit_activity/{$activity->id}/admin?filter=options",
                        'title' => elgg_echo('activity:register:open'),
                        'text'  => '<i class="fa fa-unlock"></i> '. elgg_echo('activity:register:open')
                    ));
                    ?>
                <?php endif;?>
            </div>
        </div>
        <div class="col-xs-3 text-right">
            <?php echo elgg_view('input/submit',
                array(
                    'value' => elgg_echo('change'),
                    'class' => "btn btn-primary margin-top-15"
                ));
            ?>
        </div>
    </div>
</div>