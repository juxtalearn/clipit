<?php
$activity_id = get_input("id");
    $returnValue = LADashboardHelper::getQuizTasks($activity_id);
    echo json_encode($returnValue);
?>