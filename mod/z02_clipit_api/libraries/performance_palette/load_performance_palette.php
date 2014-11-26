<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   2013-10-10
 * Last update:     $Date$
 * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, URJC JuxtaLearn Team
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 * @subpackage      clipit_api
 */
const FILE_NAME_EN = "performance_palette_en.xlsx";
const FILE_NAME_ES = "performance_palette_es.xlsx";
#const FILE_NAME_DE = "performance_palette_de.xlsx";
#const FILE_NAME_PT = "performance_palette_pt.xlsx";
const KEY_NAME = "performance_palette";

// Check if Performance Palette was already loaded.
if(get_config(KEY_NAME) === true) {
    return;
} else {
    set_config(KEY_NAME, true);
}

ClipitPerformanceItem::delete_all();

input_performance_palette_file(FILE_NAME_EN);
input_performance_palette_file(FILE_NAME_ES);
#input_performance_palette_file(FILE_NAME_DE);
#input_performance_palette_file(FILE_NAME_PT);

function process_data($file){

    $xlsx = new SimpleXLSX($file);

    $object_type = null;

    foreach($xlsx->rows() as $row){
        // Clean previous Performance Items
        // Add Performance Items
        $category = $category_description = "";
        foreach($json_object[KEY_NAME] as $category_array) {
            foreach($category_array as $key => $val) {
                switch($key) {
                    case "category":
                        $category = $val;
                        break;
                    case "category_description":
                        $category_description = $val;
                        break;
                    case "items":
                        foreach($val as $item) {
                            $prop_value_array = array();
                            $prop_value_array["category"] = $category;
                            $prop_value_array["category_description"] = $category_description;
                            foreach($item as $key_2 => $val_2) {
                                $prop_value_array[$key_2] = $val_2;
                            }
                            ClipitPerformanceItem::create($prop_value_array);
                        }
                        break;
                }
            }
        }
}






if($file_path = $_FILES["file"]){
    $html_title = "Processing Data";
    process_data($file_path["tmp_name"], $html_title, $html_body);
}else{
    $html_title = "Upload Setup File";
}

$html_body .=
    "<p/><form action='data_input' method='post' enctype='multipart/form-data'>
        <label for='file'>Filename:</label>
        <input type='file' name='file' id='file'><br>
        <input type='submit' name='submit' value='Submit'>
    </form>";

function process_data($file_path, &$html_title, &$html_body){

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
                $html_body .= "Adding <b>".$row[0]."</b> to ".$object_type."... ";
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
            $prop_value_array["deadline"] = $timestamp;
            // tricky topic
            $search_array = ClipitTrickyTopic::get_from_search((string) next($row), true, true);
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
            ClipitActivity::add_called_users((int)$prop_value_array["activity"], $user_array);
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
            if($parent_task = next($row)){
                $search_array = ClipitTask::get_from_search((string)$parent_task, true, true);
                if(!empty($search_array)){
                    $parent_task_id = (int)key($search_array);
                    $prop_value_array["parent_task"] = $parent_task_id;
                }
            }
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