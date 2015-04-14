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
$id = elgg_extract('id', $vars);
$task = elgg_extract('task', $vars); // task data

switch($task_type){
    case "upload":
        $task_types = array(
            ClipitTask::TYPE_QUIZ_TAKE => elgg_echo('task:quiz_answer'),
            ClipitTask::TYPE_VIDEO_UPLOAD => elgg_echo('task:video_upload'),
            ClipitTask::TYPE_STORYBOARD_UPLOAD => elgg_echo('task:storyboard_upload'),
            ClipitTask::TYPE_RESOURCE_DOWNLOAD => elgg_echo('task:resource_download'),
            ClipitTask::TYPE_OTHER => elgg_echo('task:other')
        );
        $input_array = "[{$id}]";
        $disabled = false;
        break;
    case "feedback":
        $task_types = array(
            ClipitTask::TYPE_VIDEO_FEEDBACK => elgg_echo('task:video_feedback'),
            ClipitTask::TYPE_STORYBOARD_FEEDBACK => elgg_echo('task:storyboard_feedback')
        );
        $input_array = "[{$id}][feedback-form]";
        $disabled = true;
        break;
    case "download":
        $task_types = array(
            ClipitTask::TYPE_RESOURCE_DOWNLOAD => elgg_echo('task:resource_download'),
        );
        $input_array = "[{$id}]";
        $disabled = false;
        break;
}
$task_types = array_merge(array('' => elgg_echo('task:select:task_type')), $task_types);
if($vars['required'] !== false){
    $required = true;
}
?>
<div class="col-mds-12">
    <?php if(!$disabled && !$task && $vars['delete_task']!==false):?>
        <i class="delete-task fa fa-times red pull-left margin-top-5" style="cursor: pointer" onclick="javascript:$(this).closest('.task').remove();"></i>
    <?php endif;?>
    <div class="content-block">
        <div class="col-md-5">
            <div class="form-group">
                <label for="task-title"><?php echo elgg_echo("task:title");?></label>
                <?php echo elgg_view("input/text", array(
                    'name' => "task{$input_array}[title]",
                    'class' => 'form-control input-task-title',
                    'value' => $task->name,
                    'required' => $required
                ));
                ?>
            </div>
        </div>
        <div class="col-md-3">
            <label for="task-type"><?php echo elgg_echo("task:task_type");?></label>
            <?php echo elgg_view('input/dropdown', array(
                'name' => "task{$input_array}[type]",
                'class' => 'form-control task-types',
                'style' => 'padding-top: 5px;padding-bottom: 5px;',
                'required' => $required,
                'disabled' => $task->task_type ? true : $disabled,
                'value' => $vars['default_task'] ? $vars['default_task'] : $task->task_type,
                'options_values' => $task_types
            ));
            ?>
            <?php if($disabled):?>
                <?php echo elgg_view("input/hidden", array(
                    'name' => "task{$input_array}[type]",
                    'class' => 'form-control task-types',
                    'value' => $vars['default_task'] ? $vars['default_task'] : false,
                ));
                ?>
            <?php endif;?>
        </div>
        <div class="col-md-2">
            <label for="task-start"><?php echo elgg_echo("start");?></label>
            <?php echo elgg_view("input/text", array(
                'name' => "task{$input_array}[start]",
                'class' => 'form-control datepicker input-task-start',
                'value' => $task->start ? date("d/m/y H:i", $task->start) : "",
                'required' => $required,
                'readonly' => true
            ));
            ?>
        </div>
        <div class="col-md-2">
            <label for="task-end"><?php echo elgg_echo("end");?></label>
            <?php echo elgg_view("input/text", array(
                'name' => "task{$input_array}[end]",
                'class' => 'form-control datepicker input-task-end',
                'value' => $task->end ? date("d/m/y H:i", $task->end) : "",
                'required' => $required,
                'readonly' => true
            ));
            ?>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <label for="task-description"><?php echo elgg_echo("description");?></label>
                <?php echo elgg_view("input/plaintext", array(
                    'name' => "task{$input_array}[description]",
                    'class' => 'form-control',
                    'value' => $task->description,
                    'rows' => $task->description ? 5:1,
                    'onclick' => 'javascript:this.rows=5;'
                ));
                ?>
            </div>
        </div>
        <?php if(!$disabled):?>
            <div class="col-md-4 feedback-module" style="<?php echo $vars['feedback_check'] != false ? '' : 'display: none;'; ?>padding: 10px;background: #fafafa;">
                <label for="activity-title"><?php echo elgg_echo("task:feedback");?></label>
                <div class="checkbox feedback-check">
                    <label>
                        <input type="checkbox" value="1" name="<?php echo "task{$input_array}[feedback]";?>"> <?php echo elgg_echo("task:feedback:check");?>
                    </label>
                </div>
            </div>
        <?php endif;?>
    </div>
    <?php if(!$disabled):?>
        <?php echo elgg_view("input/hidden", array(
            'name' => 'input_prefix',
            'value' => "task{$input_array}",
        ));
        ?>
        <div class="clearfix"></div>
        <div class="task-type-container margin-bottom-10"
             style="<?php echo $task->task_type == ClipitTask::TYPE_QUIZ_TAKE ? '':'display:none;' ;?>
                 border: 1px solid #bae6f6;border-radius: 3px;padding: 10px;">
            <?php if($task):
                switch($task->task_type){
                    case ClipitTask::TYPE_QUIZ_TAKE:
                        echo elgg_view('activity/admin/tasks/quiz/quiz', array(
                            'entity' => array_pop(ClipitQuiz::get_by_id(array($task->quiz))),
                            'activity_id' => $task->activity,
                            'input_prefix' => "task{$input_array}"
                        ));
                        break;
                }
            endif;
            ?>
        </div>
    <?php endif;?>
</div>
<?php
if(!$disabled):
    $attach = $vars['entity'];
    $attach['id'] = $id;
?>
    <?php if($attach['selected']):?>
        <script>
            $(function(){
                $("[data-attach='<?php echo $attach['id'];?>']").attach_multimedia({
                    default_list: "files",
                    data:{
                        list: $(this).data("menu"),
                        entity_id: "<?php echo $task->activity;?>",
                        selected: <?php echo $attach['selected'];?>
                    }
                }).loadAll();
            });
        </script>
    <?php endif;?>

    <?php echo elgg_view("multimedia/attach/list", $attach);?>

<?php endif;?>