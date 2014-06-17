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
//echo '<script>p();</script>';
$recommended_events = ClipitEvent::get_recommended_events($user_id, $offset, 5);
echo '<ul class="events">';
foreach ($recommended_events as $event_log){
        echo view_recommended_event($event_log);

}
echo '</ul>';
?>
<div>
    <?php echo elgg_view('output/url', array(
        'href'  => 'ajax/view/navigation/pagination_timeline?offset='.$offset,
        'text'  => 'More',
        'class' => 'events-more-link'
    )); ?>
</div>
