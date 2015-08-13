<?php
$activity_id = get_input("id");
$type_id = get_input("type");
$add_all = get_input("addAll",1);

$returnValue = array();
switch($type_id) {
    case ClipitUser::SUBTYPE:
        $returnValue = LADashboardHelper::getUserBundle($activity_id);
        break;
    case ClipitGroup::SUBTYPE:
        $returnValue = LADashboardHelper::getGroupBundle($activity_id,$add_all);
        break;
    default:
        $returnValue = LADashboardHelper::getGroupBundle(null);
}

echo json_encode($returnValue);
?>