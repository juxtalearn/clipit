<?php
/**
 * Created by PhpStorm.
 * User: Pablo Llinás
 * Date: 21/05/14
 * Time: 16:00
 */

function expose_file_functions(){
    $api_suffix = "clipit.file.";
    $class_suffix = "ClipitFile::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_common_material_functions($api_suffix, $class_suffix);
}
