<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   5/05/14
 * Last update:     5/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
// Get the guid
$file_id = (int)get_input("id");
$size = get_input("size");

echo $size;
// Get the file
$mime_type = $file->mime_type;
$file = array_pop(ClipitFile::get_by_id(array($file_id)));
header("Pragma: public");
header("Content-type: {$mime_type['full']}");
header("Content-Disposition: inline; filename='{$file->name}'");

switch ($size) {
    case "small":
        $thumbdata = file_get_contents($file->thumb_small['path']);
        break;
    case "normal":
        $thumbdata = file_get_contents($file->thumb_normal['path']);
        break;
    case "large":
        $thumbdata = file_get_contents($file->thumb_large['path']);
        break;
    default:
        $thumbdata = file_get_contents($file->file_path);
        break;
}
ob_clean();
flush();
echo $thumbdata;
exit;