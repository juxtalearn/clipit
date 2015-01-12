<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   7/05/14
 * Last update:     7/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$id = elgg_extract('id', $vars);
$object = ClipitSite::lookup($id);
switch($object['subtype']){
    case 'ClipitStoryboard':
        $entity = array_pop(ClipitStoryboard::get_by_id(array((int)$id)));
        $file = array_pop(ClipitFile::get_by_id(array($entity->file)));
        $body = elgg_view("multimedia/file/view", array(
            'file'  => $file,
            'size'  => 'original'
        ));
        break;
    case 'ClipitFile':
        $entity = array_pop(ClipitFile::get_by_id(array((int)$id)));
        $body = elgg_view("multimedia/file/view", array(
            'file'  => $entity,
            'size'  => 'original'
        ));
        break;
    case 'ClipitVideo':
        $entity = array_pop(ClipitVideo::get_by_id(array((int)$id)));
        $body = elgg_view("multimedia/video/body", array(
            'entity'  => $entity,
            'size'  => 'original'
        ));
        break;
}

echo elgg_view("page/components/modal",
    array(
        "dialog_class"     => "modal-lg add-files-list",
        "remote"    => true,
        "target"    => "viewer-id-".$entity->id,
        "title"     => $entity->name,
        "form"      => false,
        "body"      => $body,
        "footer"    => "",
    ));

