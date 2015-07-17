<?php
// /**
// * ClipIt - JuxtaLearn Web Space
// * PHP version:     >= 5.2
// * Creation date:   28/04/14
// * Last update:     28/04/14
// * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
// * @version         $Version$
// * @link            http://www.juxtalearn.eu
// * @license         GNU Affero General Public License v3
// * @package         ClipIt
// */
//// Get the guid
//$file_id = get_input("id");
//if($task_id = get_input('task_id')){
//    if($storyboard_id = get_input('storyboard')){
//        ClipitStoryboard::set_read_status($storyboard_id, true, array(elgg_get_logged_in_user_guid()));
//    } else {
//        ClipitFile::set_read_status($file_id, true, array(elgg_get_logged_in_user_guid()));
//    }
//}
//// Get the file
//$file = array_pop(ClipitFile::get_by_id(array($file_id)));
//header("Pragma: public");
//header("Content-Type: application/download");
//header("Content-Disposition: attachment; filename=\"$file->name\"");
//ob_clean();
//flush();
//readfile($file->file_path);
//exit;

$file_path = "";
$file_name = "";
if($file_id = get_input("id")) {
    $user_id = elgg_get_logged_in_user_guid();
    if ($task_id = get_input('task_id')) {
        ClipitFile::set_read_status($file_id, true, array($user_id));
    } else {
        ClipitFile::set_read_status($file_id, true, array($user_id));
    }
    $file = array_pop(ClipitFile::get_by_id(array($file_id)));
    $file_name = $file->name;
    $file_path = $file->file_path;
} elseif($entity_id = get_input('entity_id')){
    $object = ClipitSite::lookup($entity_id);
    switch($object['subtype']){
        case 'ClipitQuiz':
            $file_path = ClipitQuiz::export_to_excel($entity_id);
            $file_name = end(explode("/", $file_path));
            break;
    }
}
if($file_path) {
    header("Pragma: public");
    header("Content-Type: application/download");
    header("Content-Disposition: attachment; filename=\"$file_name\"");
    ob_clean();
    flush();
    readfile($file_path);
    exit;
}