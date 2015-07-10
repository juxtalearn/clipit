<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   8/09/14
 * Last update:     8/09/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity_id = (int)$page[5];
$filter = "";
elgg_pop_breadcrumb($entity->name);
$object = ClipitSite::lookup($entity_id);

switch($object['subtype']){
    // Clipit Video
    case 'ClipitVideo':
        $subtitle = elgg_echo("video");
        elgg_push_breadcrumb(elgg_echo("videos"), $href."?filter=videos");
        $entity = array_pop(ClipitVideo::get_by_id(array($entity_id)));
        $entity_preview = '<img src="'.$entity->preview.'" class="img-responsive">';
        break;
    // Clipit File
    case 'ClipitFile':
        $subtitle = elgg_echo("file");
        elgg_push_breadcrumb(elgg_echo("files"), $href."?filter=files");
        $entity = array_pop(ClipitFile::get_by_id(array($entity_id)));
        $entity_preview = elgg_view("multimedia/file/view_summary", array(
            'file' => array_pop(ClipitFile::get_by_id(array($entity->id))),
            'title' => false
        ));
        break;
    default:
        return false;
        break;
}
$tricky_topic = array_pop(ClipitTrickyTopic::get_by_id(array($activity->tricky_topic)));
$tags = $tricky_topic->tag_array;
if(isset($entity_preview)){
    $entity_preview = elgg_view('output/url', array(
        'href'  => "{$href}/view/{$entity->id}",
        'target' => "_blank",
        'title' => $entity->name,
        'text'  => $entity_preview
    ));
}
$content = elgg_view_form('publications/publish', array('data-validate'=> "true" ),
    array(
        'entity'  => $entity,
        'parent_id' => $group->id,
        'activity' => $activity,
        'tags' => $tags,
        'entity_preview' => $entity_preview
    ));
$title =  elgg_echo("publish:to_activity", array($subtitle, $activity->name));