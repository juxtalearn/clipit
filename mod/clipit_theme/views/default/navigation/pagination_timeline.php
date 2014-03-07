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
$recommended_events = ClipitEvent::get_recommended_events($user_id, $offset, 5);

echo '<ul class="events">'.clipit_student_events($recommended_events).'</ul>';
