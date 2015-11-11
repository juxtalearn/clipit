<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, URJC Clipit Team
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 * @subpackage      clipit_admin
 */
$filename = get_input("filename");
$filepath = ClipitDataExport::export_all($filename);
if(!empty($filepath)){
    system_message("Object data correctly exported");
    // Send for download
    header("Pragma: public");
    header("Content-Type: application/download");
    header("Content-Disposition: attachment; filename='".$filename."'");
    readfile($filepath);
    exit();
} else{
    register_error("Error while exporting data");
}
