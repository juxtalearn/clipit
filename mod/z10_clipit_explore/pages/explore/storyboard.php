<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   30/06/14
 * Last update:     30/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity_id = get_input('entity_id');
$entity = array_pop(ClipitStoryboard::get_by_id(array($entity_id)));
$title = $entity->name;
elgg_push_breadcrumb(elgg_echo('storyboards'), "explore?filter=videos");
elgg_push_breadcrumb($title);
// GET RECOMMENDED Storyboards
$related_sb_ids = array_slice(ClipitSite::get_storyboards(), 0, 4);
$related_storyboards = ClipitStoryboard::get_by_id($related_sb_ids);

$recommended_sbs = elgg_view("multimedia/storyboard/recommended/view", array('entities' => $related_storyboards));
$sidebar = elgg_view_module('aside', elgg_echo('storyboards:recommended'), $recommended_sbs, array('class' => 'videos-summary'));
// Tags
$tags = ClipitTag::get_all(10);
$tag_cloud = elgg_view("tricky_topic/tags/tag_cloud", array('tags' => $tags));
$sidebar .= elgg_view_module('aside', elgg_echo('tags:recommended'), $tag_cloud, array('class' => 'module-tags'));

$file = array_pop(ClipitFile::get_by_id(array($entity->file)));
$body = elgg_view("multimedia/file/body", array('entity'  => $file, 'preview' => true));
$params = array(
    'content' => elgg_view('publications/view', array(
        'title' => false,
        'entity' => $entity,
        'rating' => false,
        'body' => $body
    )),
    'title' => $title,
    'filter' => '',
    'sidebar' => $sidebar,
);
$body = elgg_view_layout('content', $params);
echo elgg_view_page($title, $body);
