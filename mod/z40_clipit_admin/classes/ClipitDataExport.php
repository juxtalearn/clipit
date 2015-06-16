<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, URJC JuxtaLearn Team
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 * @subpackage      clipit_admin
 */


class ClipitDataExport{
    const EXPORT_PATH = "/tmp/clipit_export/";

    static function export_all($filename = ""){
        // remove possible temp files
        exec("rm -rf ".static::EXPORT_PATH);
        // create temp export path
        exec("mkdir -p ".static::EXPORT_PATH);
        // generate export files
        $file_array = array();
        $file_array[] = static::export_class_to_excel("ClipitActivity");
        $file_array[] = static::export_class_to_excel("ClipitChat");
        $file_array[] = static::export_class_to_excel("ClipitComment");
        $file_array[] = static::export_class_to_excel("ClipitExample");
        $file_array[] = static::export_class_to_excel("ClipitExampleType");
        $file_array[] = static::export_class_to_excel("ClipitFile");
        $file_array[] = static::export_class_to_excel("ClipitGroup");
        $file_array[] = static::export_class_to_excel("ClipitLabel");
        $file_array[] = static::export_class_to_excel("ClipitPerformanceItem");
        $file_array[] = static::export_class_to_excel("ClipitPerformanceRating");
        $file_array[] = static::export_class_to_excel("ClipitPost");
        $file_array[] = static::export_class_to_excel("ClipitQuiz");
        $file_array[] = static::export_class_to_excel("ClipitQuizQuestion");
        $file_array[] = static::export_class_to_excel("ClipitQuizResult");
        $file_array[] = static::export_class_to_excel("ClipitRating");
        $file_array[] = static::export_class_to_excel("ClipitRemoteResource");
        $file_array[] = static::export_class_to_excel("ClipitRemoteSite");
        $file_array[] = static::export_class_to_excel("ClipitSite");
        $file_array[] = static::export_class_to_excel("ClipitStoryboard");
        $file_array[] = static::export_class_to_excel("ClipitTag");
        $file_array[] = static::export_class_to_excel("ClipitTagRating");
        $file_array[] = static::export_class_to_excel("ClipitTask");
        $file_array[] = static::export_class_to_excel("ClipitTrickyTopic");
        $file_array[] = static::export_class_to_excel("ClipitUser");
        $file_array[] = static::export_class_to_excel("ClipitVideo");
        $file_array[] = static::export_relationships_to_excel();
        // make zip file of EXPORT_PATH
        if(empty($filename)){
            $date_obj = new DateTime();
            $filename = $date_obj->getTimestamp().".zip";
        } else{
            $filename = sanitize_string($filename);
        }
        $zip_file = "/tmp/".$filename;
        exec("zip -jr \"".$zip_file."\" ".static::EXPORT_PATH);
        // remove temp files
        exec("rm -rf ".static::EXPORT_PATH);
        return $zip_file;
    }

    static function export_relationships_to_excel(){
        global $CONFIG;

        // New Excel object
        $php_excel = new PHPExcel();
        // Set document properties
        $php_excel->getProperties()->setCreator("ClipIt")
            ->setTitle("ClipIt export of Relationships")
            ->setKeywords("clipit export relationships");

        // Add table title and columns
        $properties = array("id" => 0, "guid_one" => 0, "guid_two" => 0, "relationship" => "", "time_created" => 0);
        $active_sheet = $php_excel->setActiveSheetIndex(0);
        $active_sheet->getDefaultColumnDimension()->setWidth(40);
        $active_sheet->getStyle(1)->getFont()->setBold(true);
        $row = 1;
        $col = 0;
        foreach(array_keys($properties) as $prop_name){
            $active_sheet->setCellValueByColumnAndRow($col ++, $row, $prop_name." (".gettype($properties[$prop_name]).")");
        }
        // Write Items to spreadsheet
        $row = 2;
        $col = 0;
        $query = "select * from ".$CONFIG->dbprefix."entity_relationships;";
        $relationship_array = get_data($query);
        foreach($relationship_array as $relationship){
            foreach(array_keys($properties) as $prop_name){
                $active_sheet->setCellValueByColumnAndRow($col++, $row, $relationship->$prop_name);
            }
            $row++;
            $col = 0;
        }
        $objWriter = PHPExcel_IOFactory::createWriter($php_excel, 'Excel2007');
        $filename = (string)static::EXPORT_PATH."object_relationships.xlsx";
        $objWriter->save($filename);
        return $filename;
    }
    
