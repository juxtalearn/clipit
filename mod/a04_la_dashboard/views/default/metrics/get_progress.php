<?php
$activity_id = get_input("id");
$group_id = get_input("gid");
$returnValue = LADashboardHelper::getProgressBundle($activity_id,$group_id);
echo json_encode($returnValue);
?>