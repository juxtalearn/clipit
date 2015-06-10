<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   20/05/14
 * Last update:     20/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
elgg_register_event_handler('init', 'system', 'clipit_rubric_init');

function clipit_rubric_init() {
    $plugin_dir = elgg_get_plugins_path() . "z13_clipit_rubric";
    // Register "/rubrics" page handler
    elgg_register_page_handler('rubrics', 'rubric_page_handler');
    elgg_register_action("rubric/save", "{$plugin_dir}/actions/rubric/save.php");

    if(get_config("rubric_tool")) {
        // Sidebar menu
        elgg_extend_view('authoring_tools/sidebar/menu', 'rubric/sidebar/menu', 300);
    }
    elgg_register_ajax_view('rubric/items');
    elgg_extend_view('js/clipit', 'js/rubric');
}

/**
 * @param $page
 */
function rubric_page_handler($page){
    elgg_set_context('authoring');
    $filter = '';
    $sidebar = elgg_view_module('aside', elgg_echo('teacher:authoring_tools'),
        elgg_view('authoring_tools/sidebar/menu'),
        array('class' => 'activity-group-block margin-bottom-10 aside-tree')
    );

    switch($page[0]){
        case '':
            $title = elgg_echo('rubrics');
            $filter = '';
            $all_entities = ClipitRubricItem::get_by_owner();
            $count = count($all_entities);
            $entities = array_slice($all_entities, clipit_get_offset(), clipit_get_limit(10), true);
            $content = elgg_view('rubric/list', array('entities' => $entities, 'count' => $count));
            break;
        case 'edit':
            // Edit Rubric
            $title = elgg_echo('edit');
            elgg_push_breadcrumb(elgg_echo('rubrics'), "rubrics");
            elgg_push_breadcrumb($title);
            $entities = array_pop(ClipitRubricItem::get_by_owner(array(elgg_get_logged_in_user_guid()), 0, 0, 'time_created', false));
            $content = elgg_view_form('rubric/save',
                array('data-validate' => 'true'),
                array('entities' => $entities, 'submit_value' => elgg_echo('save')
                ));
            break;
        case 'create':
            $title = elgg_echo('rubric:create');
            elgg_push_breadcrumb(elgg_echo('rubrics'), "rubrics");
            elgg_push_breadcrumb($title);
            $entities = array('' => array_fill(0, 5, ''));
            $content = elgg_view_form('rubric/save',
                array('data-validate' => 'true'),
                array('submit_value' => elgg_echo('create'), 'entities' => $entities)
            );
            break;
            case 'view':
                $category_name = json_decode(get_input('name'));
                $entities = ClipitPerformanceItem::get_from_category($category_name, get_current_language());
                elgg_push_breadcrumb(elgg_echo('rubrics'), "rubrics");
                    $title = $category_name;
                    elgg_push_breadcrumb($title);
                    $content = elgg_view('rubric/view', array('entities' => $entities));

            break;
        default:
            return false;
            break;
    }

    $params = array(
        'content' => $content,
        'title' => $title,
        'filter' => $filter,
        'sidebar' => $sidebar,
    );
    $body = elgg_view_layout('one_sidebar', $params);

    echo elgg_view_page($title, $body);
}