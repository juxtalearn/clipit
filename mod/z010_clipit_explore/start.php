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
elgg_register_event_handler('init', 'system', 'clipit_explore_init');

function clipit_explore_init() {
    // Register "/explore" page handler
    elgg_register_page_handler('explore', 'explore_page_handler');

    elgg_register_event_handler('pagesetup', 'system', 'explore_clipit_pagesetup');
    // Actions
    elgg_register_action("settings/account", elgg_get_plugins_path() . "z09_clipit_profile/actions/settings/account.php");
}

/**
 * Explore page handler
 *
 * @param array $page Array of URL components for routing
 * @return bool
 */
function explore_page_handler($page) {
    $current_user = elgg_get_logged_in_user_entity();
    elgg_set_context('explore');
    if (!$current_user) {
        register_error(elgg_echo('noaccess'));
        $_SESSION['last_forward_from'] = current_page_url();
        forward('');
    }

    //$base_dir = elgg_get_plugins_path() . 'z010_clipit_explore/pages/explore';

    $vars = array();
    $vars['page'] = $page[0];
    if($page[0]){
        elgg_push_breadcrumb(elgg_echo('explore'), 'explore');
    }
    switch($page[0]){
        case 'activities':
            $title = elgg_echo("activities");
            elgg_push_breadcrumb($title);
            $activities = ClipitActivity::get_all();
            $params_activity_list = array(
                'items'         => $activities,
                'pagination'    => false,
                'list_class'    => 'my-activities',
            );
            $content = elgg_view("activities/list", $params_activity_list);
        break;
        case 'videos':
            $title = elgg_echo("videos");
            elgg_push_breadcrumb($title);
            $videos = ClipitVideo::get_all(6);
            $params_video_list = array(
                'videos' => $videos
            );
            $content = elgg_view("explore/video/list", $params_video_list);
            if(!$videos){
                $content = elgg_view('output/empty', array('value' => elgg_echo('videos:none')));
            }
        break;
        case 'search':
            $by = get_input('by');
            $id = (int)get_input('id');
            $text = get_input('text');
            switch($by){
                case 'tricky_topic':
                    $tricky_topic = array_pop(ClipitTrickyTopic::get_by_id(array($id)));
                    $title = $tricky_topic->name;
                    elgg_push_breadcrumb(elgg_echo('tricky_topic'));
                    elgg_push_breadcrumb($tricky_topic->name);
                    $content = elgg_view("page/components/title_block", array(
                        'title' => elgg_echo("tags"),
                    ));
                    $tags = ClipitTag::get_by_id($tricky_topic->tag_array);
                    $tag_cloud = elgg_view("tricky_topic/tags/tag_cloud", array('tags' => $tags));
                    $content .= elgg_view_module('default', '', $tag_cloud, array('class' => 'module-tags'));

                    $activities = ClipitActivity::get_from_tricky_topic($tricky_topic->id);


                    $content .= get_explore(array(
                        'activities' => $activities,
                        'title' => true
                    ));
                    if(!$tricky_topic){
                        $content = elgg_view('output/empty', array('value' => elgg_echo('tricky_topics:none')));
                    }
                    break;
                case 'tag':
                    $tag = array_pop(ClipitTag::get_by_id(array($id)));
                    $title = $tag->name;
                    elgg_push_breadcrumb(elgg_echo('tag'));
                    elgg_push_breadcrumb($tag->name);
                    $tags = ClipitTag::get_by_id($tag->tag_array);
                    $tricky_topics = ClipitTag::get_tricky_topics($tag->id);
                    $content = elgg_view("page/components/title_block", array(
                        'title' => elgg_echo("trick_topics"),
                    ));
                    $videos = ClipitVideo::get_all(5);
                    print_r(ClipitVideo::get_by_id(array(2436)));

                    $content = elgg_view_module('default', elgg_echo('tags'), $tag_cloud, array('class' => 'module-tags'));;
                    $content .= get_explore(array(
                        'videos' => $videos,
                        'storyboards' => ClipitStoryboard::get_all(6),
                        'title' => true
                    ));
                    if(!$tag){
                        $content = elgg_view('output/empty', array('value' => elgg_echo('tags:none')));
                    }
                    break;
                case 'all':
                    if(!$text){
                        return false;
                    }
                    $title = elgg_echo('search:results_for') . ' <span style="opacity: .7">'.$text.'</span>';
                    $content = get_explore(array(
                        'videos' => ClipitVideo::get_from_search($text),
                        'activities' => ClipitActivity::get_from_search($text),
                        'storyboards' => ClipitStoryboard::get_from_search($text),
                        'title' => true
                    ));
                    break;
            }
            break;
        case '': // explore
            $content = get_explore(array(
                'videos' => ClipitVideo::get_all(6),
                'activities' => ClipitActivity::get_all(3),
                'storyboards' => ClipitStoryboard::get_all(6),
                'title' => true
            ));
            break;
        default:
            return false;
            break;
    }
    switch($page[0]){

        case 'video':
            echo "VIDEO PREVIEW";
            break;
        default:
            //require_once "$base_dir/all.php";


            break;
    }

    /**
     * Sidebar
     */
    // Tags
    $tags = ClipitTag::get_all(10);
    $tag_cloud = elgg_view("tricky_topic/tags/tag_cloud", array('tags' => $tags));
    $sidebar = elgg_view_module('aside', elgg_echo('tags:recommended'), $tag_cloud, array('class' => 'module-tags'));
    // Search
    $search_box = elgg_view("search/sidebar/search_box");
    $sidebar .= elgg_view_module('aside', elgg_echo('search'), $search_box, array('class' => 'module-search'));
    /**
     * Filter
     */
    $selected_tab = get_input('filter', 'videos');
    $filter = elgg_view('explore/filter', array('selected' => $selected_tab, 'entity' => $entity, 'href' => $href));

    $params = array(
        'content' => $content,
        'title' => $title,
        'filter' => $filter,
        'sidebar' => $sidebar,
        'class' => 'row'
    );
    $body = elgg_view_layout('content', $params);

    echo elgg_view_page($title, $body);

    return true;

}

