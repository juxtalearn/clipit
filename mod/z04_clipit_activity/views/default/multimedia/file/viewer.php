<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   7/05/14
 * Last update:     7/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$id = elgg_extract('id', $vars);
$file = array_pop(ClipitFile::get_by_id(array((int)$id)));

$body = elgg_view("multimedia/file/view", array(
    'file'  => $file,
    'size'  => 'original'
));

echo elgg_view("page/components/modal",
    array(
        "dialog_class"     => "modal-lg add-files-list",
        "remote"    => true,
        "target"    => "viewer-id-".$file->id,
        "title"     => $file->name,
        "form"      => false,
        "body"      => $body,
        "footer"    => "",
    ));

