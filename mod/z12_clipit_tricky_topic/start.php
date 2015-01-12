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
    elgg_register_action("example/save", "{$plugin_dir}/actions/example/save.php");
    elgg_register_action("example/remove", "{$plugin_dir}/actions/example/remove.php");
    elgg_register_ajax_view('examples/summary');

    elgg_register_action("stumbling_blocks/link", "{$plugin_dir}/actions/stumbling_blocks/link.php");

    elgg_register_action("tricky_topic/save", "{$plugin_dir}/actions/tricky_topic/save.php");
    elgg_register_action("tricky_topic/remove", "{$plugin_dir}/actions/tricky_topic/remove.php");

    elgg_extend_view("js/activity", "js/tricky_topic");
}

/**
 * @param $page
 */
function tt_page_handler($page){
    $sidebar = elgg_view_module('aside', elgg_echo('menu'), elgg_view('tricky_topics/sidebar/menu'),
        array('class' => 'activity-group-block margin-bottom-10 aside-tree')
    );
    $selected_tab = get_input('filter', 'all');
    $filter = elgg_view('tricky_topics/filter', array('selected' => $selected_tab, 'href' => $page[0]));
    $count = 0;
    $params = array();
    $view = $page[0];

    switch($page[0]){
        case '':
            $title = elgg_echo('tricky_topics');
            if(isset($page[1]) && $page[1] == 'view' && $id = $page[2]){
                var_dump($page);
            }
            $view = "tricky_topics";
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
            $content = elgg_view('stumbling_blocks/list', array('entities' => $entities, 'count' => $count));
            break;
        case 'examples':
            $title = elgg_echo('student_problems');
            $entities = ClipitExample::get_all();
            $count = count($entities);
            $entities = array_slice($entities, clipit_get_offset(), clipit_get_limit(10));
            $content = elgg_view('examples/list', array('entities' => $entities, 'count' => $count));
            switch($page[1]){
                case 'create':
                    // Create Example
                    $filter = '';
                    elgg_push_breadcrumb(elgg_echo('examples'), "tricky_topics/examples");
                    $title = elgg_echo('example:create');
                    elgg_push_breadcrumb($title);
                    $content = elgg_view_form('example/save',
                        array(
                            'enctype' => 'multipart/form-data',
                            'data-validate' => 'true'
                        ),
                        array('submit_value' => elgg_echo('create')));
                    break;
                case 'edit':
                    // Edit Example
                    if(!$id = $page[2]){
                        return false;
                    }
                    $example = array_pop(ClipitExample::get_by_id(array($id)));
                    $filter = '';
                    elgg_push_breadcrumb(elgg_echo('examples'), "tricky_topics/examples");
                    elgg_push_breadcrumb($example->name, "tricky_topics/examples/view/{$example->id}");
                    $title = elgg_echo('edit');
                    elgg_push_breadcrumb($title);
                    $multimedia = array(
                        'videos' => array(),
                        'files' => array(),
                        'storyboards' => array(),
                    );
                    $multimedia['videos'] = array_merge($multimedia['videos'], $example->video_array);
                    $multimedia['files'] = array_merge($multimedia['files'], $example->file_array);
                    $multimedia['storyboards'] = array_merge($multimedia['storyboards'], $example->storyboard_array);
                    $content = elgg_view_form('example/save',
                        array(
                            'data-validate' => 'true',
                            'enctype' => 'multipart/form-data',
                        ),
                        array(
                            'entity' => $example,
                            'multimedia' => $multimedia,
                            'submit_value' => elgg_echo('save')
                        ));
                    break;
                case 'view':
                    if($id = $page[2]) {
                        $filter = '';
                        if ($example = array_pop(ClipitExample::get_by_id(array($id)))) {
                            elgg_push_breadcrumb(elgg_echo('student_problems'), "tricky_topics/examples");
                            $title = $example->name;
                            elgg_push_breadcrumb($title);
                            $entities = $example;
                            $multimedia = array(
                                'videos' => array(),
                                'files' => array(),
                                'storyboards' => array(),
                            );
                            $multimedia['videos'] = array_merge($multimedia['videos'], $example->video_array);
                            $multimedia['files'] = array_merge($multimedia['files'], $example->file_array);
                            $multimedia['storyboards'] = array_merge($multimedia['storyboards'], $example->storyboard_array);
                            $content = elgg_view('examples/view',
                                array(
                                    'entity' => $example,
                                    'multimedia' => $multimedia
                                ));
                        } else {
                            return false;
                        }
                    }
                    break;
            }
            break;
        case 'create':
            // Create Tricky Topic
            $filter = '';
            elgg_push_breadcrumb(elgg_echo('tricky_topics'), "tricky_topics");
            $title = elgg_echo('tricky_topic:create');
            elgg_push_breadcrumb($title);
            $content = elgg_view_form('tricky_topic/save',
                array('data-validate' => 'true'),
                array('submit_value' => elgg_echo('create'))
                );
            if($id = $page[1]){
                $tricky_topic = array_pop(ClipitTrickyTopic::get_by_id(array($id)));
                elgg_pop_breadcrumb($title);
                elgg_push_breadcrumb($tricky_topic->name, "tricky_topics/view/{$tricky_topic->id}");
                $title = elgg_echo('duplicate');
                elgg_push_breadcrumb($title);
                $content = elgg_view_form('tricky_topic/save',
                    array('data-validate' => 'true'),
                    array(
                        'entity' => $tricky_topic,
                        'clone' => true,
                        'submit_value' => elgg_echo('create')
                    ));
            }
            break;
        case 'edit':
            // Edit Tricky Topic
            if(!$id = $page[1]){
                return false;
            }
            $tricky_topic = array_pop(ClipitTrickyTopic::get_by_id(array($id)));
            $filter = '';
            elgg_push_breadcrumb(elgg_echo('tricky_topics'), "tricky_topics");
            elgg_push_breadcrumb($tricky_topic->name, "tricky_topics/view/{$tricky_topic->id}");
            $title = elgg_echo('edit');
            elgg_push_breadcrumb($title);
            $content = elgg_view_form('tricky_topic/save',
                array('data-validate' => 'true'),
                array('entity' => $tricky_topic, 'submit_value' => elgg_echo('save')
                ));
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
//                    $sidebar .= elgg_view_module('aside', '<i class="fa fa-clock-o"></i> Revisions',
//                        elgg_view('tricky_topics/sidebar/revisions'));
                    $examples = ClipitExample::get_by_tags($tricky_topic->tag_array);
                    $content = elgg_view('tricky_topics/view',
                        array(
                            'entity' => $tricky_topic,
                            'multimedia' => $multimedia,
                            'examples' => $examples
                        ));
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
            $content = elgg_view($view.'/list', array('entities' => $entities, 'count' => $count));
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