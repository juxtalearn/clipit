<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   9/06/14
 * Last update:     9/06/14
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
           $output = "users";
        break;
    case "quiz_answer":
    case "video_feedback":
    case "storyboard_feedback":
        $output = "user";
        break;
}
?>
<i class="fa fa-<?php echo $output; ?>"></i>