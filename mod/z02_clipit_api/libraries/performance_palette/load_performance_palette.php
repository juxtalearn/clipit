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


/**
 * Add Performance Items from an Excel file
 *
 * @param string $file_path Local file path
 *
 * @return array|null Array of User IDs, or null if error.
 */
function input_performance_palette_file($file_path) {
    $php_excel = PHPExcel_IOFactory::load($file_path);
    $performance_item_array = array();
    $row_iterator = $php_excel->getSheet()->getRowIterator();
    while ($row_iterator->valid()) {
        parse_excel_row($row_iterator->current());
        $row_iterator->next();
    }
}

/**
 * Parse a single role from an Excel file, containing one performance palette item, and add it to ClipIt
 *
 * @param PHPExcel_Worksheet_Row $row_iterator
 *
 * @return int|false ID of User contained in row, or false in case of error.
 */
function parse_excel_row($row_iterator) {
    $prop_value_array = array();
    $cell_iterator = $row_iterator->getCellIterator();

    //columns: item_id	language	category	category_description	item_name	item_description	item_example

    // item_id column (equal across all languages)
    // Check for title or empty rows
    $value = $cell_iterator->current()->getValue();
    if (empty($value) || strtolower($value) == "item_id") {
        return null;
    }
    $prop_value_array["item_id"] = (string)$value;
    $cell_iterator->next();

    // language column
    $value = $cell_iterator->current()->getValue();
    $prop_value_array["language"] = (string)$value;
    $cell_iterator->next();

    // category column
    $value = $cell_iterator->current()->getValue();
    $prop_value_array["category"] = (string)$value;
    $cell_iterator->next();

    // category_description
    $value = $cell_iterator->current()->getValue();
    $prop_value_array["category_description"] = (string)$value;
    $cell_iterator->next();

    // item_name column
    $value = $cell_iterator->current()->getValue();
    $prop_value_array["name"] = (string)$value;
    $cell_iterator->next();

    // item_description column
    $value = $cell_iterator->current()->getValue();
    $prop_value_array["description"] = (string)$value;
    $cell_iterator->next();

    // item_example column
    $value = $cell_iterator->current()->getValue();
    $prop_value_array["example"] = (string)$value;

    // Add Performance Item to ClipIt
    ClipitPerformanceItem::create($prop_value_array);
}