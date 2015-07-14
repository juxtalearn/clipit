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
    elgg_register_library('clipit:rubric:functions', "{$plugin_dir}/lib/functions.php");
    elgg_load_library('clipit:rubric:functions');
    // Register "/rubrics" page handler
    elgg_register_page_handler('rubrics', 'rubric_page_handler');
    elgg_register_action("rubric/save", "{$plugin_dir}/actions/rubric/save.php");
    elgg_register_action("rubric/remove", "{$plugin_dir}/actions/rubric/remove.php");
    // Sidebar menu
    elgg_extend_view('authoring_tools/sidebar/menu', 'rubric/sidebar/menu', 300);

    elgg_register_ajax_view('rubric/items');
    elgg_register_ajax_view('rubric/list');
    elgg_extend_view('js/clipit', 'js/rubric');

    // hook action: Task type rubric
    elgg_register_plugin_hook_handler("task:save:upload", "feedback", "task_rubric_create");
    elgg_register_plugin_hook_handler("task:save", "task", "task_rubric_save");

    elgg_extend_view('tasks/container', 'tasks/container/feedback_rubric');
}
function task_rubric_create($hook, $entity_type, $returnvalue, $params){
    $feedback = $params['feedback_form'];

    if ($feedback['title'] && $feedback['type'] && $feedback['start'] && $feedback['end']) {
        $rubric_id = '';

        if($feedback['rubric']){
            $rubric_id = ClipitRubric::create_clone($feedback['rubric']);
        }
        // New task, attach resources
        $task_properties = array_merge(get_task_properties_action($feedback), array(
            'task_type' => $feedback['type'],
            'parent_task' => $params['parent_id'],
            'rubric' => $rubric_id
        ));
        $task_id = ClipitTask::create($task_properties);
        ClipitActivity::add_tasks($params['activity_id'], array($task_id));
    }
}
function task_rubric_save($hook, $entity_type, $returnvalue, $params){
    $task = $params['task'];
    $activity_id = $params['activity_id'];

    if($task['feedback-form'] && $task['title'] == "") {
        $task = $task['feedback-form'];
    }

    if(
        ( $task['entity_type'] == ClipitTask::TYPE_VIDEO_FEEDBACK ||
        $task['entity_type'] == ClipitTask::TYPE_FILE_FEEDBACK )
    ){
        $properties = get_task_properties_action($task);
        // Edit task
        $task_id = get_input('task-id');

        if($rubric = $task['rubric']) {
            if(is_array($rubric)) {
                // Edit/add rubric items
                $rubric_items = $rubric['item'];
                $rubric_item_array = array();
                foreach ($rubric_items as $rubric_item) {
                    $data = array(
                        'name' => $rubric_item['name'],
                        'level_array' => $rubric_item['level']
                    );

                    if ($rubric_item['id']) {
                        if ($rubric_item['remove'] == 1) {
                            ClipitRubricItem::delete_by_id(array($rubric_item['id']));
                        } else {
                            $rubric_item_array[] = $rubric_item['id'];
                            ClipitRubricItem::set_properties($rubric_item['id'], $data);
                        }
                    } else {
                        $rubric_item_array[] = ClipitRubricItem::create($data);
                    }
                }
                ClipitRubric::add_rubric_items($rubric['id'], $rubric_item_array);
                ClipitRubric::set_properties($rubric['id'], array('name' => $rubric['name']));
            } else {
                // New rubric selected
                $properties = array_merge($properties, array(
                    'rubric' => ClipitRubric::create_clone($rubric)
                ));
            }
        }

        // Save task
        ClipitTask::set_properties($task_id, $properties);
    }
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
                $entities = array_pop(ClipitRubric::get_by_owner(array(elgg_get_logged_in_user_guid())));
            } elseif($search = get_input('s')) {
                $entities = rubric_filter_search($search);
                $entities = ClipitRubric::get_by_id($entities);
            } else {
                $entities = ClipitRubric::get_all(0, 0, '', true, false, false);
            }
            foreach($entities as $entity){
                if($entity->cloned_from == 0) {
                    $all_entities[] = $entity;
                }
            }
            $count = count($all_entities);
            $entities = array_slice($all_entities, clipit_get_offset(), clipit_get_limit(10), true);
            $content = elgg_view('rubric/list', array('entities' => $entities, 'count' => $count));

            $sidebar .= elgg_view_module('aside', elgg_echo('filter'),
                elgg_view_form(
                    'filter_search',
                    array(
                        'method' => 'POST',
                        'id' => 'add_labels',
                        'style' => 'background: #fff;padding: 15px;',
                        'body' => elgg_view('forms/rubric/filter')
                    )
                ));
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