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

// Get the file
$mime_type = $file->mime_type;
$file = array_pop(ClipitFile::get_by_id(array($file_id)));
header("Pragma: public");
header("Content-type: {$mime_type['full']}");
header("Content-Disposition: inline; filename=\"{$file->name}\"");
header("Cache-Control: public", true);
header('Expires: ' . date('r', time() + 864000));

switch ($size) {
    case "small":
        $thumbdata = file_get_contents($file->thumb_small['path']);
        break;
    case "medium":
        $thumbdata = file_get_contents($file->thumb_medium['path']);
        break;
    case "large":
        $thumbdata = file_get_contents($file->thumb_large['path']);
        break;
    default:
        $thumbdata = file_get_contents($file->file_path);
        break;
}
$content_length = strlen($thumbdata);
header("Content-Length: $content_length");

ob_clean();
flush();
echo $thumbdata;
exit;