<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   13/10/2014
 * Last update:     13/10/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$id = get_input('id');
$file = array_pop(ClipitFile::get_by_id(array($id)));
// Get the file
ob_clean();
flush();
readfile($file->file_path);
exit;