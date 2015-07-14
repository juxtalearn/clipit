<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 20/02/14
 * Time: 12:03
 * To change this template use File | Settings | File Templates.
 */
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
        $user_id = elgg_get_logged_in_user_guid();
        $user = array_pop(ClipitUser::get_by_id(array($user_id)));
        if($user->role == ClipitUser::ROLE_ADMIN){
            $recommended_events = ClipitEvent::get_all_events($offset, 5);
        } else {
            $recommended_events = ClipitEvent::get_recommended_events($user_id, $offset, 5, get_recommended_relationships());
        }
        break;
}
?>
<ul class="events">
<?php foreach ($recommended_events as $event_log):?>
    <?php echo view_recommended_event($event_log, $view_type); ?>
<?php endforeach; ?>
</ul>
<div class="timeline-more">
<?php if($recommended_events && $offset < 4): ?>
    <?php echo elgg_view('output/url', array(
        'href'  => 'ajax/view/navigation/pagination_timeline?view='.$view_type.'&type='.$type.'&id='.$id.'&offset='.$offset,
        'text'  => elgg_echo('view_more'),
        'class' => 'events-more-link'
    ));
    ?>
<?php elseif($offset > 4): ?>
    <?php echo elgg_view('output/url', array(
        'href'  => 'ajax/view/navigation/pagination_timeline?view='.$view_type.'&type='.$type.'&id='.$id.'&offset='.$offset,
        'text'  => elgg_echo('view_more'),
    ));
    ?>
<?php endif;?>
</div>