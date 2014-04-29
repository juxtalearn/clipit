<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   28/04/14
 * Last update:     28/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
// Get the guid
$file_id = get_input("id");
echo $file_id;
die();
// Get the file
$file = get_entity($file_guid);
if (!$file) {
    register_error(elgg_echo("file:downloadfailed"));
    forward();
}

$mime = $file->getMimeType();
if (!$mime) {
    $mime = "application/octet-stream";
}

$filename = $file->originalfilename;

// fix for IE https issue
header("Pragma: public");

header("Content-type: $mime");
if (strpos($mime, "image/") !== false || $mime == "application/pdf") {
    header("Content-Disposition: inline; filename=\"$filename\"");
} else {
    header("Content-Disposition: attachment; filename=\"$filename\"");
}

ob_clean();
flush();
readfile($file->getFilenameOnFilestore());
exit;
