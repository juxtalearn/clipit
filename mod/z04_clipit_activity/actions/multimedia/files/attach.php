<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   12/05/14
 * Last update:     12/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$user_id = elgg_get_logged_in_user_guid();
$file_name = get_input('file-name');

$files = $_FILES['files'];
$count = 0;
$output = array('files' => array('error' => elgg_echo("file:cantupload")));
if(isset($files)){
    $new_file_id = ClipitFile::create(array(
        'name' => $files['name'],
        'description' => $file_text,
        'temp_path'  => $files['tmp_name']
    ));
    if($new_file_id){
        // Upload to GDrive
        ClipitFile::upload_to_gdrive($new_file_id);

        $file = array_pop(ClipitFile::get_by_id(array($new_file_id)));
        $output = array(
            'files' => array(
                array(
                    "id" =>  $file->id,
                    "name" =>  $file->name,
                    "size"  => $file->size,
                    "download_url" => elgg_normalize_url(elgg_format_url("file/download/{$file->id}"))
                )
            )
        );
    }
}
echo json_encode($output);