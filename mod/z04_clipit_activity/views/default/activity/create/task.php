<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   7/07/14
 * Last update:     7/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$task_type = elgg_extract('task_type', $vars);
switch($task_type){
    case "upload":
        $task_types = array(
            'quiz_answer' => elgg_echo('task:quiz_answer'),
            'video_upload' => elgg_echo('task:video_upload'),
            'storyboard_upload' => elgg_echo('task:storyboard_upload')
        );
        $disabled = false;
        break;
    case "feedback":
        $task_types = array(
            'video_feedback' => elgg_echo('task:video_feedback'),
            'storyboard_feedback' => elgg_echo('task:storyboard_feedback')
        );
        $disabled = true;
        break;
}
?>
<div class="col-md-12">
<?php if(!$disabled):?>
    <i class="fa fa-times red pull-left margin-top-5" style="cursor: pointer" onclick="javascript:$(this).closest('.task').remove();"></i>
<?php endif;?>
<div class="content-block">
    <div class="col-md-5">
        <div class="form-group">
            <label for="task-title"><?php echo elgg_echo("task:title");?></label>
            <?php echo elgg_view("input/text", array(
                'name' => 'task-title[]',
                'class' => 'form-control',
                'required' => true
            ));
            ?>
        </div>
    </div>
    <div class="col-md-3">
        <label for="task-type"><?php echo elgg_echo("task:task_type");?></label>
        <?php echo elgg_view('input/dropdown', array(
            'name' => 'task-type[]',
            'class' => 'form-control task-types',
            'style' => 'padding-top: 5px;padding-bottom: 5px;',
            'disabled' => $disabled,
            'options_values' => $task_types
        ));
        ?>
    </div>
    <div class="col-md-2">
        <label for="task-start"><?php echo elgg_echo("task:start");?></label>
        <?php echo elgg_view("input/text", array(
            'name' => 'task-start[]',
            'class' => 'form-control datepicker',
            'required' => true
        ));
        ?>
    </div>
    <div class="col-md-2">
        <label for="task-end"><?php echo elgg_echo("task:end");?></label>
        <?php echo elgg_view("input/text", array(
            'name' => 'task-end[]',
            'class' => 'form-control datepicker',
            'required' => true
        ));
        ?>
    </div>
    <div class="col-md-8">
        <div class="form-group">
            <label for="task-description"><?php echo elgg_echo("task:description");?></label>
            <?php echo elgg_view("input/plaintext", array(
                'name' => 'task-description[]',
                'class' => 'form-control',
                'required' => true,
                'rows' => 1,
                'onclick' => 'javascript:this.rows=5;'
            ));
            ?>
        </div>
    </div>
    <?php if(!$disabled):?>
    <div class="col-md-4 feedback-module" style="display: none;padding: 10px;background: #fafafa;">
        <label for="activity-title"><?php echo elgg_echo("task:feedback:check");?></label>
        <div class="checkbox feedback-check">
            <label>
                <input type="checkbox" value="1" name="feedback[]"> <?php echo elgg_echo("task:feedback:check");?>
            </label>
        </div>
    </div>
    <?php endif;?>
    </div>
</div>