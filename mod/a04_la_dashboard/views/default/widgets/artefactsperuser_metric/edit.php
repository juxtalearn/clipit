<?php
$user_guid = elgg_get_logged_in_user_guid();
$clipit_user = array_pop(ClipitUser::get_by_id(array($user_guid)));
if ($clipit_user->role == ClipitUser::ROLE_ADMIN) {
    echo elgg_view('widgets/groupactivities_metric/edit_admin', $vars);
} else if ($clipit_user->role == ClipitUser::ROLE_TEACHER) {
    echo elgg_view('widgets/groupactivities_metric/edit_teacher', $vars);
} else if ($clipit_user->role == ClipitUser::ROLE_STUDENT) {
    echo elgg_view('widgets/groupactivities_metric/edit_student', $vars);
}