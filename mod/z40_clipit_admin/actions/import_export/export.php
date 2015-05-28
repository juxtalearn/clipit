<?php
/**
 * Created by PhpStorm.
 * User: Pablo Llinás
 * Date: 28/05/2015
 * Time: 17:07
 */

if(ClipitDataExport::export_all(get_input("filename"))){
    system_message("Object data correctly exported");
    // Send for download
    $filepath = "/tmp/".get_input("filename");
    header("Pragma: public");
    header("Content-Type: application/download");
    header("Content-Disposition: attachment; filename='".get_input("filename")."'");
    readfile($filepath);
} else{
    register_error("Error while exporting data");
}
exit();