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
$entity = array_pop(ClipitFile::get_by_id(array($entity_id)));
$title = $entity->name;
elgg_push_breadcrumb(elgg_echo('files'), "explore?filter=files");
elgg_push_breadcrumb($title);
// GET RECOMMENDED Files
$related_file_ids = array_slice(ClipitSite::get_files(), 0, 4);
$related_files = ClipitFile::get_by_id($related_file_ids);

$recommended_sbs = elgg_view("multimedia/file/recommended/view", array('entities' => $related_files));
$sidebar = elgg_view_module('aside', elgg_echo('files:recommended'), $recommended_sbs, array('class' => 'videos-summary'));
// Tags
$tags = ClipitTag::get_all(10);
$tag_cloud = elgg_view("tricky_topic/tags/tag_cloud", array('tags' => $tags));
$sidebar .= elgg_view_module('aside', elgg_echo('tags:recommended'), $tag_cloud, array('class' => 'module-tags'));

$body = elgg_view("multimedia/file/body", array('entity'  => $entity, 'preview' => true));
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
