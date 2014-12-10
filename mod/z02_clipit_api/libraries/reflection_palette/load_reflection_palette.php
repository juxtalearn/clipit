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
const FILE_NAME_EN = "reflection_palette_en.xlsx";
const FILE_NAME_ES = "reflection_palette_es.xlsx";
const FILE_NAME_DE = "reflection_palette_de.xlsx";
const FILE_NAME_PT = "reflection_palette_pt.xlsx";
const KEY_NAME = "reflection_palette";

// Check if Reflection Palette was already loaded.
if(get_config(KEY_NAME) === true) {
    return;
}
error_log("hola");
set_config(KEY_NAME, true); die;

// Load Reflection Palette for all languages
input_reflection_palette_file(elgg_get_plugins_path() . "z02_clipit_api/libraries/reflection_palette/".FILE_NAME_EN);
input_reflection_palette_file(elgg_get_plugins_path() . "z02_clipit_api/libraries/reflection_palette/".FILE_NAME_ES);
input_reflection_palette_file(elgg_get_plugins_path() . "z02_clipit_api/libraries/reflection_palette/".FILE_NAME_DE);
input_reflection_palette_file(elgg_get_plugins_path() . "z02_clipit_api/libraries/reflection_palette/".FILE_NAME_PT);

/**
 * Add Reflection Items from an Excel file
 *
 * @param string $file Local file path
 *
 * @return array|null Array of User IDs, or null if error.
 */
function input_reflection_palette_file($file){
    $php_excel = PHPExcel_IOFactory::load($file);
    $row_iterator = $php_excel->getSheet()->getRowIterator();
    while ($row_iterator->valid()) {
        parse_reflection_palette_row($row_iterator->current());
        $row_iterator->next();
    }
}

/**
 * Parse a single role from an Excel file, containing one reflection palette item, and add it to ClipIt
 *
 * @param PHPExcel_Worksheet_Row $row_iterator
 *
 * @return int|false ID of User contained in row, or false in case of error.
 */
function parse_reflection_palette_row($row_iterator) {
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

    // Add Performance Item to ClipIt
    ClipitReflectionItem::create($prop_value_array);
}