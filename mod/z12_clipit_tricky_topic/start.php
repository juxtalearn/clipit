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
elgg_register_event_handler('init', 'system', 'clipit_tricky_topic_init');

function clipit_tricky_topic_init() {

    // Register "/tricky_topics" page handler
    elgg_register_page_handler('tricky_topics', 'tt_page_handler');
    $plugin_dir = elgg_get_plugins_path() . "z12_clipit_tricky_topic";
    elgg_register_action("example/save", "{$plugin_dir}/actions/example/save.php");
    elgg_register_action("example/remove", "{$plugin_dir}/actions/example/remove.php");
    elgg_register_ajax_view('examples/summary');

    elgg_register_action("stumbling_blocks/link", "{$plugin_dir}/actions/stumbling_blocks/link.php");
    elgg_register_ajax_view('stumbling_blocks/search');

    elgg_register_action("tricky_topic/save", "{$plugin_dir}/actions/tricky_topic/save.php");
    elgg_register_action("tricky_topic/remove", "{$plugin_dir}/actions/tricky_topic/remove.php");
    elgg_register_ajax_view('tricky_topics/tags/search');

    elgg_extend_view('js/activity', 'js/tricky_topic');
    elgg_register_library('clipit:tricky_topic:functions', "{$plugin_dir}/lib/functions.php");
    elgg_load_library('clipit:tricky_topic:functions');
}

/**
 * @param $page
 */
function tt_page_handler($page){
    elgg_load_js('clipit:tricky_topic');
    $sidebar = elgg_view_module('aside', elgg_echo('menu'), elgg_view('tricky_topics/sidebar/menu'),
        array('class' => 'activity-group-block margin-bottom-10 aside-tree')
    );
    $selected_tab = get_input('filter', 'all');
    $filter = elgg_view('tricky_topics/filter', array('selected' => $selected_tab, 'href' => $page[0]));
    $count = 0;
    $params = array();
    $view = $page[0];
    $tt_sidebar = false;

    $sort = get_input('sort');
    $order_by = get_input('order_by');
    switch($page[0]){
        case '':
            $tt_sidebar = true;
            $title = elgg_echo('tricky_topics');
            $view = "tricky_topics";
            $entities = ClipitTrickyTopic::get_all();

            // Filter search
            $tt_ids = array();
            $tt_ids_search = array();
            if(get_input('tricky_topic')){
                $tt_search = get_input('tricky_topic');
                $tts = ClipitTrickyTopic::get_from_search($tt_search);
                foreach ($tts as $tt) {
                    $tt_ids[] = $tt->id;
                }
            }
            if(get_input('tags')) {
                $tags_title = get_input('tags');
                $tags_title = explode(",", $tags_title);
                foreach ($tags_title as $tag_title) {
                    $tags = ClipitTag::get_from_search($tag_title);
                    foreach ($tags as $tag) {
                        $tt_ids_search = array_merge($tt_ids_search, ClipitTag::get_tricky_topics($tag->id));
                    }
                }
            }

            if(!empty($tt_ids) || !empty($tt_ids_search)){
                $tt_ids = array_merge($tt_ids, $tt_ids_search);
                $entities = ClipitTrickyTopic::get_by_id($tt_ids);
            }
            $count = count($entities);
            if($order_by) {
                entities_order($entities, $order_by, $sort, ClipitTrickyTopic::list_properties());
            }

            $entities = array_slice($entities, clipit_get_offset(), clipit_get_limit(10));

            $to_order = array(
                'name' => elgg_echo('title'),
                'education_level' => elgg_echo('education_level'),
                'subject' => elgg_echo('tricky_topic:subject'),
            );
            $table_orders = table_order($to_order, $order_by, $sort);
            $content = elgg_view('tricky_topics/list', array(
                'entities' => $entities,
                'count' => $count,
                'table_orders' => $table_orders
            ));

            break;
        case 'stumbling_blocks':
            $title = elgg_echo('tags');
            $entities = ClipitTag::get_all();
            $count = count($entities);
            if($order_by){
                entities_order($entities, $order_by, $sort, ClipitTag::list_properties());
            }
            $entities = array_slice($entities, clipit_get_offset(), clipit_get_limit());
            $to_order = array(
                'name' => elgg_echo('title'),
            );
            $table_orders = table_order($to_order, $order_by, $sort);
            $content = elgg_view('stumbling_blocks/list', array(
                'entities' => $entities,
                'count' => $count,
                'table_orders' => $table_orders
            ));
            break;
        case 'examples':
            $title = elgg_echo('student_problems');

            // Filter search
            $example_ids = array();
            $example_ids_search = array();
            if(get_input('example')){
                $example_search = get_input('example');
                $examples = ClipitExample::get_from_search($example_search);
                foreach ($examples as $example) {
                    $example_ids[] = $example->id;
                }
            }

            if(!empty($example_ids) || !empty($example_ids_search)){
                $example_ids = array_merge($example_ids, $example_ids_search);
                $entities = ClipitExample::get_by_id($example_ids);
            } else {
                $entities = ClipitExample::get_all();
            }

            $count = count($entities);
            if($order_by){
                entities_order($entities, $order_by, $sort, ClipitExample::list_properties());
            }
            $entities = array_slice($entities, clipit_get_offset(), clipit_get_limit(10));
            $to_order = array(
                'name' => elgg_echo('title'),
                'tricky_topic' => elgg_echo('tricky_topic'),
            );
            $table_orders = table_order($to_order, $order_by, $sort);
            $content = elgg_view('examples/list', array(
                'entities' => $entities,
                'count' => $count,
                'table_orders' => $table_orders
            ));
            $sidebar .= elgg_view_module('aside', elgg_echo('filter'),
                elgg_view_form(
                    'tricky_topics/example',
                    array(
                        'disable_security' => true,
                        'action' => 'tricky_topics/examples',
                        'method' => 'GET',
                        'id' => 'add_labels',
                        'style' => 'background: #fff;padding: 15px;',
                        'body' => elgg_view('forms/example/filter')
                    )
                ));
            switch($page[1]){
                case 'create':
                    // Create Example
                    $filter = '';
                    elgg_push_breadcrumb(elgg_echo('examples'), "tricky_topics/examples");
                    $title = elgg_echo('example:create');
                    elgg_push_breadcrumb($title);
                    $tricky_topic = get_input('tricky_topic_id', false);
                    $content = elgg_view_form('example/save',
                        array(
                            'enctype' => 'multipart/form-data',
                            'data-validate' => 'true'
                        ),
                        array(
                            'submit_value' => elgg_echo('create'),
                            'tricky_topic' => $tricky_topic
                        ));
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
                            elgg_push_breadcrumb(elgg_echo('examples'), "tricky_topics/examples");
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
            $tt_sidebar = true;
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
            $tt_sidebar = true;
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
                    $tt_parent = ClipitTrickyTopic::get_cloned_from($tricky_topic->id);
                    $examples = ClipitExample::get_from_tricky_topic($tricky_topic->id);
                    $content = elgg_view('tricky_topics/view',
                        array(
                            'entity' => $tricky_topic,
                            'tricky_topic_parent' => $tt_parent,
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
    if($tt_sidebar){
        $sidebar .= elgg_view_module('aside', elgg_echo('filter'),
            elgg_view_form(
                'tricky_topic',
                array(
                    'disable_security' => true,
                    'action' => 'tricky_topics',
                    'method' => 'GET',
                    'id' => 'add_labels',
                    'style' => 'background: #fff;padding: 15px;',
                    'body' => elgg_view('forms/tricky_topic/filter')
                )
            ));
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