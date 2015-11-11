<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   23/06/14
 * Last update:     23/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$type = elgg_extract('type', $vars);

switch($type){
    case ClipitTask::TYPE_VIDEO_UPLOAD:
        $title = elgg_echo('task:video_upload');
        echo '<span class="fa-stack fa-lg blue " title="'.$title.'" style="font-size: 50%;">
                  <i class="fa fa-file-o fa-stack-2x"></i>
                  <i class="fa fa-plus fa-stack-1x" style="top:2px;"></i>
              </span>';
        $custom = true;
        break;
    case ClipitTask::TYPE_FILE_UPLOAD:
        $title = elgg_echo('task:file_upload');
        echo '<span class="fa-stack fa-lg blue " title="'.$title.'" style="font-size: 50%;">
                  <i class="fa fa-file-o fa-stack-2x"></i>
                  <i class="fa fa-plus fa-stack-1x" style="top:2px;"></i>
              </span>';
        $custom = true;
        break;
    case ClipitTask::TYPE_QUIZ_TAKE:
        $title = elgg_echo('task:quiz_answer');
        $icon = "pencil-square-o";
        break;
    case ClipitTask::TYPE_VIDEO_FEEDBACK:
        $title = elgg_echo('task:video_feedback');
        $icon = "comment";
        break;
    case ClipitTask::TYPE_FILE_FEEDBACK:
        $title = elgg_echo('task:file_feedback');
        $icon = "comment";
        break;
    case ClipitTask::TYPE_OTHER:
        $title = elgg_echo('task:other');
        $icon = "question-circle";
        break;
    case ClipitTask::TYPE_RESOURCE_DOWNLOAD:
        $title = elgg_echo('task:resource_download');
        $icon = "eye";
        break;
}
?>
<?php if(!$custom):?>
<i style="<?php echo $vars['size']!==false ? 'font-size: 14px;' : '';?>" class="blue fa fa-<?php echo $icon; ?>" title="<?php echo $title; ?>"></i>
<?php endif;?>