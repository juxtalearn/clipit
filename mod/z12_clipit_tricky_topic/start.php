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
    $plugin_dir = elgg_get_plugins_path() . "z12_clipit_tricky_topic";
    $user = array_pop(ClipitUser::get_by_id(array(elgg_get_logged_in_user_guid())));
    if(hasTeacherAccess($user->role)) {
        elgg_extend_view("navigation/menu/top", "navigation/menu/authoring", 100);

        // Register "/tricky_topics" page handler
        elgg_register_page_handler('tricky_topics', 'tt_page_handler');
        elgg_register_action("example/save", "{$plugin_dir}/actions/example/save.php");
        elgg_register_action("example/remove", "{$plugin_dir}/actions/example/remove.php");
        elgg_register_ajax_view('examples/summary');

        elgg_register_action("stumbling_blocks/link", "{$plugin_dir}/actions/stumbling_blocks/link.php");
        elgg_register_action("stumbling_blocks/remove", "{$plugin_dir}/actions/stumbling_blocks/remove.php");
        elgg_register_ajax_view('stumbling_blocks/search');

        elgg_register_action("tricky_topic/save", "{$plugin_dir}/actions/tricky_topic/save.php");
        elgg_register_action("tricky_topic/remove", "{$plugin_dir}/actions/tricky_topic/remove.php");
        elgg_register_action("tricky_topic/resources", "{$plugin_dir}/actions/tricky_topic/resources.php");
        elgg_register_ajax_view('tricky_topics/tags/search');
    }

    // Sidebar menu
    elgg_extend_view('authoring_tools/sidebar/menu', 'tricky_topics/sidebar/menu', 100);

    elgg_extend_view('js/activity', 'js/tricky_topic');
    elgg_register_library('clipit:tricky_topic:functions', "{$plugin_dir}/lib/functions.php");
    elgg_load_library('clipit:tricky_topic:functions');

    // hook: Publish a tricky topic
    elgg_register_plugin_hook_handler("action", "publications/publish", "publish_site_tricky_topics");
}

function publish_site_tricky_topics($hook, $entity_type, $returnvalue, $params){
    $entity_id = get_input('id');
    $object = ClipitSite::lookup($entity_id);
    if($object['subtype'] == 'ClipitTrickyTopic') {
        ClipitSite::add_pub_tricky_topics(array($entity_id));
        forward(REFERER);
    }
}


/**
 * @param $page
 */
