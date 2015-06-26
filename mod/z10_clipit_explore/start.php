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
    elgg_register_library('clipit:explore', elgg_get_plugins_path() . 'z10_clipit_explore/lib/explore/functions.php');
    elgg_load_library('clipit:explore');
    // "Explore" Nav menu top
    elgg_extend_view("navigation/menu/top", "navigation/menu/explore", 50);
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
//    if($page[0]){
        elgg_push_breadcrumb(elgg_echo('explore'), 'explore');
//    }
    $selected_tab = get_input('filter', 'all');
    $searching = true;
    $href_breadcrumb = false;
    if($activity_id){
        $activity_object = ClipitSite::lookup($activity_id);
        $href_breadcrumb = get_input('by') ? "/search" :  false;
        elgg_push_breadcrumb($activity_object['name'], "explore" .$href_breadcrumb. "?activity={$activity_id}");
    } else {
        $href_breadcrumb = get_input('by') ? "/search" :  false;
        elgg_push_breadcrumb(elgg_echo('explore:public'), "explore" .$href_breadcrumb. "?site=true");
    }
    switch($page[0]){
        case 'search':
            $public_content = true;
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
                    break;
                case 'label':
                    $label = array_pop(ClipitLabel::get_by_id(array($id)));
                    $title = $label->name;
                    elgg_push_breadcrumb(elgg_echo('label'));
                    elgg_push_breadcrumb($label->name);
                    $videos = ClipitVideo::get_by_labels(array($label->id));
                    $storyboards = ClipitStoryboard::get_by_labels(array($label->id));
                    break;
                case 'performance_item':
                    $performance_item = array_pop(ClipitPerformanceItem::get_by_id(array($id)));
                    $title = $performance_item->name;
                    elgg_push_breadcrumb(elgg_echo('performance_item'));
                    elgg_push_breadcrumb($performance_item->name);
                    $videos = ClipitVideo::get_by_performance_items(array($performance_item->id));
                    $storyboards = ClipitStoryboard::get_by_performance_items(array($performance_item->id));
                    //$files = ClipitFile::get_by_performance_items(array($performance_item->id));
                    $files = array();
                    break;
                case 'all':
                    if(!$text){
                        forward("explore");
                    }
                    $title = elgg_echo('search:results_for') . ' <span style="opacity: .7">'.$text.'</span>';
                    $content = get_explore(array(
                        'public_content' => $public_content,
                        'videos' => ClipitVideo::get_from_search($text),
                        'storyboards' => ClipitStoryboard::get_from_search($text),
                        'title' => true
                    ));
                    $videos = ClipitVideo::get_from_search($text);
                    $storyboards = ClipitStoryboard::get_from_search($text);
                    $files = ClipitFile::get_from_search($text);
                    break;
            }
            break;
        case '': // explore (filter tab: all)
            $title = elgg_echo('videos');
            $public_content = true;
            $searching = false;
            $video_ids = ClipitSite::get_videos();
            $videos = ClipitVideo::get_by_id($video_ids);
            $href = "explore";
            break;
    }
    // Get publications items
    $searched_videos = $videos;
    $searched_storyboards= $storyboards;
    if($activity_id){
        $public_content = false;
        $title = $activity_object['name'];
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
    } elseif($by){
        $visible_videos = get_visible_items_by_site($videos, 'videos');
        // Videos
        $videos = ClipitVideo::get_by_id($visible_videos);
        // Storyboards
        $storyboards = array();

        $href = "explore";
    }
    if($page[0]){
        $selected_tab = false;
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
                'public_content' => $public_content,
                'videos' => array('limit' => 3, 'entities' => $videos, 'href' => $href),
                'storyboards' => array('limit' => 4, 'entities' => $storyboards, 'href' => $href),
                'title' => true
            ));
            if(!$content){
                $content = elgg_view('output/empty', array('value' => elgg_echo('search:not_found')));
            }
            break;
    }

    switch($page[0]){
        case 'view':
            if(!$entity_id = (int)$page[1]){
                return false;
            }
            $entity_id = (int)$page[1];
            $file_dir = elgg_get_plugins_path() . 'z10_clipit_explore/pages/explore';
            $object = ClipitSite::lookup($entity_id);

            switch ($object['subtype']) {
                case 'ClipitVideo':
                    set_input('entity_id', $entity_id);
                    include "$file_dir/video.php";
                    return true;
                    break;
                case 'ClipitStoryboard':
                    set_input('entity_id', $entity_id);
                    include "$file_dir/storyboard.php";
                    return true;
                    break;
                default:
                    return false;
            }
    }
    /**
     * Sidebar
     */
    // Filter
    $my_activities_ids = ClipitUser::get_activities($user_id);
    $my_activities = ClipitActivity::get_by_id($my_activities_ids);
    $menu_filter = elgg_view("explore/sidebar/menu",
        array(
            'entities' => $my_activities,
            'videos' => $searched_videos,
            'storyboards' => $searched_storyboards
        ));
    $sidebar = elgg_view_module('aside', elgg_echo('explore:scope'), $menu_filter);
    // Tags
    $tags = ClipitTag::get_all(10);
    $tag_cloud = elgg_view("tricky_topic/tags/tag_cloud", array('tags' => $tags));
    $sidebar .= elgg_view_module('aside', elgg_echo('explore:tags'), $tag_cloud, array('class' => 'module-tags'));
    /**
     * Filter
     */
    $counts = array('videos' => count($videos), 'storyboards' => count($storyboards), 'files' => count($files));
    if(!$public_content) {
        $filter = elgg_view('explore/filter', array('selected' => $selected_tab, 'counts' => $counts));
    } else {
        $filter = '';
    }
    if($searching){
        $title = elgg_view('output/url', array(
            'href' => "explore?site=true",
            'title' => elgg_echo('search:reset'),
            'text' => '<i class="fa fa-times"></i>',
            'class' => 'blue-lighter'
        )) . " " . $title;
    }

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
        if($title && !$params['public_content']){
            $content .= elgg_view("page/components/title_block", array(
                'title' => elgg_echo("videos"),
            ));
        }
        $limit = count($entities);
        if(isset($videos['limit']) && !$params['public_content']){
           $limit = $videos['limit'];
           $entities = array_slice($entities, 0, $limit);
        }
        $params_video_list = array(
            'videos' => $entities,
            'href' => $videos['href']
        );
        $content .= elgg_view("explore/video/list", $params_video_list);
        if(count($videos['entities']) > $limit  && !$params['public_content']){
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
            'storyboards' => $entities,
            'href' => $storyboards['href']
        );
        $content .= elgg_view("explore/storyboard/list", $params_sb_list);
        if(count($storyboards['entities']) > $limit && !$params['public_content']){
            $content .= elgg_view("explore/view_all", array('filter' => 'storyboards'));
        }
    }

    return $content;
}