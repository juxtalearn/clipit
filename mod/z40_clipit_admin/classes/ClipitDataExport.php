<?php

/**
 * Created by PhpStorm.
 * User: Pablo Llinás
 * Date: 28/05/2015
 * Time: 13:24
 */


class ClipitDataExport{
    const EXPORT_PATH = "/tmp/clipit_export/";

    static function export_all($filename = ""){
        if(empty($filename)){
            $date_obj = new DateTime();
            $filename = $date_obj->getTimestamp();
        }
        exec("mkdir -p ".static::EXPORT_PATH);
        $file_array = array();
        $file_array[] = static::export_class_data("ClipitActivity");
        $file_array[] = static::export_class_data("ClipitChat");
        $file_array[] = static::export_class_data("ClipitComment");
        $file_array[] = static::export_class_data("ClipitExample");
        $file_array[] = static::export_class_data("ClipitExampleType");
        $file_array[] = static::export_class_data("ClipitFile");
        $file_array[] = static::export_class_data("ClipitGroup");
        $file_array[] = static::export_class_data("ClipitLabel");
        $file_array[] = static::export_class_data("ClipitPerformanceItem");
        $file_array[] = static::export_class_data("ClipitPerformanceRating");
        $file_array[] = static::export_class_data("ClipitPost");
        $file_array[] = static::export_class_data("ClipitQuiz");
        $file_array[] = static::export_class_data("ClipitQuizQuestion");
        $file_array[] = static::export_class_data("ClipitQuizResult");
        $file_array[] = static::export_class_data("ClipitRating");
        $file_array[] = static::export_class_data("ClipitRemoteResource");
        $file_array[] = static::export_class_data("ClipitRemoteSite");
        $file_array[] = static::export_class_data("ClipitSite");
        $file_array[] = static::export_class_data("ClipitStoryboard");
        $file_array[] = static::export_class_data("ClipitTag");
        $file_array[] = static::export_class_data("ClipitTagRating");
        $file_array[] = static::export_class_data("ClipitTask");
        $file_array[] = static::export_class_data("ClipitTrickyTopic");
        $file_array[] = static::export_class_data("ClipitUser");
        $file_array[] = static::export_class_data("ClipitVideo");
        $exec_cmd = "zip -jr /tmp/".$filename." ".static::EXPORT_PATH;
        exec($exec_cmd);
        return true;
    }
    
    static function export_class_data($class_name, $format = "excel") {
        // New Excel object
        $php_excel = new PHPExcel();
        // Set document properties
        $php_excel->getProperties()->setCreator("ClipIt")
            ->setTitle("ClipIt export of " . get_called_class())
            ->setKeywords("clipit export");
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
        switch($format) {
            case "excel":
                $objWriter = PHPExcel_IOFactory::createWriter($php_excel, 'Excel2007');
                $filename = (string)static::EXPORT_PATH.$class_name.".xlsx";
                $objWriter->save($filename);
                return $filename;
        }
        return null;
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


