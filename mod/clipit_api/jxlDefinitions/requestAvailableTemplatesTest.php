<?php
/**
 * User: malzahn
 * Date: 20.02.14
 * Time: 16:47
 */
define('ENDPOINT', "requestAvailableTemplates");
include_once('config.php');

# retrieve JSON-String
$jsonArrayString = file_get_contents($url);
# converst JSON-String to JSON data structure
$jsonArray = json_decode($jsonArrayString,true);

#output
if (empty($jsonArray)) {
    echo "No Templates found! Please ensure that you have saved some in the Workbench!";
} else { # if the array is not empty, every array item should contain all three of the variables below
    foreach ($jsonArray as $entry) {
        $templateId=$entry["TemplateId"]; //String
        $templateName=$entry["Name"]; //String
        $templateDescription=$entry["Description"]; //String
    }

echo $templateId . " " . $templateName . " " . $templateDescription;
}