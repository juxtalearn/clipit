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
$entity_type = elgg_extract('entity_type', $vars);
$list_view = elgg_extract('list_view', $vars);
$entities_ids = array();
foreach($entities as $entity_object) {
    $entities_ids[] = $entity_object->id;
}
$groups = ClipitGroup::get_by_id($activity->group_array, 0, 0, 'name');
natural_sort_properties($groups, 'name');
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
        $(".panel-collapse.feedback-load").on("show.bs.collapse",function(){
            var content = $(this).closest(".panel").find(".panel-body");
            var us_id = $(this).data("user");
            if(content.is(':empty')){
                content.html('<i class="fa fa-spinner fa-spin fa-2x blue"></i>');
                elgg.get("ajax/view/publications/admin/user_ratings", {
                    data: {
                        entities_ids: <?php echo json_encode($entities_ids);?>,
                        user_id: us_id
                    },
                    success: function (data) {
                        content.html(data);
                    }
                });
            }
        });
        var container = $("#students");
        elgg.get("ajax/view/tasks/admin/feedback_data", {
            dataType: "json",
            data: {
                type: '<?php echo $entity_type;?>',
                task: <?php echo $task->id;?>,
                activity: <?php echo $activity->id;?>,
            },
            success: function (output) {
                $.each(output, function (i, data) {
                    container.find("[data-entity="+data.entity+"] .status").html(data.status);
                });
            }
        });
        var hash = window.location.hash.replace('#', '');
        var collapse = $("[href='#user_"+hash+"']");
        if(collapse.length > 0){
            collapse.click();
        }

    });
</script>
<div role="presentation">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#students" aria-controls="students" role="tab" data-toggle="tab"><?php echo elgg_echo('students');?></a>
        </li>
        <li role="presentation">
            <a href="#items" role="tab" data-toggle="tab">
                <?php echo elgg_echo($entity_type);?>
                (<?php echo count($entities);?>)
            </a>
        </li>
        <?php if($task->rubric_item_array):?>
        <li role="presentation">
            <a href="#rubric" aria-controls="rubric" role="tab" data-toggle="tab"><?php echo elgg_echo('rubric');?></a>
        </li>
        <?php endif;?>
    </ul>
</div>
<!-- Tab panes -->
<div class="tab-content">
    <div role="presentation" class="tab-pane active" id="students" aria-label="<?php echo elgg_echo('students');?>" style="padding: 10px;">
        <p>
            <?php echo elgg_view('output/url', array(
                'title' => elgg_echo('expand:all'),
                'text' => elgg_echo('expand:all'),
                'href' => "javascript:;",
                'class' => 'panel-expand-all',
            ));
            ?>
            <span class="text-muted">|</span>
            <?php echo elgg_view('output/url', array(
                'title' => elgg_echo('collapse:all'),
                'text' => elgg_echo('collapse:all'),
                'href' => "javascript:;",
                'class' => 'panel-collapse-all',
            ));
            ?>
        </p>
        <?php
        foreach($groups as $group):
            $users = ClipitUser::get_by_id($group->user_array, 0, 0, 'name');
            ?>
            <?php echo elgg_view("page/components/title_block", array(
                'title' => $group->name,
            ));?>
            <ul class="panel-group" id="accordion_users">
                <?php foreach($users as $user):?>
                    <li class="panel panel-blue list-item" data-entity="<?php echo $user->id;?>">
                        <a name="<?php echo $user->id;?>"></a>
                        <div class="panel-heading expand" style="padding: 0px;background: none;">
                            <div class="pull-right blue">
                                <div class="status inline-block">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </div>
                                <a data-toggle="collapse"
                                   data-parent="#accordion_users"
                                   href="#user_<?php echo $user->id;?>"
                                   class="btn btn-border-blue margin-left-10 btn-xs btn-primary user-rating"
                                    >
                                    <?php echo elgg_echo('view');?>
                                </a>
                            </div>
                            <?php echo elgg_view("page/elements/user_block", array("entity" => $user)); ?>
                        </div>
                        <div class="clearfix"></div>
                        <div id="user_<?php echo $user->id;?>"
                             class="panel-collapse collapse feedback-load"
                             data-user="<?php echo $user->id;?>"
                            >
                            <div class="panel-body"></div>
                        </div>
                    </li>
                <?php endforeach;?>
            </ul>
        <?php endforeach;?>
    </div>
    <div role="presentation" class="tab-pane margin-top-10" id="items" style="padding: 10px;">
        <?php
        echo elgg_view($list_view, array(
            'entities'    => $entities_ids,
            'href'      => "clipit_activity/{$activity->id}/publications",
        ));
        ?>
    </div>
    <?php if($task->rubric_item_array):?>
    <div role="presentation" class="tab-pane margin-top-10" id="rubric" style="padding: 10px;">
        <?php
        echo elgg_view('rubric/items', array(
            'entities'    => ClipitRubricItem::get_by_id($task->rubric_item_array, 0, 0, 'time_created', false),
        ));
        ?>
    </div>
    <?php endif;?>
</div>