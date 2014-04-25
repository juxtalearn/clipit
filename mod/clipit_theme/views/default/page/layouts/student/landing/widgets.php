<?php
/**
 * Elgg widgets layout
 *
 * @uses $vars['content']          Optional display box at the top of layout
 * @uses $vars['num_columns']      Number of widget columns for this layout (3)
 * @uses $vars['show_add_widgets'] Display the add widgets button and panel (true)
 * @uses $vars['exact_match']      Widgets must match the current context (false)
 * @uses $vars['show_access']      Show the access control (true)
 */

$num_columns = elgg_extract('num_columns', $vars, 3);
$show_add_widgets = elgg_extract('show_add_widgets', $vars, true);
$exact_match = elgg_extract('exact_match', $vars, false);
$show_access = elgg_extract('show_access', $vars, true);
$role = elgg_extract('role', $vars, true);
$landing_path = $role."/landing";

$owner = elgg_get_page_owner_entity();

$widget_types = elgg_get_widget_types();

$context = elgg_get_context();
elgg_push_context('widgets');

$widgets = elgg_get_widgets($owner->guid, $context);

if (elgg_can_edit_widget_layout($context)) {
    if ($show_add_widgets) {
        echo elgg_view('page/layouts/widgets/add_button');
    }
    $params = array(
        'widgets' => $widgets,
        'context' => $context,
        'exact_match' => $exact_match,
        'show_access' => $show_access,
    );
    //echo elgg_view('page/layouts/widgets/add_panel', $params);
}

echo $vars['content'];

$options = array(
    'type' => 'object',
    'subtype' => 'widget',
    'owner_guid' => $owner->guid,
    'private_setting_name' => 'context',
    'private_setting_value' => $context,
    'limit' => 0
);
$widgets_user = elgg_get_entities_from_private_settings($options);
$widget = array();

foreach ($widgets_user as $widget_user){
    $widget[$widget_user->handler] = $widget_user;
}


elgg_pop_context();

echo elgg_view('graphics/ajax_loader', array('id' => 'elgg-widget-loader'));
?>


<div class="col-md-4">
    <?php echo elgg_view_entity($widget['student/landing/events'], array('show_access' => $show_access)); ?>
</div>

<div class="col-md-8">
    <div class="col-md-6">
        <?php echo elgg_view_entity($widget['student/landing/activity_status'], array('show_access' => $show_access)); ?>
        <?php echo elgg_view_entity($widget['student/landing/pending'], array('show_access' => $show_access)); ?>
    </div>
    <div class="col-md-6">
        <?php echo elgg_view_entity($widget['student/landing/group_activity'], array('show_access' => $show_access)); ?>
        <?php echo elgg_view_entity($widget['student/landing/recommended_videos'], array('show_access' => $show_access)); ?>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php echo elgg_view_entity($widget['student/landing/tags'], array('show_access' => $show_access)); ?>
        </div>
    </div>
</div>