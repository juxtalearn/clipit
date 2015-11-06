<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   13/06/14
 * Last update:     13/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity = elgg_extract('entity', $vars);
$activities = ClipitUser::get_activities($entity->id);
$activities = ClipitActivity::get_by_id($activities);
?>
<style>
.event-simple .avatar-small{
    display: none;
}
.event-simple .event-author{
    display: none !important;
}
.event-simple small{
    font-size: 14px;
}
</style>
<div class="row">
    <div class="col-md-3">
        <div class="margin-bottom-10">
            <?php echo elgg_view("messages/compose_icon", array(
                'entity' => $entity,
                'text' => ' '.elgg_echo('message:send'),
                'class' => 'btn btn-primary child-decoration-none',
            ))
            ;?>
        </div>
        <?php echo elgg_view('output/img', array(
            'src' => get_avatar($entity, 'large'),
            'style' => 'width: auto',
            'class' => 'avatar-large',
            'alt' => 'Avatar',
            'aria-label' => 'Avatar'
        ));
        ?>
        <ul class="margin-top-20" style="display: none">
            <?php foreach($activities as $activity):?>
            <li class="list-item">
                <span class="activity-point" style="background: #<?php echo $activity->color;?>"></span>
                <strong>
                <?php echo elgg_view('output/url', array(
                    'href'  => "clipit_activity/{$activity->id}",
                    'title' => $activity->name,
                    'text'  => $activity->name,
                ));
                ?>
                </strong>
            </li>
            <?php endforeach;?>
        </ul>
    </div>
    <div class="col-md-9">
        <h3 class="title-block margin-bottom-5">
            <?php echo elgg_echo('activities');?>
        </h3>
        <?php if(count($activities) == 0):?>
            <?php echo elgg_view('output/empty', array('value' => elgg_echo('activities:none')));?>
        <?php endif;?>
        <div class="row">
            <?php foreach($activities as $activity):?>
                <div class="col-md-12 margin-top-15">
                    <div class="pull-right">
                        <small class="activity-status status-<?php echo $activity->status;?>">
                            <strong><?php echo elgg_echo("status:".$activity->status);?></strong>
                        </small>
                    </div>
                    <h4 class="margin-bottom-5 margin-0">
                        <span class="activity-point" style="background: #<?php echo $activity->color;?>"></span>
                        <?php echo elgg_view('output/url', array(
                            'href'  => "clipit_activity/{$activity->id}",
                            'title' => $activity->name,
                            'text'  => $activity->name,
                        ));
                        ?>
                    </h4>
                    <div style='color: #999;text-transform: uppercase;'>
                        <i class='fa fa-calendar'></i>
                        <?php echo date("d M Y", $activity->start);?>
                        -
                        <?php echo date("d M Y", $activity->end);?>
                    </div>
                    <div style='height: 40px; overflow: hidden; color: #666666;margin-top: 5px; '>
                        <?php echo $activity->description; ?>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
        <?php echo elgg_view("page/components/title_block", array(
            'title' => elgg_echo('timeline:public'),
        ));?>
        <ul>
            <?php
            $limit = 100;
            $recommended_events = ClipitEvent::get_by_object(array($entity->id), 0, $limit);
            foreach ($recommended_events as $event_log){
                $content .= view_recommended_event($event_log, 'simple');
            }
            if(!$content){
                $content = elgg_view('output/empty', array('value' => elgg_echo('timeline:none')));
            }
            echo $content;

            ?>
        </ul>
    </div>
</div>