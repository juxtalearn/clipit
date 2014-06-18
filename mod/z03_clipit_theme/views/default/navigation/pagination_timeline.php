<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 20/02/14
 * Time: 12:03
 * To change this template use File | Settings | File Templates.
 */
$user_id = elgg_get_logged_in_user_guid();
$offset = (int)get_input('offset');
$view_type = get_input('view');
$type = get_input('type');
$id = (int)get_input('id');
$recommended_events = array();
switch($type){
    case "group":
        $recommended_events = ClipitEvent::get_by_object(array($id), $offset, 5);
        break;
    default:
        $recommended_events = ClipitEvent::get_recommended_events($user_id, $offset, 5);
        break;
}
?>
<ul class="events">
<?php foreach ($recommended_events as $event_log):?>
    <?php echo $show_recommended = view_recommended_event($event_log, $view_type); ?>
<?php endforeach; ?>
</ul>
<?php if($show_recommended): ?>
    <div class="timeline-more">
        <?php echo elgg_view('output/url', array(
            'href'  => 'ajax/view/navigation/pagination_timeline?view='.$view_type.'&type='.$type.'&id='.$id.'&offset='.$offset,
            'text'  => 'More',
            'class' => 'events-more-link'
        )); ?>
    </div>
<?php endif; ?>