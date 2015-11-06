<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   29/07/14
 * Last update:     29/07/14
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
    $group_id = $entity_object::get_group($entity_object->id);
    $entities_ids[$group_id] = $entity_object->id;
}
$groups = ClipitGroup::get_by_id($activity->group_array);
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
        var hash = window.location.hash.replace('#', '');
        var collapse = $("[href='#group_"+hash+"']");
        if(collapse.length > 0){
            collapse.click();
        }

    });
</script>
<div role="presentation">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#groups" aria-controls="groups" role="tab" data-toggle="tab"><?php echo elgg_echo('groups');?> (<?php echo count($groups);?>)</a>
        </li>
        <li role="presentation">
            <a href="#items" role="tab" data-toggle="tab">
                <?php echo elgg_echo($entity_type);?>
                (<?php echo count($entities);?>)
            </a>
        </li>
    </ul>
</div>
<!-- Tab panes -->
<div class="tab-content">
    <div role="presentation" class="tab-pane margin-top-10 active" id="groups" style="padding: 10px;">
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
    <ul class="panel-group" id="accordion_groups">
        <?php
        foreach($groups as $group):
            $status = ClipitTask::get_completed_status($task->id, $group->id);
            ?>
            <li class="panel panel-blue list-item">
                <a name="<?php echo $group->id;?>"></a>
                <div style="padding: 0;background: none;">
                    <div class="pull-right">
                        <?php if($entities_ids[$group->id]):?>
                            <a
                                data-toggle="collapse"
                                data-parent="#accordion_groups"
                                href="#group_<?php echo $group->id;?>"
                                data-group="<?php echo $group->id;?>"
                                class="btn btn-border-blue margin-right-10 btn-xs btn-primary expand"
                                >
                                <?php echo elgg_echo('view');?>
                            </a>
                        <?php endif;?>
                        <span class="blue">
                            <?php echo elgg_view('tasks/icon_entity_status', array('status' => $status));?>
                        </span>
                    </div>
                    <?php
                    echo elgg_view("page/components/modal_remote", array('id'=> "group-{$group->id}" ));
                    echo elgg_view('output/url', array(
                        'href'  => "ajax/view/modal/group/view?id={$group->id}",
                        'text'  => '<i class="fa fa-users"></i> '.$group->name,
                        'title' => $group->name,
                        'data-toggle'   => 'modal',
                        'data-target'   => '#group-'.$group->id
                    ));
                    ?>
                    <small class="show">
                        <?php echo count($group->user_array);?> <?php echo elgg_echo('students');?>
                    </small>
                </div>
                <div id="group_<?php echo $group->id;?>" class="panel-collapse collapse">
                    <div class="panel-body" style="padding: 0;padding-top: 10px;">
                        <?php if($entities_ids[$group->id]):?>
                            <?php
                            echo elgg_view($list_view, array(
                                'entities'    => array($entities_ids[$group->id]),
                                'options' => false,
                                'href'      => "clipit_activity/{$activity->id}/publications",
                                'task_id'   => $task->id,
                            )); ?>
                        <?php else:?>
                            <?php echo elgg_view('output/empty', array('value' => elgg_echo('publish:none')));?>
                        <?php endif;?>
                    </div>
                </div>
            </li>
        <?php endforeach;?>
    </ul>
    </div>
    <div role="presentation" class="tab-pane margin-top-10" id="items" style="padding: 10px;">
        <?php
        echo elgg_view($list_view, array(
            'options' => false,
            'actions' => false,
            'entities'    => $entities_ids,
            'href'      => "clipit_activity/{$activity->id}/publications",
        ));
        ?>
    </div>
</div>