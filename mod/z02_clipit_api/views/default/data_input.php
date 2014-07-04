<?php
/**
 * Created by PhpStorm.
 * User: pebs74
 * Date: 12/06/2014
 * Time: 14:52
 */

const TRICKY_TOPIC = "Tricky Topics";
const ACTIVITY = "Activities";
const USER = "Users";
const GROUP = "Groups";
const TASK = "Tasks";
const TITLE_ROW = "NAME";
const EMPTY_FIELD = "";

$html_title = "";
$html_body = "";

if($file_path = $_FILES["file"]){
    process_data($file_path["tmp_name"], $html_title, $html_body);
}else{
    $html_title = "Upload Excel File";
    $html_body .=
        "<form action='data_input' method='post' enctype='multipart/form-data'>
            <label for='file'>Filename:</label>
            <input type='file' name='file' id='file'><br>
            <input type='submit' name='submit' value='Submit'>
        </form>";
}

function process_data($file_path, &$html_title, &$html_body){

    $html_title = "Processing Data";

    $xlsx = new SimpleXLSX($file_path);

    $object_type = null;

    foreach($xlsx->rows() as $row){
        switch((string)$row[0]){
            case TRICKY_TOPIC:
                $object_type = TRICKY_TOPIC;
                $html_body .= "<h4>".$object_type."</h4>";
                break;
            case ACTIVITY:
                $object_type = ACTIVITY;
                $html_body .= "<h4>".$object_type."</h4>";
                break;
            case USER:
                $object_type = USER;
                $html_body .= "<h4>".$object_type."</h4>";
                break;
            case GROUP:
                $object_type = GROUP;
                $html_body .= "<h4>".$object_type."</h4>";
                break;
            case TASK:
                $object_type = TASK;
                $html_body .= "<h4>".$object_type."</h4>";
                break;
            case TITLE_ROW:
                break;
            case  EMPTY_FIELD:
                break;
            default:
                $html_body .= "Adding ".$row[0]." to ".$object_type."... ";
                if(!input_row($object_type, $row, $xlsx)){
                    $html_body .= "ERROR:<br>".json_encode($row)."<br>";
                } else{
                    $html_body .= "OK!<br>";
                }
                break;
        }
    }
}

/**
 * @param string $object_type
 * @param array $row
 * @param SimpleXLSX $xlsx
 * @return int|false ID of new object created, or false in case of error.
 */
function input_row($object_type, $row, $xlsx){
    $prop_value_array = array();
    // name (common to all object types)
    $prop_value_array["name"] = (string) reset($row);
    switch($object_type) {
        case TRICKY_TOPIC:
            // tag array
            $tag_array = array();
            while($value = next($row)){
                $search_array = ClipitTag::get_from_search((string) $value, true, true);
                if(!empty($search_array)){
                    $tag_array[] = (int) key($search_array);
                }else {
                    $tag_array[] = ClipitTag::create(array("name" => (string) $value));
                }
            }
            $prop_value_array["tag_array"] = $tag_array;
            return ClipitTrickyTopic::create($prop_value_array);
            break;
        case ACTIVITY:
            // description
            $prop_value_array["description"] = (string) next($row);
            // deadline
            $timestamp = (int) $xlsx->unixstamp((string) next($row));
            $prop_value_array["end"] = $timestamp;
            // tricky topic
            var_dump($search_array = ClipitTrickyTopic::get_from_search((string) next($row), true, true));
            if(!empty($search_array)) {
                $prop_value_array["tricky_topic"] = (int) key($search_array);
            } else{
                return false;
            }
            // teacher array
            $teacher_array = array();
            while($value = next($row)){
                $search_array = ClipitUser::get_by_login(array((string) $value));
                if(!empty($search_array)){
                    $teacher_array[] = (int) $search_array[$value]->id;
                } else{
                    return false;
                }
            }
            $prop_value_array["teacher_array"] = $teacher_array;
            // status
            $prop_value_array["status"] = ClipitActivity::STATUS_ACTIVE;
            // @todo: COLOR
            return ClipitActivity::create($prop_value_array);
            break;
        case USER:
            // login
            $prop_value_array["login"] = (string) next($row);
            // password
            $prop_value_array["password"] = (string) next($row);
            // email
            $prop_value_array["email"] = (string) next($row);
            // role
            $prop_value_array["role"] = (string) next($row);
            return ClipitUser::create($prop_value_array);
            break;
        case GROUP:
            // activity
            $search_array = ClipitActivity::get_from_search((string) next($row), true, true);
            if(!empty($search_array)) {
                $prop_value_array["activity"] = (int) key($search_array);
            } else{
                return false;
            }
            // users
            $user_array = array();
            while($value = next($row)){
                $search_array = ClipitUser::get_by_login(array((string)$value));
                if(!empty($search_array)){
                    $user_array[] = (int) $search_array[$value]->id;
                } else{
                    return false;
                }
            }
            $prop_value_array["user_array"] = $user_array;
            return ClipitGroup::create($prop_value_array);
            break;
        case TASK:
            // description
            $prop_value_array["description"] = (string) next($row);
            // type
            $prop_value_array["task_type"] = (string) next($row);
            // activity
            $search_array = ClipitActivity::get_from_search((string) next($row), true, true);
            if(!empty($search_array)) {
                $prop_value_array["activity"] = (int) key($search_array);
            } else{
                return false;
            }
            // start date
            $date = new DateTime();
            $timestamp = (int) $xlsx->unixstamp((string) next($row));
            $prop_value_array["start"] = $timestamp;
            // end date
            $timestamp = (int) $xlsx->unixstamp((string) next($row));
            $prop_value_array["end"] = $timestamp;
            return ClipitTask::create($prop_value_array);
            break;
    }
}

?>

<html>
<body>
<H3><?echo $html_title?></H3>
<?echo $html_body?>
</body>
</html>