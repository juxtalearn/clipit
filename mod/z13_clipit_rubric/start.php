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
    elgg_register_action("rubric/remove", "{$plugin_dir}/actions/rubric/remove.php");

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
            $selected_tab = get_input('filter', 'all');
            $filter = elgg_view('navigation/tabs', array('selected' => $selected_tab, 'href' => $page[0]));
            if($selected_tab == 'mine'){
                $all_entities = array_pop(ClipitRubric::get_by_owner(array(elgg_get_logged_in_user_guid())));
                $count = count($all_entities);
                $entities = array_slice($all_entities, clipit_get_offset(), clipit_get_limit(10), true);
            } else {
                $all_entities = ClipitRubric::get_all();
                $count = count($all_entities);
                $entities = array_slice($all_entities, clipit_get_offset(), clipit_get_limit(10), true);
            }
            $content = elgg_view('rubric/list', array('entities' => $entities, 'count' => $count));
            break;
        case 'edit':
            // Edit Rubric
            $title = elgg_echo('edit');
            $entity_id = $page[1];
            elgg_push_breadcrumb(elgg_echo('rubrics'), "rubrics");
            elgg_push_breadcrumb($title);
            $entity = array_pop(ClipitRubric::get_by_id(array($entity_id)));

            $content = elgg_view_form('rubric/save',
                array('data-validate' => 'true'),
                array('entity' => $entity, 'submit_value' => elgg_echo('save')
                ));
            break;
        case 'create':
            elgg_push_breadcrumb(elgg_echo('rubrics'), "rubrics");
            if($id = $page[1]){
                $rubric_id = ClipitRubric::create_clone($id, false);
                $rubric = array_pop(ClipitRubric::get_by_id(array($rubric_id)));
                $title = '['.elgg_echo('clone').'] '.$rubric->name;
                ClipitRubric::set_properties($rubric->id, array('name' => $title, 'time_created' => time()));

                $rubric = array_pop(ClipitRubric::get_by_id(array($rubric->id)));
                elgg_push_breadcrumb($rubric->name, "rubrics/view/".$rubric->id);
                $content = elgg_view_form('rubric/save',
                    array('data-validate' => 'true'),
                    array('entity' => $rubric, 'submit_value' => elgg_echo('save'))
                );
            } else {
                $title = elgg_echo('rubric:create');
                $content = elgg_view_form('rubric/save',
                    array('data-validate' => 'true'),
                    array('submit_value' => elgg_echo('create'), 'create' => true)
                );
            }
            elgg_push_breadcrumb($title);
            break;
            case 'view':
                $rubric_id = $page[1];
                $entity = array_pop(ClipitRubric::get_by_id(array($rubric_id)));
                elgg_push_breadcrumb(elgg_echo('rubrics'), "rubrics");
                $title = $entity->name;
                elgg_push_breadcrumb($title);
                $content = elgg_view('rubric/view', array('entity' => $entity));
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