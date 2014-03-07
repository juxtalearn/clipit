<?php
gatekeeper();
action_gatekeeper();

$params = get_input('params');

if(isset($_FILES)){
    foreach($_FILES as $input_name => $file){
        /*
*               $oFile->title = "Logo";
                $oFile->description = "Logo web";
                $oFile->access_id = 1;
                $oFile->setMimeType($mime_type);
                $oFile->originalfilename = $file['name'];
                $oFile->simpletype = file_get_simple_type($mime_type);
                $prefix = "file/";
                //$filestorename = $oFile->getFilename();
                //$filestorename = elgg_substr($filestorename, elgg_strlen($prefix));
                $filestorename = elgg_strtolower(time().$file['name']);;
                $oFile->setFilename($prefix . $filestorename);
                move_uploaded_file($file['tmp_name'], $oFile->getFilenameOnFilestore());
                elgg_set_plugin_setting($input_name, $prefix.$filestorename, "clipit_home");
         */
        if( (isset($file['name']) && !empty($file['name'])) && ($input_name=='logo_img' || $input_name == 'bg_img') ){
            $mime_type = ElggFile::detectMimeType($file['tmp_name'], $file['type']);
            //$oFile = new ElggFile();
            if(file_get_simple_type($mime_type) == "image"){
                $folder = elgg_get_plugins_path()."clipit_theme/graphics/icons/";
                $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $file_name = elgg_strtolower($input_name);
                // search for all the pathnames matching pattern: logo_img|bg_img.*
                $similar_files = glob($folder.$input_name."*");
                if($similar_files){
                   foreach($similar_files as $sim_file)
                       unlink($sim_file);
                }
                move_uploaded_file($file['tmp_name'], $folder.$file_name.".".$file_ext);
                elgg_set_plugin_setting($input_name, $file_name.".".$file_ext, "clipit_theme");
            }
        }
    }
}
foreach ($params as $k => $v) {
    if (!elgg_set_plugin_setting($k, $v, 'clipit_theme')) {
        register_error(sprintf(elgg_echo('plugins:settings:save:fail'), 'clipit_theme'));
        //forward(REFERER);
    }
}
//forward(REFERER);
