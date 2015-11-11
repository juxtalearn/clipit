<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   21/07/14
 * Last update:     21/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$status = elgg_extract('status', $vars);

switch($status){
    case ClipitTask::STATUS_LOCKED:
        $title = elgg_echo('task:locked');
        $icon = "clock-o";
        break;
    case ClipitTask::STATUS_ACTIVE:
        $title = elgg_echo('task:active');
        $icon = "play";
        break;
    case ClipitTask::STATUS_FINISHED:
        $title = elgg_echo('task:finished');
        $icon = "stop";
        break;
}
?>
<i class="fa fa-<?php echo $icon; ?> text-muted-2" title="<?php echo $title; ?>" style="color: #C9C9C9;"></i>