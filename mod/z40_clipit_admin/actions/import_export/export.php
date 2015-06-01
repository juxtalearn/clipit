<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, URJC JuxtaLearn Team
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 * @subpackage      clipit_admin
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