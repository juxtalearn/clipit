<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   6/05/14
 * Last update:     6/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$file = elgg_extract('file', $vars);

switch($file->mime_full){
    case "application/pdf":
        $file_view = '<i style="color: #E20000;" class="fa fa-file-pdf-o file-icon"></i>';
        break;
    // Microsoft Word
    case "application/vnd.openxmlformats-officedocument.wordprocessingml.document":
    case "application/msword":
        $file_view = '<i style="color: #26468F;" class="fa fa-file-word-o file-icon"></i>';
        break;
    // Microsoft Excel
    case "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet":
    case "application/vnd.ms-excel":
        $file_view = '<i style="color: #008D33;" class="fa fa-file-excel-o file-icon"></i>';
        break;
    // Microsoft PowerPoint
    case "application/vnd.openxmlformats-officedocument.presentationml.presentation":
    case "application/vnd.ms-powerpoint":
        $file_view = '<i style="color: #DA4C13;" class="fa fa-file-powerpoint-o file-icon"></i>';
        break;
    case "application/x-rar":
    case "application/zip":
        $file_view = '<i style="color: #EBAB3E;" class="fa fa-file-zip-o file-icon"></i>';
        break;
    default:
        $file_view = '<i class="fa fa-file file-icon"></i>';
        break;
}
$size = elgg_extract('size', $vars);
if(!$size){
    $size = 'small';
}
switch ($file->mime_short){
    case "image":
        $file_view = '<div class="img-preview">
                    <div style="background-image: url(\''.elgg_normalize_url(elgg_format_url("file/thumbnail/{$size}/$file->id")).'\');"></div>
                 </div>';
        break;
    case "audio":
        $file_view = '<i class="fa fa-volume-up file-icon"></i>';
        break;
    case "video":
        $file_view = '<i class="fa fa-file-video-o file-icon"></i>';
        break;
}

echo $file_view;
