<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   29/04/14
 * Last update:     29/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$user_id = elgg_get_logged_in_user_guid();
/**
 * Main Content
 */

// video list
$content .= elgg_view("page/components/title_block", array(
    'title' => elgg_echo("videos"),
));
$videos = ClipitVideo::get_all(6);
$params_video_list = array(
    'videos' => $videos
);
$content .= elgg_view("explore/video/list", $params_video_list);
// activity list
$content .= elgg_view("page/components/title_block", array(
    'title' => elgg_echo("activities"),
));
$activities = ClipitActivity::get_all(3);
$params_activity_list = array(
    'activities' => $activities
);
$params_activity_list = array(
    'items'         => $activities,
    'pagination'    => false,
    'list_class'    => 'my-activities',
);
$content .= elgg_view("activities/list", $params_activity_list);
/**
 * Sidebar
 */
// Tags
$tags = ClipitTag::get_all(10);
$tag_cloud = elgg_view("tricky_topic/tags/tag_cloud", array('tags' => $tags));
$sidebar = elgg_view_module('aside', elgg_echo('tags'), $tag_cloud, array('class' => 'module-tags'));
// Search
$search_box = elgg_view_form("explore/search", array('body' => elgg_view("search/sidebar/search_box")));
$sidebar .= elgg_view_module('aside', elgg_echo('search'), $search_box, array('class' => 'module-search'));

$params = array(
    'content' => $content,
    'title' => elgg_echo("explore"),
    'filter' => '',
    'sidebar' => $sidebar,
    'class' => 'row'
);
$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
