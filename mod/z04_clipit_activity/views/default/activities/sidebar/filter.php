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
$tags = implode(",", get_search_input('tags'));

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
$activity_type_array = array(
    '' => elgg_echo('all'),
    '1' => elgg_echo('activity:register:open'),
    '-1' => elgg_echo('activity:register:closed'),
);
echo elgg_view("input/hidden", array(
    'name' => 'page',
    'value' => 'activities'
));
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
        'name' => 'search[name]',
        'class' => 'form-control',
        'value' => get_search_input('name')
    ));
    ?>
</div>
<div class="form-group">
    <label class="text-muted"><?php echo elgg_echo('tricky_topic');?></label>
    <?php echo elgg_view("input/text", array(
        'name' => 'search[tricky_topic]',
        'class' => 'form-control',
        'value' => get_search_input('tricky_topic')
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
        'name' => 'search[teacher]',
        'style' => 'padding: 0;height: 25px;',
        'value' => get_search_input('teacher'),
        'class' => 'form-control',
        'options_values' => $teachers,
    ));
    ?>
</div>
<div class="form-group">
    <label class="text-muted"><?php echo elgg_echo('activity:status');?></label>
    <?php echo elgg_view("input/dropdown", array(
        'name' => 'search[status]',
        'style' => 'padding: 0;height: 25px;',
        'value' => get_search_input('status'),
        'class' => 'form-control',
        'options_values' => $status_array,
    ));
    ?>
</div>
<div class="form-group">
    <label class="text-muted"><?php echo elgg_echo('activity:register:title');?></label>
    <?php echo elgg_view("input/dropdown", array(
        'name' => 'search[public]',
        'style' => 'padding: 0;height: 25px;',
        'value' => get_search_input('public'),
        'class' => 'form-control',
        'options_values' => $activity_type_array,
    ));
    ?>
</div>
<div class="text-right">
    <?php echo elgg_view('input/submit', array(
        'class' => 'btn btn-primary btn-sm',
        'value'  => elgg_echo('search:btn'),
    ));
    ?>
</div>