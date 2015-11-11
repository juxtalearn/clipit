<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   5/05/14
 * Last update:     5/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
// Get the guid
$file_id = (int)get_input("id");
$size = get_input("size");

// Get the file
$file = array_pop(ClipitFile::get_by_id(array($file_id)));
$etag = $file_id;
header("Pragma: public");
header("Content-type: {$file->mime_full}");
header("Content-Disposition: inline; filename=\"{$file->name}\"");
header("Cache-Control: public", true);
header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', strtotime("+6 months")), true);
header("ETag: \"$etag\"");

switch ($size) {
    case "small":
        $thumbdata = $file->thumb_small['path'];
        break;
    case "medium":
        $thumbdata = $file->thumb_medium['path'];
        break;
    case "large":
        $thumbdata = $file->thumb_large['path'];
        break;
    default:
        $thumbdata = $file->file_path;
        break;
}
$content_length = @filesize($thumbdata);
header("Content-Length: $content_length");

readfile($thumbdata);

exit;