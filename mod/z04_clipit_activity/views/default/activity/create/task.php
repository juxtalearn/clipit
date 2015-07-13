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
            ClipitTask::TYPE_FILE_UPLOAD => elgg_echo('task:file_upload'),
            ClipitTask::TYPE_RESOURCE_DOWNLOAD => elgg_echo('task:resource_download'),
            ClipitTask::TYPE_OTHER => elgg_echo('task:other')
        );
        $input_array = "[{$id}]";
        $disabled = false;
        break;
    case "feedback":
        $task_types = array(
            ClipitTask::TYPE_VIDEO_FEEDBACK => elgg_echo('task:video_feedback'),
            ClipitTask::TYPE_FILE_FEEDBACK => elgg_echo('task:file_feedback')
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
if($task){
    echo elgg_view("input/hidden", array(
        'name' => "task{$input_array}[entity_type]",
        'value' => $task->task_type,
    ));
}
?>
<style>
    .dummy {
        padding-top: 100%;
    }
    .btns-task-select label{
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
    }
    .thumbnail {
        position: relative;
        border: 1px solid #ddd !important;
        border-radius: 4px;
        padding: 4px;
        margin-bottom: 0;
        height: 50px;
    }
    .btns-task-select .thumbnail.active,
    .thumbnail:hover{
        border: 1px solid #32b4e5 !important;

    }
    .btns-task-select .thumbnail.active{
        background: rgb(236, 247, 252);
    }
    .btns-task-select .thumbnail.active .task-icon,
    .thumbnail:hover .task-icon{
        color: #32b4e5;
    }
    .btns-task-select li{
         float: left;
     }
    .btns-task-select li:hover{
        background: none !important;
    }
    .btns-task-select li a{
        position: initial;
        padding: 0;
        opacity: 1 !important;
    }
    .btns-task-select .task-title{
        overflow: hidden;
        text-align: left;
        font-weight: bold;
        font-size: 85%;
        position: relative;
        top: 50%;
        -ms-transform: translateY(-50%);
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
    }
    .btns-task-select .task-icon{
        float: left;
        width: 40px;
        height: 40px;
        margin-right: 10px;
        transition: all .2s ease-in-out;
    }
    .btns-task-select .task-icon .fa-circle{
        font-size: 40px;
    }
    .btns-task-select .task-icon .fa-inverse{
        font-size: 20px;
        line-height: 40px;
    }
    .task-type-container{
        border: 1px solid rgb(186, 230, 246);
        border-radius: 3px;
        padding: 10px;
        margin-bottom: 10px;
    }
    .task-type-container #attach_list{
        background: none;
        margin: 0 -15px;
        border: 0;
        border-radius: 3px;
        overflow: hidden;
        padding: 0 !important;
    }
    .label-task-type span.error{
        float: none !important;
        margin-left: 10px;
    }
</style>
<div class="col-mds-12 <?php echo $disabled ? 'feedback_task' : 'main_task';?>">
    <?php if(!$disabled && !$task && $vars['delete_task']!==false):?>
        <div class="margin-left-10 pull-left margin-top-10 margin-right-10">
        <a class="btn btn-border-red btn-default btn-icon show" onclick="javascript:$(this).closest('.task').remove();">
            <i class="delete-task fa fa-trash-o red cursor-pointer"></i>
        </a>
        </div>
    <?php endif;?>
    <div class="row <?php echo (!$disabled && !$task &&$vars['delete_task']!==false) ? 'col-md-11':'';?>">
        <div class="col-md-8">
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
            <?php if($disabled):?>
                <?php echo elgg_view("input/hidden", array(
                    'name' => "task{$input_array}[type]",
                    'class' => 'feedback-task-type',
                    'value' => $vars['default_task'] ? $vars['default_task'] : false,
                ));
                ?>
            <?php endif;?>
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
        <?php if(!$disabled):?>
            <div class="col-md-12 margin-bottom-10">
                <label class="label-task-type" for="task<?php echo $input_array;?>[type]"><?php echo elgg_echo("task:task_type");?></label>
                <div class="row btns-task-select">
                <?php echo elgg_view('tasks/menu', array(
                        'input_array' => $input_array,
                        'entity' => $task
                    ));
                ?>
                </div>
            </div>
        <?php endif;?>
        <div class="col-md-8">
            <div class="form-group">
                <label for="task-description"><?php echo elgg_echo("description");?></label>
                <?php echo elgg_view("input/plaintext", array(
                    'name' => "task{$input_array}[description]",
                    'class' => 'form-control input-task-description',
                    'value' => $task->description,
                    'rows' => $task->description ? 5:1,
                    'onclick' => 'javascript:this.rows=5;'
                ));
                ?>
            </div>
        </div>

        <?php if(!$disabled):?>
            <?php echo elgg_view("input/hidden", array(
                'name' => 'input_prefix',
                'value' => "task{$input_array}",
            ));
            ?>
            <div class="col-md-4 feedback-module" style="<?php echo $vars['feedback_check'] != false ? '' : 'display: none;'; ?>padding: 10px;background: #fafafa;">
                <label for="activity-title"><?php echo elgg_echo("task:feedback");?></label>
                <div class="checkbox feedback-check">
                    <label>
                        <input type="checkbox" value="1" name="<?php echo "task{$input_array}[feedback]";?>"> <?php echo elgg_echo("task:feedback:check");?>
                    </label>
                </div>
            </div>
        <?php endif;?>
        <?php
        $feedback_id = false;
        if($task->task_type == ClipitTask::TYPE_VIDEO_UPLOAD || $task->task_type == ClipitTask::TYPE_FILE_UPLOAD):
            if($feedback_id = ClipitTask::get_child_task($task->id)):
                $feedback_task = array_pop(ClipitTask::get_by_id(array($feedback_id)));
        ?>
            <div class="col-md-4" style="padding: 10px;background: #fafafa;">
                <label><?php echo elgg_echo("task:feedback");?></label>
                <strong>
                <?php echo elgg_view('output/url', array(
                    'href'  => '#edit-task-'.$feedback_task->id,
                    'target' => '_blank',
                    'title' => $feedback_task->name,
                    'text'  => elgg_view("tasks/icon_task_type", array('type' => $feedback_task->task_type)) . ' '.$feedback_task->name
                ));
                ?>
                </strong>
                <small class="show margin-top-5">
                    <strong><?php echo elgg_echo('start');?>: </strong>
                    <?php echo elgg_view('output/friendlytime', array('time' => $feedback_task->start));?>,
                    <strong><?php echo elgg_echo('end');?>: </strong>
                    <?php echo elgg_view('output/friendlytime', array('time' => $feedback_task->end));?>
                </small>
            </div>
            <?php endif;?>
        <?php endif;?>
    </div>
<!--    --><?php //if(!$disabled):?>
        <?php echo elgg_view("input/hidden", array(
            'name' => 'input_prefix',
            'value' => "task{$input_array}",
        ));
        ?>
        <div class="clearfix"></div>
        <?php if(!$feedback_id):?>
            <div class="task-type-container bg-white" style="display: <?php echo $task ? 'block':'none';?>">
                <?php echo elgg_view('tasks/container', array(
                    'input_array' => $input_array,
                    'entity' => $task,
                    'params' => $vars['entity'],
                    'id' => $id
                ));?>
            </div>
        <?php endif;?>
<!--    --><?php //endif;?>
</div>