/**
 * @param $page
 * @return bool
 */

/**
 * Set up the menu for user settings
 *
 * @return void
 * @access private
 */
function explore_clipit_pagesetup() {
    $user_id = elgg_get_logged_in_user_guid();

   /* if ($user_id && elgg_get_context() == "explore") {
        $params = array(
            'name' => 'explore_activities',
            'text' => elgg_echo('activities'),
            'href' => "explore/activities",
        );
        elgg_register_menu_item('page', $params);
        $params = array(
            'name' => 'explore_videos',
            'text' => elgg_echo('videos'),
            'href' => "explore/videos",
        );
        elgg_register_menu_item('page', $params);
        $params = array(
            'name' => 'explore_storyboards',
            'text' => elgg_echo('storyboards'),
            'href' => "explore/storyboards",
        );
        elgg_register_menu_item('page', $params);
        $params = array(
            'name' => 'explore_files',
            'text' => elgg_echo('files'),
            'href' => "explore/files",
        );
        elgg_register_menu_item('page', $params);
    }*/
}

/**
 * content: activities, videos, storyboards, files
 * @param $id
 */
function get_explore($params = array()){
    $content = "";
    $title = $params['title'];
    // Videos
    if($videos = $params['videos']){
        if($title){
            $content .= elgg_view("page/components/title_block", array(
                'title' => elgg_echo("videos"),
            ));
        }
        $params_video_list = array(
            'videos' => $videos
        );
        $content .= elgg_view("explore/video/list", $params_video_list);
    }

    // Activities
    if($activities = $params['activities']){
        if($title){
            $content .= elgg_view("page/components/title_block", array(
                'title' => elgg_echo("activities"),
            ));
        }
        $params_activity_list = array(
            'items'         => $activities,
            'pagination'    => false,
            'list_class'    => 'my-activities',
        );
        $content .= elgg_view("activities/list", $params_activity_list);
    }
    return $content;
}