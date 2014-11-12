<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   18/07/14
 * Last update:     18/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$activity = elgg_extract('entity', $vars);
$tasks = ClipitTask::get_by_id($activity->task_array);
elgg_load_js("fullcalendar:moment");
elgg_load_js("fullcalendar");
elgg_load_css("fullcalendar");
$id = uniqid();
?>
<script>
    <?php echo elgg_view("js/admin_tasks", array('entity' => $activity, 'tasks' => $tasks));?>
</script>
<script src="http://cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css"  href="//cdn.datatables.net/1.10.4/css/jquery.dataTables.css">
<script>
$(function(){
    $(document).on("click", ".from-tags", function(){
        $(this).parent("div").find("table").show().dataTable();
    });
});
</script>
<div>
    <small class="show"><?php echo elgg_echo('view_as');?></small>
    <?php echo elgg_view('output/url', array(
        'href'  => "javascript:;",
        'id' => 'calendar',
        'class' => 'btn btn-xs btn-border-blue active button-view-as',
        'text'  => '<i class="fa fa-calendar"></i> Calendar',
    ));
    ?>
    <?php echo elgg_view('output/url', array(
        'href'  => "javascript:;",
        'id' => 'list',
        'class' => 'btn btn-xs btn-border-blue button-view-as',
        'text'  => '<i class="fa fa-th-list"></i> List',
    ));
    ?>
</div>

<button type="button" data-toggle="modal" data-target="#create-new-task" class="btn btn-default margin-top-10">
    <?php echo elgg_echo('task:create'); ?>
</button>
<hr>
<!-- Calendar view -->
<div id="full-calendar" class="view-element" data-view="calendar"></div>
<script>
    $(function(){
        $(document).on("change", "select.task-types", function(){
            var $attach_list =  $(".attach_list[data-attach='<?php echo $id;?>']");
            if($(this).val() == '<?php echo ClipitTask::TYPE_RESOURCE_DOWNLOAD;?>'){
                $attach_list.toggle();
                $attach_list.attach_multimedia({
                    data: {
                        list: $(this).data("menu"),
                        entity_id: "<?php echo $activity->id;?>"
                    }
                }).loadBy("files");
            } else {
                $attach_list.hide();
            }
        });
    });
</script>
<?php echo elgg_view_form('task/create', array('data-validate' => "true" ), array('entity'  => $activity, 'id' => $id)); ?>

<div class="margin-bottom-20 view-element" data-view="list" style="display: none"></div>
<ul>
    <?php
    foreach($tasks as $task):
        // Task edit (modal remote)
        echo '<li>'.elgg_view("page/components/modal_remote", array('id'=> "edit-task-{$task->id}" )).'</li>';
        if(!$task->parent_task):
    ?>
            <?php echo elgg_view('activity/admin/tasks/list', array('task' => $task));?>
            <?php
            if($task_id = ClipitTask::get_child($task->id)):
                $task = array_pop(ClipitTask::get_by_id(array($task_id)));
            ?>
                <?php echo elgg_view('activity/admin/tasks/list', array('task' => $task, 'feedback_task' => true));?>
            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach;?>
</ul>