function tt_page_handler($page){
    elgg_load_js('clipit:tricky_topic');
    elgg_set_context('authoring');
    $menu = elgg_view_module('aside', elgg_echo('teacher:authoring_tools'),
        elgg_view('authoring_tools/sidebar/menu'),
        array('class' => 'activity-group-block margin-bottom-10 aside-tree')
    );
    $selected_tab = get_input('filter', 'all');
    $filter = elgg_view('tricky_topics/filter', array('selected' => $selected_tab, 'href' => $page[0]));
    $count = 0;
    $params = array();
    $view = $page[0];
    $table_orders = array();
    $tt_sidebar = false;

    $sort = get_input('sort');
    $order_by = get_input('order_by');
    switch($page[0]){
        case '':
            $tt_sidebar = true;
            $title = elgg_echo('tricky_topics');
            $view = "tricky_topics";

            if($search = get_input('s')) {
                $all_entities = trickytopic_filter_search($search);
                if($order_by){
                    $all_entities = get_entities_order(
                        'ClipitTrickyTopic',
                        $all_entities,
                        clipit_get_limit(10),
                        clipit_get_offset(),
                        $order_by,
                        $sort
                    );
                } else {
                    $all_entities = ClipitTrickyTopic::get_by_id($all_entities);
                }
                $count = count($all_entities);
                $entities = array_slice($all_entities, clipit_get_offset(), clipit_get_limit(10));
            } else {
                $all_entities = ClipitTrickyTopic::get_all(0, 0, '', true, true);
                if($order_by) {
                    $all_entities = get_entities_order(
                        'ClipitTrickyTopic',
                        $all_entities,
                        clipit_get_limit(10),
                        clipit_get_offset(),
                        $order_by,
                        $sort
                    );
                } else {
                    $all_entities = ClipitTrickyTopic::get_by_id($all_entities);
                }
                $count = count($all_entities);
                $entities = array_slice($all_entities, clipit_get_offset(), clipit_get_limit(10));
            }

            $to_order = array(
                'name' => elgg_echo('name'),
                'education_level' => elgg_echo('education_level'),
                'subject' => elgg_echo('tricky_topic:subject'),
            );
            $table_orders = table_order($to_order, $order_by, $sort);
            $content = elgg_view('tricky_topics/list', array(
                'entities' => $entities,
                'count' => $count,
                'table_orders' => $table_orders
            ));
            $search_menu = elgg_view_module('aside', elgg_echo('filter'),
            elgg_view_form(
                'filter_search',
                array(
                    'id' => 'add_labels',
                    'style' => 'background: #fff;padding: 15px;',
                    'body' => elgg_view('forms/tricky_topic/filter')
                )
            ));
            break;
        case 'stumbling_blocks':
            $title = elgg_echo('tags');
            $all_entities = ClipitTag::get_all();
            $count = count($all_entities);
            if($order_by){
                entities_order($all_entities, $order_by, $sort, ClipitTag::list_properties());
            }
            $entities = array_slice($all_entities, clipit_get_offset(), clipit_get_limit(10));
            $to_order = array(
                'name' => elgg_echo('name'),
            );
            $table_orders = table_order($to_order, $order_by, $sort);
            $content = elgg_view('stumbling_blocks/list', array(
                'entities' => $entities,
                'count' => $count,
                'table_orders' => $table_orders
            ));
            switch($page[1]){
                case 'view':
                    // View Stumbling block
                    if($id = $page[2]) {
                        $filter = '';
                        if ($tag = array_pop(ClipitTag::get_by_id(array($id)))) {
                            elgg_push_breadcrumb(elgg_echo('tags'), "tricky_topics/stumbling_blocks");
                            $title = $tag->name;
                            elgg_push_breadcrumb($title);
                            $entities = $tag;
                            $examples = ClipitExample::get_by_tags(array($tag->id));
                            $tricky_topics = ClipitTrickyTopic::get_by_id(ClipitTag::get_tricky_topics($tag->id));
                            $content = elgg_view('stumbling_blocks/view',
                                array(
                                    'entity' => $tag,
                                    'tricky_topics' => $tricky_topics,
                                    'examples' => $examples,
                                ));
                        } else {
                            return false;
                        }
                    }
                    break;
            }
            break;
        case 'examples':
            $title = elgg_echo('examples');

            if($search = get_input('s')) {
                $all_entities = example_filter_search($search);
                if($order_by){
                    $all_entities = get_entities_order(
                        'ClipitExample',
                        $all_entities,
                        clipit_get_limit(10),
                        clipit_get_offset(),
                        $order_by,
                        $sort
                    );
                } else {
                    $all_entities = ClipitExample::get_by_id($all_entities);
                }
                $count = count($all_entities);
                $entities = array_slice($all_entities, clipit_get_offset(), clipit_get_limit(10));
            } else {
                $all_entities = ClipitExample::get_all(0, 0, '', true, true);
                if($order_by) {
                    $all_entities = get_entities_order(
                        'ClipitExample',
                        $all_entities,
                        clipit_get_limit(10),
                        clipit_get_offset(),
                        $order_by,
                        $sort
                    );
                } else {
                    $all_entities = ClipitExample::get_by_id($all_entities);
                }
                $count = count($all_entities);
                $entities = array_slice($all_entities, clipit_get_offset(), clipit_get_limit(10));
            }

            $to_order = array(
                'name' => elgg_echo('name'),
                'tricky_topic' => elgg_echo('tricky_topic'),
            );
            $table_orders = table_order($to_order, $order_by, $sort);
            $content = elgg_view('examples/list', array(
                'entities' => $entities,
                'count' => $count,
                'table_orders' => $table_orders
            ));
            $search_menu = elgg_view_module('aside', elgg_echo('filter'),
                elgg_view_form(
                    'filter_search',
                    array(
                        'id' => 'add_labels',
                        'style' => 'background: #fff;padding: 15px;',
                        'body' => elgg_view('forms/example/filter')
                    )
                ));
            if($page[1]){
                $search_menu = false;
            }
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
                        'files' => array()
                    );
                    $multimedia['videos'] = array_merge($multimedia['videos'], $example->video_array);
                    $multimedia['files'] = array_merge($multimedia['files'], $example->file_array);
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
                            );
                            $multimedia['videos'] = array_merge($multimedia['videos'], $example->video_array);
                            $multimedia['files'] = array_merge($multimedia['files'], $example->file_array);
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
                    $multimedia = array(
                        'videos' => ClipitTrickyTopic::get_videos($tricky_topic->id),
                        'files' => ClipitTrickyTopic::get_files($tricky_topic->id),
                    );
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
            $content = elgg_view($view.'/list', array(
                'entities' => $entities,
                'count' => $count,
                'table_orders' => $table_orders
            ));
            break;
    }
    $params = array(
        'content' => $content,
        'title' => $title,
        'filter' => $filter,
        'sidebar' => $menu.$search_menu,
    );
    $body = elgg_view_layout('one_sidebar', $params);

    echo elgg_view_page($title, $body);
}