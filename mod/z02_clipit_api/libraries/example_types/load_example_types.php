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

$key_name = "example_types";

// Check if Example Types were already loaded.
if(get_config($key_name) === true) {
    return;
} else{
    set_config($key_name, true);
}

$file_path = "z02_clipit_api/libraries/example_types/";
$file_name_de = "example_types_de.xlsx";
$file_name_en = "example_types_en.xlsx";
$file_name_es = "example_types_es.xlsx";
$file_name_pt = "example_types_pt.xlsx";
$file_name_sv = "example_types_sv.xlsx";

// Load Example Types for all languages
input_example_types_file(elgg_get_plugins_path() . $file_path . $file_name_en);
input_example_types_file(elgg_get_plugins_path() . $file_path . $file_name_es);
input_example_types_file(elgg_get_plugins_path() . $file_path . $file_name_de);
input_example_types_file(elgg_get_plugins_path() . $file_path . $file_name_pt);
input_example_types_file(elgg_get_plugins_path() . $file_path . $file_name_sv);

/**
 * Add Example Types from an Excel file
 *
 * @param string $file Local file path
 *
 * @return array|null Array of User IDs, or null if error.
 */
function input_example_types_file($file){
    $php_excel = PHPExcel_IOFactory::load($file);
    $row_iterator = $php_excel->getSheet()->getRowIterator();
    while ($row_iterator->valid()) {
        parse_example_types_row($row_iterator->current());
        $row_iterator->next();
    }
}

/**
 * Parse a single role from an Excel file, containing one example type item, and add it to ClipIt
 *
 * @param PHPExcel_Worksheet_Row $row_iterator
 *
 * @return int|false ID of User contained in row, or false in case of error.
 */
function parse_example_types_row($row_iterator) {
    $prop_value_array = array();
    $cell_iterator = $row_iterator->getCellIterator();

    //columns: reference	language	name	description category	category_description

    // reference column (equal across all languages)
    // Check for title or empty rows
    $value = $cell_iterator->current()->getValue();
    if (empty($value) || strtolower($value) == "reference") {
        return null;
    }
    $prop_value_array["reference"] = (string)$value;
    $cell_iterator->next();

    // language column
    $value = $cell_iterator->current()->getValue();
    $prop_value_array["language"] = (string)$value;
    $cell_iterator->next();

    // name column
    $value = $cell_iterator->current()->getValue();
    $prop_value_array["item_name"] = (string)$value;
    $cell_iterator->next();

    // description column
    $value = $cell_iterator->current()->getValue();
    $prop_value_array["item_description"] = (string)$value;
    $cell_iterator->next();

    // category column
    $value = $cell_iterator->current()->getValue();
    $prop_value_array["category"] = (string)$value;
    $cell_iterator->next();

    // category_description
    $value = $cell_iterator->current()->getValue();
    $prop_value_array["category_description"] = (string)$value;

    // Add Example Type Item to ClipIt
    ClipitExampleType::create($prop_value_array);
}