    static function export_class_to_excel($class_name) {
        // New Excel object
        $php_excel = new PHPExcel();
        // Set document properties
        $php_excel->getProperties()->setCreator("ClipIt")
            ->setTitle("ClipIt export of " . $class_name)
            ->setKeywords("clipit export class");
        // Add table title and columns
        $active_sheet = $php_excel->setActiveSheetIndex(0);
        $active_sheet->getDefaultColumnDimension()->setWidth(40);
        $active_sheet->getStyle(1)->getFont()->setBold(true);
        $row = 1;
        $col = 0;
        $properties = $class_name::list_properties();
        foreach(array_keys($properties) as $prop_name) {
            $active_sheet->setCellValueByColumnAndRow($col ++, $row, $prop_name." (".gettype($properties[$prop_name]).")");
        }
        // Load Items
        $item_array = $class_name::get_all();
        // Write Items to spreadsheet
        $row = 2;
        $col = 0;
        foreach($item_array as $item) {
            foreach(array_keys($properties) as $prop_name){
                if(is_array($item->$prop_name)){
                    $serialized_value = implode(";",$item->$prop_name);
                    $active_sheet->setCellValueByColumnAndRow($col++, $row, $serialized_value);
                } else {
                    $active_sheet->setCellValueByColumnAndRow($col++, $row, $item->$prop_name);
                }
            }
            $row++;
            $col = 0;
        }
        // Write Excel file
        $objWriter = PHPExcel_IOFactory::createWriter($php_excel, 'Excel2007');
        $filename = (string)static::EXPORT_PATH.$class_name.".xlsx";
        $objWriter->save($filename);
        return $filename;
    }

//    /**
//     * Add Users from an Excel file, and return an array of User Ids from those created or selected from the file.
//     *
//     * @param string $file_path Local file path
//     *
//     * @return array|null Array of User IDs, or null if error.
//     */
//    static function import_data($file_path) {
//        $php_excel = PHPExcel_IOFactory::load($file_path);
//        $user_array = array();
//        $row_iterator = $php_excel->getSheet()->getRowIterator();
//        while($row_iterator->valid()) {
//            $row_result = static::parse_excel_row($row_iterator->current());
//            if(!empty($row_result)) {
//                $user_array[] = (int)$row_result;
//            }
//            $row_iterator->next();
//        }
//        return $user_array;
//    }
//
//    /**
//     * Parse a single role from an Excel file, containing one user, and add it to ClipIt if new
//     *
//     * @param PHPExcel_Worksheet_Row $row_iterator
//     *
//     * @return int|false ID of User contained in row, or false in case of error.
//     */
//    private function parse_excel_row($row_iterator) {
//        $prop_value_array = array();
//        $cell_iterator = $row_iterator->getCellIterator();
//        // Check for non-user row
//        $value = $cell_iterator->current()->getValue();
//        if(empty($value) || strtolower($value) == "users" || strtolower($value) == "name") {
//            return null;
//        }
//        // name
//        $name = $value;
//        $prop_value_array["name"] = (string)$name;
//        $cell_iterator->next();
//        // login
//        $login = (string)$cell_iterator->current()->getValue();
//        if(!empty($login)) {
//            $user_array = static::get_by_login(array($login));
//            if(!empty($user_array[$login])) { // user already exists, no need to create it
//                return (int)$user_array[$login]->id;
//            }
//            $prop_value_array["login"] = $login;
//        } else {
//            return null;
//        }
//        $cell_iterator->next();
//        // password
//        $password = (string)$cell_iterator->current()->getValue();
//        if(!empty($password)) {
//            $prop_value_array["password"] = $password;
//        } else {
//            return null;
//        }
//        $cell_iterator->next();
//        // email
//        $email = (string)$cell_iterator->current()->getValue();
//        if(!empty($email)) {
//            $prop_value_array["email"] = $email;
//        }
//        $cell_iterator->next();
//        // role
//        $role = (string)$cell_iterator->current()->getValue();
//        if(!empty($role)) {
//            $prop_value_array["role"] = $role;
//        }
//        return static::create($prop_value_array);
//    }
}


