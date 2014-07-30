<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   24/07/14
 * Last update:     24/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entities = elgg_extract('entities', $vars);
$activity = elgg_extract('activity', $vars);
$task = elgg_extract('task', $vars);
$entities_ids = array_keys($entities);
$groups = ClipitGroup::get_by_id($activity->group_array);
?>
<style>
.multimedia-preview .img-preview{
    width: 65px;
    max-height: 65px;
}
.multimedia-preview img {
    width: 100%;
}
.task-status{
    display: none;
}
</style>
<script>
$(function(){
    $(document).on("click", "#panel-expand-all",function(){
        $(".expand").parent(".panel").find(".panel-collapse").collapse('show');
        $(".user-rating").click();
    });
    $(document).on("click", "#panel-collapse-all",function(){
        $(".expand").parent(".panel").find(".panel-collapse").collapse('hide');
    });
    $(document).on("click", ".user-rating",function(){
        var content = $(this).parent(".panel").find(".panel-body");
        var us_id = $(this).data("user");
        if(content.is(':empty')){
            content.html('<i class="fa fa-spinner fa-spin fa-2x blue"></i>');
            $.get( elgg.config.wwwroot+"ajax/view/publications/admin/user_ratings", {entities_ids: <?php echo json_encode($entities_ids);?>, user_id: us_id}, function( data ) {
                content.html(data);
            });
        }
    });
    var hash = window.location.hash.replace('#', '');
    var collapse = $("[href='#collapse_"+hash+"']");
    if(collapse.length > 0){
        collapse.click();
    }

});
</script>
<p>
    <?php echo elgg_view('output/url', array(
        'title' => elgg_echo('expand:all'),
        'text' => elgg_echo('expand:all'),
        'href' => "javascript:;",
        'id' => 'panel-expand-all',
    ));
    ?>
    <span class="text-muted">|</span>
    <?php echo elgg_view('output/url', array(
        'title' => elgg_echo('collapse:all'),
        'text' => elgg_echo('collapse:all'),
        'href' => "javascript:;",
        'id' => 'panel-collapse-all',
    ));
    ?>
</p>
<div class="panel-group" id="accordion_users">
    <?php
    foreach($groups as $group):
        $users_ids = $group->user_array;
        $users = ClipitUser::get_by_id($users_ids);
    ?>
    <h4 class="title-block"><?php echo $group->name;?></h4>

    <?php
    foreach($users as $user):
//        $status = get_task_status($task,0, $user->id);
        $status = ClipitTask::get_completed_status($task->id, $user->id);
    ?>
    <div class="panel panel-blue">
        <a name="<?php echo $user->id;?>"></a>
        <div class="panel-heading cursor-pointer expand user-rating" data-user="<?php echo $user->id;?>" style="padding: 10px;">
            <strong class="pull-right blue">
                <?php echo elgg_view('tasks/icon_entity_status', array('status' => $status));?>
            </strong>
            <h4 class="panel-title blue" data-toggle="collapse" data-parent="#accordion_users" href="#collapse_<?php echo $user->id;?>">
                <?php echo elgg_view('output/img', array(
                    'src' => get_avatar($user, 'small'),
                    'class' => 'avatar-tiny margin-right-5'
                ));?>
                <?php echo $user->name;?>
            </h4>
        </div>
        <div id="collapse_<?php echo $user->id;?>" class="panel-collapse collapse">
            <div class="panel-body"></div>
        </div>
    </div>
    <?php endforeach;?>
    <?php endforeach;?>
</div>