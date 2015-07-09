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
    case ClipitTask::TYPE_VIDEO_UPLOAD:
    case ClipitTask::TYPE_FILE_UPLOAD:
           $output = "users";
            $title = elgg_echo('task:group');
        break;
    case ClipitTask::TYPE_QUIZ_TAKE:
    case ClipitTask::TYPE_VIDEO_FEEDBACK:
    case ClipitTask::TYPE_STORYBOARD_FEEDBACK:
    case ClipitTask::TYPE_RESOURCE_DOWNLOAD:
        $output = "user";
        $title = elgg_echo('task:user');
        break;
}
?>
<i class="fa fa-<?php echo $output; ?>" title="<?php echo $title; ?>"></i>