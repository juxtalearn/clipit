<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   30/06/14
 * Last update:     30/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$entity_id = get_input('entity_id');
$entity = array_pop(ClipitVideo::get_by_id(array($entity_id)));
$title = $entity->name;
elgg_push_breadcrumb(elgg_echo('videos'), "explore?filter=videos");
elgg_push_breadcrumb($title);
// GET RECOMMENDED VIDEO
$related_video_ids = array_slice(ClipitSite::get_videos(), 0, 4);
$related_videos = ClipitVideo::get_by_id($related_video_ids);

$recommended_videos = elgg_view("multimedia/video/recommended/view", array('entities' => $related_videos));
$sidebar = elgg_view_module('aside', elgg_echo('videos:recommended'), $recommended_videos, array('class' => 'videos-summary'));
// Tags
$tags = ClipitTag::get_all(10);
$tag_cloud = elgg_view("tricky_topic/tags/tag_cloud", array('tags' => $tags));
$sidebar .= elgg_view_module('aside', elgg_echo('tags:recommended'), $tag_cloud, array('class' => 'module-tags'));

$comments = array_pop(ClipitComment::get_by_destination(
    array($entity->id),
    clipit_get_limit(),
    clipit_get_offset()
));
$body = elgg_view("multimedia/video/body", array('entity'  => $entity));
$params = array(
    'content' => elgg_view('publications/view', array(
        'title' => false,
        'entity' => $entity,
        'comments' => $comments,
        'admin_options' => false,
        'rating' => false,
        'body' => $body
    )),
    'title' => $title,
    'filter' => '',
    'sidebar' => $sidebar,
);
$body = elgg_view_layout('content', $params);
echo elgg_view_page($title, $body);
