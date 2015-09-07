<?php
$activity_id = get_input("id");
$clipit_user_id = get_input("clipit_user");
$add_all=get_input("add_all");
if ( $clipit_user_id) {
     $clipit_user = array_pop(ClipitUser::get_by_id(array($clipit_user_id)));
} else {
    $clipit_user = null;
}

if ( $add_all ) {
    if ($add_all  === "false") {
        $add_all = false;
    } else {
        $add_all = true;
    }
} else {
    $add_all = true;
}
$returnValue = LADashboardHelper::getGroupBundle($activity_id,$add_all,$clipit_user);
echo json_encode($returnValue);
?>