<?php
/**
 * Elgg XML output
 * This outputs the api as XML
 *
 * @package Elgg
 * @subpackage Core
 *
 */

$result = $vars['result'];
$export = $result->export();

/**
 * This presents the XML output for REST API calls inside a main <clipit_api> key.
 */
echo serialise_object_to_xml($export, "clipit_api");