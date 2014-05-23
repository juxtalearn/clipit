<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   7/05/14
 * Last update:     7/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$file = elgg_extract('file', $vars);
$size = elgg_extract('size', $vars);
if(!$size){
    $size = "small";
}
$mimetype = $file->mime_type;
$file_view = "";

switch($mimetype['short']){
    case "image":
        $file_view = elgg_view('output/img', array(
            'src'  => "file/thumbnail/{$size}/{$file->id}",
            'title' => $file->name,
            'class' => 'img-responsive'));
        break;
    case "document":
        if($mimetype['full'] == "application/pdf"){
            $file_view = '<div class="frame-container">';
            $file_view .= elgg_view('output/iframe', array(
                'value'  => elgg_normalize_url(elgg_format_url("file/thumbnail/{$size}/{$file->id}")),
                'title' => $file->name,));
            $file_view .= '</div>';
        }
}
if($file_view){
    $output = '<div style="margin-top:10px;">'.$file_view.'</div>';
}
echo $output;