<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   28/04/14
 * Last update:     28/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
// Get the guid

if($file_id = get_input("id")) {
    if ($task_id = get_input('task_id')) {
        ClipitFile::set_read_status($file_id, true, array(elgg_get_logged_in_user_guid()));
    }
    $file = array_pop(ClipitFile::get_by_id(array($file_id)));
    $file_name = $file->name;
    $file_name = ClipitFile::sanitize_filename($file->name);

    if(!empty($file->mime_ext)){
        $file_name .= '.' . $file->mime_ext;
    }
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