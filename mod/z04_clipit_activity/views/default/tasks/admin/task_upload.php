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
$list_view = elgg_extract('list_view', $vars);
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
        });
        $(document).on("click", "#panel-collapse-all",function(){
            $(".expand").parent(".panel").find(".panel-collapse").collapse('hide');
        });

        var hash = window.location.hash.replace('#', '');
        var collapse = $("[href='#group_"+hash+"']");
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
<div class="panel-group" id="accordion_groups">
    <?php
    foreach($groups as $group):
        $status = ClipitTask::get_completed_status($task->id, $group->id);
    ?>
        <div class="panel panel-blue">
            <a name="<?php echo $group->id;?>"></a>
            <div data-toggle="collapse" data-parent="#accordion_groups" href="#group_<?php echo $group->id;?>" class="panel-heading cursor-pointer expand" data-group="<?php echo $group->id;?>" style="padding: 10px;">
                <strong class="pull-right blue">
                    <?php echo elgg_view('tasks/icon_entity_status', array('status' => $status));?>
                </strong>
                <h4  class="panel-title blue">
                    <?php echo $group->name;?>
                </h4>
            </div>
            <div id="group_<?php echo $group->id;?>" class="panel-collapse collapse">
                <div class="panel-body" style="padding: 0;padding-top: 10px;">
                    <?php
                    $not_found = true;
                    if($entities):
                    foreach($entities as $entity):
                        if($entity::get_group($entity->id) == $group->id):
                            $not_found = false;
                    ?>
                        <?php echo elgg_view($list_view, array(
                            'entities'    => array($entity->id),
                            'href'      => "clipit_activity/{$activity->id}/publications",
                            'task_id'   => $task->id,
                        ));
                        ?>
                    <?php endif;?>
                    <?php endforeach;?>
                    <?php endif;?>

                    <?php if($not_found):?>
                        <?php echo elgg_view('output/empty', array('value' => elgg_echo('publish:none')));?>
                    <?php endif;?>
                </div>
            </div>
        </div>
    <?php endforeach;?>
</div>