<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   28/01/2015
 * Last update:     28/01/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$tags = get_input('tags');
$teachers = array('' => elgg_echo('all'));
$teachers_role = array_pop(ClipitUser::get_by_role(array(ClipitUser::ROLE_TEACHER)));
foreach($teachers_role as $teacher){
    $teachers[$teacher->id] = $teacher->name;
}

$status_array = array(
    '' => elgg_echo('all'),
    ClipitActivity::STATUS_ACTIVE => elgg_echo('status:active'),
    ClipitActivity::STATUS_ENROLL => elgg_echo('status:enroll'),
    ClipitActivity::STATUS_CLOSED => elgg_echo('status:closed'),
);
?>
<?php
echo elgg_view("input/hidden", array(
    'name' => 'tags',
    'id' => 'input_tags',
    'value' => $tags
));
?>
<div class="form-group">
    <label class="text-muted"><?php echo elgg_echo('activity:title');?></label>
    <?php echo elgg_view("input/text", array(
        'name' => 'activity',
        'class' => 'form-control',
        'value' => get_input('activity')
    ));
    ?>
</div>
<div class="form-group">
    <label class="text-muted"><?php echo elgg_echo('tricky_topic');?></label>
    <?php echo elgg_view("input/text", array(
        'name' => 'tricky_topic',
        'class' => 'form-control',
        'value' => get_input('tricky_topic')
    ));
    ?>
</div>
<div class="form-group">
    <label class="text-muted"><?php echo elgg_echo('tags');?></label>
    <ul id="tags"></ul>
</div>
<div class="form-group">
    <label class="text-muted"><?php echo elgg_echo('teacher');?></label>
    <?php echo elgg_view("input/dropdown", array(
        'name' => 'teacher',
        'style' => 'padding: 0;height: 25px;',
        'value' => get_input('teacher'),
        'class' => 'form-control',
        'options_values' => $teachers,
    ));
    ?>
</div>
<div class="form-group">
    <label class="text-muted"><?php echo elgg_echo('activity:status');?></label>
    <?php echo elgg_view("input/dropdown", array(
        'name' => 'status',
        'style' => 'padding: 0;height: 25px;',
        'value' => get_input('status'),
        'class' => 'form-control',
        'options_values' => $status_array,
    ));
    ?>
</div>
<div class="text-right">
    <?php echo elgg_view('input/submit', array(
        'class' => 'btn btn-primary btn-sm',
        'value'  => elgg_echo('search'),
    ));
    ?>
</div>