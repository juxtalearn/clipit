<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   28/04/14
 * Last update:     28/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
// Get the guid
$file_id = get_input("id");

// Get the file
$file = array_pop(ClipitFile::get_by_id(array($file_id)));
header("Pragma: public");
header("Content-Disposition: attachment; filename=\"$file->name\"");
ob_clean();
flush();
readfile($file->file_path);
exit;
