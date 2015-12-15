<?php

// Recover mime_ext of cloned files from parent
$file_array = ClipitFile::get_all();
foreach($file_array as $file){
    if(empty($file->mime_ext) && $file->cloned_from){
        $prop_value_array = ClipitFile::get_properties($file->cloned_from, array("mime_ext"));
        if(!empty($prop_value_array["mime_ext"])) {
            ClipitFile::set_properties($file->id, $prop_value_array);
        }
    }
}
