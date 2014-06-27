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
    elgg_register_library('clipit:explore', elgg_get_plugins_path() . 'z10_clipit_explore/lib/functions.php');
    elgg_load_library('clipit:explore');
}

/**
 * Explore page handler
 *
 * @param array $page Array of URL components for routing
 * @return bool
 */
function explore_page_handler($page) {
    $user_id = elgg_get_logged_in_user_guid();
    $current_user = elgg_get_logged_in_user_entity();
    elgg_set_context('explore');
    if (!$current_user) {
        register_error(elgg_echo('noaccess'));
        $_SESSION['last_forward_from'] = current_page_url();
        forward('');
    }

    $activity_id = get_input('activity');
    $vars = array();
    $vars['page'] = $page[0];
    if($page[0]){
        elgg_push_breadcrumb(elgg_echo('explore'), 'explore');
    }
    $selected_tab = get_input('filter', 'all');
    switch($page[0]){
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


                    if(!$tricky_topic){
                        $content = elgg_view('output/empty', array('value' => elgg_echo('tricky_topics:none')));
                    }
                    break;
                case 'tag':
                    $tag = array_pop(ClipitTag::get_by_id(array($id)));
                    $title = $tag->name;
                    elgg_push_breadcrumb(elgg_echo('tag'));
                    elgg_push_breadcrumb($tag->name);
                    $videos = ClipitVideo::get_by_tags(array($tag->id));
                    $storyboards = ClipitStoryboard::get_by_tags(array($tag->id));
                    $files = ClipitFile::get_by_tags(array($tag->id));
                    break;
                case 'all':
                    if(!$text){
                        return false;
                    }
                    $title = elgg_echo('search:results_for') . ' <span style="opacity: .7">'.$text.'</span>';
                    $content = get_explore(array(
                        'videos' => ClipitVideo::get_from_search($text),
                        'storyboards' => ClipitStoryboard::get_from_search($text),
                        'title' => true
                    ));
                    $videos = ClipitVideo::get_from_search($text);
                    $storyboards = ClipitStoryboard::get_from_search($text);
                    $activities = ClipitActivity::get_from_search($text);
                    break;
            }
            break;
        case '': // explore (filter: all)
            $videos = ClipitVideo::get_all(6);
            $storyboards = ClipitStoryboard::get_all(6);
            $activities = ClipitActivity::get_all(3);
            switch($selected_tab){
                case 'videos':
                    $videos = ClipitVideo::get_all(15);
                    break;
                case 'storyboards':
                    $storyboards = ClipitStoryboard::get_all(15);
                    break;
                case 'files':
                    $files = ClipitFile::get_all(15);
                    break;
            }
            break;
        default:
            return false;
            break;
    }
    // Get publications items
    if($activity_id){
        if($by){
            $visible_videos = get_visible_items_by_activity($activity_id, $videos, 'videos');
            $visible_storyboards = get_visible_items_by_activity($activity_id, $storyboards, 'storyboards');
        } else {
            $visible_videos = ClipitActivity::get_published_videos($activity_id);
            $visible_storyboards = ClipitActivity::get_published_storyboards($activity_id);
        }
        // Videos
        $videos = ClipitVideo::get_by_id($visible_videos);
        // Storyboards
        $storyboards = ClipitStoryboard::get_by_id($visible_storyboards);

        $href = "clipit_activity/{$activity_id}/publications";
    }
    switch($selected_tab){
        case 'videos':
            elgg_push_breadcrumb(elgg_echo("videos"));
            $params_video_list = array(
                'videos' => $videos,
                'href' => $href
            );
            $content = elgg_view("explore/video/list", $params_video_list);
            if(!$videos){
                $content = elgg_view('output/empty', array('value' => elgg_echo('videos:none')));
            }
            break;
        case 'storyboards':
            elgg_push_breadcrumb(elgg_echo("storyboards"));
            $params_sb_list = array(
                'storyboards' => $storyboards,
                'href' => $href
            );
            $content = elgg_view("explore/storyboard/list", $params_sb_list);
            if(!$storyboards){
                $content = elgg_view('output/empty', array('value' => elgg_echo('storyboards:none')));
            }
            break;
        default:
            $content = get_explore(array(
                'videos' => array('limit' => 3, 'entities' => $videos),
                'storyboards' => array('limit' => 4, 'entities' => $storyboards),
                'title' => true
            ));
            if(!$content){
                $content = elgg_view('output/empty', array('value' => elgg_echo('search:not_found')));
            }
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
    // Filter
    $my_activities_ids = ClipitUser::get_activities($user_id);
    $my_activities = ClipitActivity::get_by_id($my_activities_ids);
    $menu_filter = elgg_view("explore/sidebar/menu", array('entities' => $my_activities));
    $sidebar = elgg_view_module('aside', elgg_echo('explore:menu'), $menu_filter);
    // Tags
    $tags = ClipitTag::get_all(10);
    $tag_cloud = elgg_view("tricky_topic/tags/tag_cloud", array('tags' => $tags));
    $sidebar .= elgg_view_module('aside', elgg_echo('tags:recommended'), $tag_cloud, array('class' => 'module-tags'));
    // Search
    $search_box = elgg_view("search/sidebar/search_box");
    $sidebar .= elgg_view_module('aside', elgg_echo('search'), $search_box, array('class' => 'module-search'));
    /**
     * Filter
     */
    $counts = array('videos' => count($videos), 'storyboards' => count($storyboards), 'files' => count($files));
    $filter = elgg_view('explore/filter', array('selected' => $selected_tab, 'counts' => $counts));

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
 * content: activities, videos, storyboards, files
 * @param $id
 */
function get_explore($params = array()){
    $content = "";
    $title = $params['title'];
    // Videos
    if(($videos = $params['videos']) && $entities = $videos['entities']){
        if($title){
            $content .= elgg_view("page/components/title_block", array(
                'title' => elgg_echo("videos"),
            ));
        }
        $limit = count($entities);
        if(isset($videos['limit'])){
           $limit = $videos['limit'];
           $entities = array_slice($entities, 0, $limit);
        }
        $params_video_list = array(
            'videos' => $entities
        );
        $content .= elgg_view("explore/video/list", $params_video_list);
        if(count($videos['entities']) > $limit ){
            $content .= elgg_view("explore/view_all", array('filter' => 'videos'));
        }
    }
    // Storyboards
    if(($storyboards = $params['storyboards']) && $entities = $storyboards['entities']){
        if($title){
            $content .= elgg_view("page/components/title_block", array(
                'title' => elgg_echo("storyboards"),
            ));
        }
        $limit = count($entities);
        if(isset($storyboards['limit'])){
            $limit = $storyboards['limit'];
            $entities = array_slice($entities, 0, $limit);
        }
        $params_sb_list = array(
            'storyboards' => $entities
        );
        $content .= elgg_view("explore/storyboard/list", $params_sb_list);
        if(count($storyboards['entities']) > $limit ){
            $content .= elgg_view("explore/view_all", array('filter' => 'storyboards'));
        }
    }

    return $content;
}