<?php
$activity_id = get_input("id");
$type_id = get_input("type");
$returnValue = array();
switch($type_id) {
    case ClipitUser::SUBTYPE:
        $returnValue = LADashboardHelper::getUserBundle($activity_id);
        break;
    case ClipitGroup::SUBTYPE:
        $returnValue = LADashboardHelper::getGroupBundle($activity_id);
        break;
    default:
        $returnValue = LADashboardHelper::getGroupBundle(null);
}

echo json_encode($returnValue);
?>