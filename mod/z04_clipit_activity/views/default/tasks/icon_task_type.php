<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   23/06/14
 * Last update:     23/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$type = elgg_extract('type', $vars);

switch($type){
    case "video_upload":
    case "storyboard_upload":
        $output = "arrow-up";
        break;
    case "quiz_answer":
        $output = "pencil-square-o";
        break;
    case "video_feedback":
    case "storyboard_feedback":
        $output = "signal";
        break;
}
?>
<i style="font-size: 14px;" class="blue fa fa-<?php echo $output; ?>"></i>