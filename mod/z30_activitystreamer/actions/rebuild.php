<?php
/**
 * Created by PhpStorm.
 * User: Daems
 * Date: 22.07.14
 * Time: 12:01
 */

admin_gatekeeper();
action_gatekeeper("rebuild");
include_once(elgg_get_plugins_path(). "z30_activitystreamer" . DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR . "logProcessing.php");

$affirmative = get_input('affirmative', 1);
if (isset($affirmative) && $affirmative) {
    global $CONFIG;
    $act_table = $_SESSION['activity_table'];
    $con=mysqli_connect($CONFIG->dbhost,$CONFIG->dbuser,$CONFIG->dbpass,$CONFIG->dbname);
    createActivityTable($con, $act_table);
    $stmt = $con->prepare("INSERT INTO `".$act_table."` ".
        "(transaction_id, json, actor_id, group_id, course_id, activity_id, verb, timestamp) ".
        "VALUES (?,?,?,?,?,?,?,?)");
    $log_table = $_SESSION['logging_table'];
    mysqli_query($con, "TRUNCATE ".$act_table.";");
    $result = mysqli_query($con, "SELECT * FROM ".$log_table." ORDER BY log_id;");
    $amount = $result->num_rows;
    $current_ID = "";
    $error_log = "";
    if ( $result ) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $new_ID = $row['transaction_id'];
            if ($current_ID == "") {
                $current_ID = $new_ID;
            }
            if ($current_ID != $new_ID) {
                $action = convertLogTransactionToActivityStream($transaction_artifacts);
                if (!($action['verb'] == 'Unidentified')) {
                    storeJSON($action, $act_table, $con, $stmt);
                }
                else {
                    error_log("\n\n".$current_ID.build_log_string($transaction_artifacts));
                }
                $transaction_artifacts = "";
                $current_ID = $new_ID;
            }
            $transaction_artifacts[] = array('ObjectId' => $row['object_id'], 'ObjectTitle' => $row['object_title'], 'ObjectType' => $row['object_type'], 'ObjectSubtype' => $row['object_subtype'], 'ObjectClass' => $row['object_class'], 'OwnerGUID' => $row['owner_guid'],
                'GroupId' => $row['group_id'], 'CourseId' => $row['course_id'], 'ActivityId' => $row['activity_id'], 'Event' => $row['event'], 'Content' => $row['content'],
                'Timestamp' => $row['time'], 'UserId'=> $row['user_id'], 'UserName'=> $row['user_name'], 'IPAddress' => $row['ip_address'], 'Role' => $row['role'], 'TransactionId' => $row['transaction_id']);

        }

        // If we fall out of the while loop above, the last transaction is usually not stored yet, this will be done here:
        if ($transaction_artifacts != "") {
            $action = convertLogTransactionToActivityStream($transaction_artifacts);
            if (!($action['verb'] == 'Unidentified')) {
                storeJSON($action, $act_table, $con, $stmt);
            }
            else {
                error_log("\n\n".$current_ID.build_log_string($transaction_artifacts));
            }
        }
    } else die(mysqli_error($con));
    $stmt->close();
    $con->close();

    system_message("<h1>Successfully rebuild ActivityStream from ".$amount." log entries.");

}

function build_log_string($transaction) {
    $log_string = "\n";
    foreach ($transaction as $key => $value) {
        foreach ($value as $key2 => $part) {
            $log_string = $log_string.$key2." => ".$part."\t";
        }
        $log_string = $log_string."\n";
    }
    return $log_string;
}