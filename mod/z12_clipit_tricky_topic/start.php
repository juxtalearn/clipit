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
elgg_register_event_handler('init', 'system', 'clipit_ttt_init');

function clipit_ttt_init() {
    // Register "/ttq" page handler
    elgg_register_page_handler('tricky_topics', 'tt_page_handler');
    $plugin_dir = elgg_get_plugins_path() . "z12_clipit_tricky_topic";
    elgg_register_action("example/create", "{$plugin_dir}/actions/example/create.php");
    elgg_register_ajax_view('examples/list');

    elgg_register_action("stumbling_blocks/link", "{$plugin_dir}/actions/stumbling_blocks/link.php");
}

/**
 * @param $page
 */
function tt_page_handler($page){
    $sidebar = elgg_view_module('aside', elgg_echo('menu'), elgg_view('tricky_topics/sidebar/menu'),
        array('class' => 'activity-group-block margin-bottom-10')
    );
    $selected_tab = get_input('filter', 'all');
    $filter = elgg_view('tricky_topics/filter', array('selected' => $selected_tab, 'href' => $page[0]));
    $count = 0;
    $params = array();
    switch($page[0]){
        case '':
            $title = "Tricky Topics";
            if(isset($page[1]) && $page[1] == 'view' && $id = $page[2]){
                var_dump($page);
            }
            $entities = ClipitTrickyTopic::get_all();
            $count = count($entities);
            $entities = array_slice($entities, clipit_get_offset(), clipit_get_limit(10));
            $content = elgg_view('tricky_topics/list', array('entities' => $entities, 'count' => $count));
            break;
        case 'stumbling_blocks':
            $title = elgg_echo('tags');
            $entities = ClipitTag::get_all();
            $count = count($entities);
            $entities = array_slice($entities, clipit_get_offset(), clipit_get_limit());
            $content = elgg_view('stumbling_blocks/view', array('entities' => $entities, 'count' => $count));
            break;
        case 'student_problems':
            $title = elgg_echo('student_problems');
            $content = elgg_view('examples/view');
            break;
        case 'create':
            // Create Tricky Topic
            $filter = '';
            $title = elgg_echo('tricky_topic:create');
            $content = elgg_view_form('tricky_topic/create');
            break;
        case 'view':
            // View Tricky Topic
            if($id = $page[1]){
                $filter = '';
                if($tricky_topic = array_pop(ClipitTrickyTopic::get_by_id(array($id)))){
                    elgg_push_breadcrumb(elgg_echo('tricky_topics'), "tricky_topics");
                    $title  = $tricky_topic->name;
                    elgg_push_breadcrumb($title);
                    $entities = $tricky_topic;
                    $activities = ClipitActivity::get_from_tricky_topic($tricky_topic->id);
                    $multimedia = array(
                        'videos' => array(),
                        'files' => array(),
                        'storyboards' => array(),
                    );
                    foreach($activities as $activity){
                        $multimedia['videos'] = array_merge($multimedia['videos'], $activity->video_array);
                        $multimedia['files'] = array_merge($multimedia['files'], $activity->file_array);
                        $multimedia['storyboards'] = array_merge($multimedia['storyboards'], $activity->storyboard_array);
                    }
                    $sidebar .= elgg_view_module('aside', '<i class="fa fa-clock-o"></i> Revisions',
                        elgg_view('tricky_topics/sidebar/revisions'));
                    $content = elgg_view('tricky_topics/view', array('entity' => $tricky_topic, 'multimedia' => $multimedia));
                } else {
                    return false;
                }
            }
            break;
        default:
            return false;
            break;
    }
    switch($selected_tab){
        case 'mine':
            $owner = array();
            foreach($entities as $entity){
                if($entity->owner_id == elgg_get_logged_in_user_guid()){
                    $owner[] = $entity;
                }
            }
            $entities = $owner;
            $content = elgg_view('stumbling_blocks/view', array('entities' => $entities, 'count' => $count));
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