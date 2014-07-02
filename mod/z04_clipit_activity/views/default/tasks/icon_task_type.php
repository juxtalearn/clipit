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
        $title = elgg_echo('task:video_upload');
        $icon = "arrow-up";
        break;
    case "storyboard_upload":
        $title = elgg_echo('task:storyboard_upload');
        $icon = "arrow-up";
        break;
    case "quiz_answer":
        $title = elgg_echo('task:quiz_answer');
        $icon = "pencil-square-o";
        break;
    case "video_feedback":
        $title = elgg_echo('task:video_feedback');
        $icon = "signal";
        break;
    case "storyboard_feedback":
        $title = elgg_echo('task:storyboard_feedback');
        $icon = "signal";
        break;
}
?>
<i style="font-size: 14px;" class="blue fa fa-<?php echo $icon; ?>" title="<?php echo $title; ?>"></i>