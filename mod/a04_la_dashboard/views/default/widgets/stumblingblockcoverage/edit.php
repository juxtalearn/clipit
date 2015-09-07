<?php
$user_guid = elgg_get_logged_in_user_guid();
$clipit_user = array_pop(ClipitUser::get_by_id(array($user_guid)));

if ($clipit_user->role == ClipitUser::ROLE_ADMIN) {
    echo elgg_view('widgets/stumblingblockcoverage/edit_admin', array_merge($vars,array('clipit_user' => $clipit_user)));
} else if ($clipit_user->role == ClipitUser::ROLE_TEACHER) {
    echo elgg_view('widgets/stumblingblockcoverage/edit_teacher', array_merge($vars,array('clipit_user' => $clipit_user)));
} else if ($clipit_user->role == ClipitUser::ROLE_STUDENT) {
    echo elgg_view('widgets/stumblingblockcoverage/edit_student', array_merge($vars,array('clipit_user' => $clipit_user)));
}