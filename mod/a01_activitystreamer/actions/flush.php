<?php
/**
 * Created by PhpStorm.
 * User: Daems
 * Date: 22.07.14
 * Time: 12:01
 */

admin_gatekeeper();
action_gatekeeper("request");
global $CONFIG;
global $con;
$time = time();
$sql = "DELETE FROM ".$_SESSION['analysis_table']." WHERE timestamp < ".$time.";";
$flush_stmt = $con->prepare($sql);
if ($flush_stmt->execute()) {
    system_message("Flushed the Workbench results!");
}
else {
    error_log($sql);
    error_log(mysqli_error($con));
    system_message("Error flushing the Workbench results!");
}