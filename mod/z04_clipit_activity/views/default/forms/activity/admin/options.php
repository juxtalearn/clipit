<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   15/07/2015
 * Last update:     15/07/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity = elgg_extract('entity', $vars);
if($entity) {
    echo elgg_view('input/hidden', array(
        'name' => 'activity[id]',
        'value' => $entity->id
    ));
}
?>
<div class="row margin-bottom-10">
    <div class="col-xs-5">
        <label><?php echo elgg_echo('activity:register:title');?></label>
        <small>Cualquier estudiante del sitio puede entrar a la actividad sólo si se encuentra en modo inscripción</small>
    </div>
    <div class="col-xs-7">
        <label id="input-activity-open" class="inline-block margin-right-20" onclick="javascript:$('#open_activity').collapse('show');">
            <input type="radio"
                   name="activity[is_open]"
                <?php echo $entity->is_open ? 'checked':'';?>
                   value="1">
            <i class="fa fa-unlock text-muted"></i> <?php echo elgg_echo('activity:register:open');?>
        </label>
        <label id="input-activity-closed" class="inline-block" onclick="javascript:$('#open_activity').collapse('hide');">
            <input type="radio"
                   name="activity[is_open]"
                <?php echo $entity->is_open ? '':'checked';?>
                   value="0">
            <i class="fa fa-lock text-muted"></i> <?php echo elgg_echo('activity:register:closed');?>
        </label>
        <div class="<?php echo !$entity->is_open ? 'collapse':'in';?> col-md-12" id="open_activity" style="background-color: #f4f4f4;padding-top: 10px;padding-bottom: 10px;">
            <div class="row form-group">
                <div class="col-md-8">
                    <label for="activity[max_group_size]">Máximo de estudiantes por grupo</label>
                </div>
                <div class="col-md-4">
                    <?php echo elgg_view("input/text", array(
                        'name' => 'activity[max_group_size]',
                        'class' => 'form-control',
                        'value' => $entity->max_group_size,
                        'required' => true,
                        'maxlength' => 3,
                        'data-rule-number' => true
                    ));
                    ?>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-8">
                    <label for="activity[max_students]">Máximo de estudiantes en la actividad</label>
                    <small>0 = Sin límite de estudiantes</small>
                </div>
                <div class="col-md-4">
                    <?php echo elgg_view("input/text", array(
                        'name' => 'activity[max_students]',
                        'class' => 'form-control',
                        'value' => $entity->max_students ? $entity->max_students:0,
                        'required' => true,
                        'maxlength' => 3,
                        'data-rule-number' => true
                    ));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<hr class="margin-bottom-5 margin-top-5">
<?php if($vars['submit']):?>
    <div class="text-right">
        <?php
        echo elgg_view('input/submit', array(
            'value' => elgg_echo('save'),
            'class' => "btn btn-primary",
        ));
        ?>
    </div>
<?php endif;?>