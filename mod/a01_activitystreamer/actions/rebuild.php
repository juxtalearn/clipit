<?php
/**
 * Created by PhpStorm.
 * User: Daems
 * Date: 22.07.14
 * Time: 12:01
 */

admin_gatekeeper();
action_gatekeeper("rebuild");
include_once(elgg_get_plugins_path(). "a01_activitystreamer" . DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR . "logProcessing.php");
$_SESSION['transaction'] = "";
$affirmative = get_input('affirmative', 1);
$_SESSION['activity_table'] = $CONFIG->dbprefix."activitystreams";
if (isset($affirmative) && $affirmative) {
    global $CONFIG;
    global $con;
    global $transaction_stmt;
    $act_table = $_SESSION['activity_table'];
    createActivityTable($con, $act_table);
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
                $action = convertLogTransactionToActivityStream($_SESSION['transaction']);
                if (!($action['verb'] == 'Unidentified') && !($action['verb'] == 'Ignore') && !($action['verb'] == 'Multiple')) {
                    storeJSON($action, $act_table, $con, $transaction_stmt);
                    //error_log("\n\n".$current_ID.": ".$action['verb'].build_log_string());
                }
                else {
                    //error_log($current_ID.": ".$action['verb'].build_log_string());
                }
                $_SESSION['transaction'] = "";
                $current_ID = $new_ID;
            }
            $_SESSION['transaction'][] = array('ObjectId' => $row['object_id'], 'ObjectTitle' => $row['object_title'], 'ObjectType' => $row['object_type'], 'ObjectSubtype' => $row['object_subtype'], 'ObjectClass' => $row['object_class'], 'OwnerGUID' => $row['owner_guid'],
                'GroupId' => $row['group_id'], 'CourseId' => $row['course_id'], 'ActivityId' => $row['activity_id'], 'Event' => $row['event'], 'Content' => $row['content'],
                'Timestamp' => $row['time'], 'UserId'=> $row['user_id'], 'UserName'=> $row['user_name'], 'IPAddress' => $row['ip_address'], 'Role' => $row['role'], 'TransactionId' => $row['transaction_id']);
        }

        // If we fall out of the while loop above, the last transaction is usually not stored yet, this will be done here:
        if ($_SESSION['transaction'] != "") {
            $action = convertLogTransactionToActivityStream($_SESSION['transaction']);
            if (!($action['verb'] == 'Unidentified')) {
                storeJSON($action, $act_table, $con, $transaction_stmt);
                error_log("\n\n".$current_ID.": ".$action['verb'].build_log_string());
            }
            else {
                error_log("\n\n".$current_ID.": ".$action['verb'].build_log_string());
            }
        }
    } else die(mysqli_error($con));
    $transaction_stmt->close();
    system_message("<h1>Successfully rebuild ActivityStream from ".$amount." log entries.");

}

function build_log_string() {
    $log_string = "\n";
    foreach ($_SESSION['transaction'] as $key => $value) {
        foreach ($value as $key2 => $part) {
            $log_string = $log_string.$key2." => ".$part."\t";
        }
        $log_string = $log_string."\n";
    }
    return $log_string;
}