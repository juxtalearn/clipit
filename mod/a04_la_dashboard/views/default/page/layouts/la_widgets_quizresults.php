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

elgg_load_css('dashboardcss');
$num_columns = elgg_extract('num_columns', $vars, 3);
$show_add_widgets = elgg_extract('show_add_widgets', $vars, true);
$exact_match = elgg_extract('exact_match', $vars, false);
$show_access = elgg_extract('show_access', $vars, false);

$owner = elgg_get_page_owner_entity();

$widget_types = elgg_get_widget_types();

$context = elgg_get_context();
elgg_push_context('widgets');


$user = elgg_get_logged_in_user_entity();
$pageowner = elgg_get_page_owner_entity();
if ( is_not_null($user) && is_not_null($pageowner)) {

    switch ($context) {
        case 'quizstudents':
            $widgets_columns = elgg_get_widgets($pageowner->getGUID(), $context);
            $found = false;
            foreach ($widgets_columns as $widgets) {
                foreach ($widgets as $widget) {
                    if ($widget->handler == 'quizresult') {
                        $found = true;
                        break 2;
                    }
                }
            }
            if (!$found) {
                $widgetguid = elgg_create_widget($pageowner->getGUID(), 'quizresult', $context);
                if ($widgetguid) {
                    $widget = get_entity($widgetguid);
                    $widget->activity_id = $pageowner->getGUID();
                    $widget->question_or_stumblingblock = ClipitTag::SUBTYPE;
                    $widget->scale = ClipitGroup::SUBTYPE;
                    $widget->group_id = 'all';
                    // position the widget
                    $widget->move(1, 0);
                    $widget->save();
                }
            }
            break;
        case 'quizgroups':
            $widgets_columns = elgg_get_widgets($pageowner->getGUID(), $context);
            $found = false;
            foreach ($widgets_columns as $widgets) {
                foreach ($widgets as $widget) {
                    if ($widget->handler == 'quizresult') {
                        $found = true;
                        break 2;
                    }
                }
            }
            if (!$found) {
                $widgetguid = elgg_create_widget($pageowner->getGUID(), 'quizresult', $context);
                if ($widgetguid) {
                    $widget = get_entity($widgetguid);
                    $widget->activity_id = $pageowner->getGUID();
                    $widget->question_or_stumblingblock = ClipitTag::SUBTYPE;
                    $widget->scale = ClipitActivity::SUBTYPE;
                    $widget->group_id = 'all';
                    // position the widget
                    $widget->move(1, 0);
                    $widget->save();
                }
            }
            break;
        case 'quizactivity':
            $widgets_columns = elgg_get_widgets($pageowner->getGUID(), $context);
            $found = false;
            foreach ($widgets_columns as $widgets) {
                foreach ($widgets as $widget) {
                    if ($widget->handler == 'quizresult') {
                        $found = true;
                        break 2;
                    }
                }
            }
            if (!$found) {
                $widgetguid = elgg_create_widget($pageowner->getGUID(), 'quizresult', $context);
                if ($widgetguid) {
                    $widget = get_entity($widgetguid);
                    $widget->activity_id = $pageowner->getGUID();
                    $widget->question_or_stumblingblock = ClipitQuizQuestion::SUBTYPE;
                    $widget->scale = ClipitGroup::SUBTYPE;
                    $widget->group_id = 'all';
                    // position the widget
                    $widget->move(1, 0);
                    $widget->save();
                }
            }
            break;
    }
}

$widgets = elgg_get_widgets($owner->guid, $context);
if (elgg_can_edit_widget_layout($context)) {
    if ($show_add_widgets) {
        echo elgg_view('page/layouts/widgets/add_button', array('panel_id'=>$context));
    }
    $params = array(
        'widgets' => $widgets,
        'context' => $context,
        'exact_match' => $exact_match,
        'show_access' => $show_access,
    );
    echo  elgg_view('page/layouts/widgets/add_panel', $params);
}

echo $vars['content'];

$widget_class = "elgg-col-1of{$num_columns}";
// Grid bootstrap, 12 columns total
$single_column = round(12/$num_columns, 0, PHP_ROUND_HALF_UP);
echo '<div class="row">';
for ($column_index = 1; $column_index <= $num_columns; $column_index++) {
    if (isset($widgets[$column_index])) {
        $column_widgets = $widgets[$column_index];
    } else {
        $column_widgets = array();
    }

    echo "<div class=\"$widget_class  col-xs-$single_column col-sm-$single_column col-md-$single_column\" id=\"elgg-widget-col-$column_index-$context\">";
    if (sizeof($column_widgets) > 0) {
        foreach ($column_widgets as $widget) {
            if (array_key_exists($widget->handler, $widget_types)) {
                echo elgg_view_entity($widget, array('show_access' => $show_access));
            }
        }
    }
    echo '</div>';
}
echo '</div>';

elgg_pop_context();

echo elgg_view('graphics/ajax_loader', array('id' => 'elgg-widget-loader'));
