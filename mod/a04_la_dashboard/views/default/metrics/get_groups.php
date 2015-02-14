<?php
$activity_id = get_input("id");
$returnValue = LADashboardHelper::getGroupBundle($activity_id);
echo json_encode($returnValue);
?>