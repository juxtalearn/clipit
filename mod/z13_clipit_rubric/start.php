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
}

/**
 * @param $page
 */
function rubric_page_handler($page){
    elgg_set_context('authoring');
    $filter = '';
    $sidebar = elgg_view_module('aside', elgg_echo('teacher:authoring_tools'),
        elgg_view('tricky_topics/sidebar/menu').
        elgg_view('quiz/sidebar/menu').
        elgg_view('rubric/sidebar/menu'),
        array('class' => 'activity-group-block margin-bottom-10 aside-tree')
    );
    $search_menu = elgg_view_module('aside', elgg_echo('filter'),
        elgg_view_form(
            'filter_search',
            array(
                'method' => 'POST',
                'id' => 'add_labels',
                'style' => 'background: #fff;padding: 15px;',
                'body' => elgg_view('forms/quiz/filter')
            )
        ));
    if($page[0]){
        $search_menu = false;
    }
    $language_index = ClipitPerformanceItem::get_language_index(get_current_language());
    switch($page[0]){
        case '':
            $title = elgg_echo('rubrics');
            $selected_tab = get_input('filter', 'all');
            $filter = '';
            if($search = get_input('s')) {
                $entities = quiz_filter_search($search);
                $entities = ClipitQuiz::get_by_id($entities);
            } else {
//                $entities = ClipitPerformanceItem::get_from_category(null, $language_index);
                $all_entities = ClipitPerformanceItem::get_all(0, 0, 'name');
            }
            $count = count($all_entities);
            $entities = array_slice($all_entities, clipit_get_offset(), clipit_get_limit(10));
            $content = elgg_view('rubric/list', array('entities' => $entities, 'count' => $count));
            break;
        case 'edit':
            // Edit Rubric
            if(!$id = $page[1]){
                return false;
            }
            $rubric = array_pop(ClipitPerformanceItem::get_by_id(array($id)));
            $filter = '';
            elgg_push_breadcrumb(elgg_echo('rubrics'), "rubrics");
            elgg_push_breadcrumb($rubric->item_name[$language_index], "rubrics/view/{$rubric->id}");
            $title = elgg_echo('edit');
            elgg_push_breadcrumb($title);
            $content = elgg_view_form('rubric/save',
                array('data-validate' => 'true'),
                array('entity' => $rubric, 'submit_value' => elgg_echo('save')
                ));
            break;
        case 'create':
            $title = elgg_echo('rubric:create');
            elgg_push_breadcrumb(elgg_echo('rubrics'), "rubrics");
            elgg_push_breadcrumb($title);
            $content = elgg_view_form('rubric/create',
                array('data-validate' => 'true'),
                array('submit_value' => elgg_echo('create'))
            );
            break;
            case 'view':
                $id = $page[1];
                if(!$id){
                    return false;
                }
                elgg_push_breadcrumb(elgg_echo('rubrics'), "rubrics");
                if ($rubric = array_pop(ClipitPerformanceItem::get_by_id(array($id)))) {
                    $title = $rubric->item_name[$language_index];
                    elgg_push_breadcrumb($title);
                    $content = elgg_view('rubric/view', array('entity' => $rubric));
                } else{
                    return false;
                }
            break;
        default:
            return false;
            break;
    }
    switch($selected_tab){
        case 'mine':
            $owner = array();
            foreach($all_entities as $entity){
                if($entity->owner_id == elgg_get_logged_in_user_guid()){
                    $owner[] = $entity;
                }
            }
            $count = count($owner);
            $entities = array_slice($owner, clipit_get_offset(), clipit_get_limit(10));
            $content = elgg_view('quiz/list', array('entities' => $entities, 'count' => $count));
            break;
    }
    $params = array(
        'content' => $content,
        'title' => $title,
        'filter' => $filter,
        'sidebar' => $sidebar.$search_menu,
    );
    $body = elgg_view_layout('one_sidebar', $params);

    echo elgg_view_page($title, $body);
}