<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, URJC Clipit Team
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 * @subpackage      clipit_admin
 */

echo "<h3>Import / Export options</h3><br>";

// EXPORT

echo "<form action='".elgg_get_site_url()."action/import_export/export' method='post'>";

echo elgg_view('input/securitytoken');

echo "<div style='margin-left:20px;text-indent:-10px'>";

echo "<p><strong>Export all object data to ZIP file:</strong><br>";
$site = ClipitSite::get_site();
$site_name = str_replace(" ", "_", sanitise_string($site->name));
$date_obj = new DateTime();
$date = date("Ymd");
echo "<input name='filename' value='$date-$site_name.zip' type='text' size='50'> ";
echo "<input type='submit' value='Export all'>";
echo "</p>";
echo "</div>";
echo "</form>";

// @todo IMPORT

//echo "<form action='".elgg_get_site_url()."action/import_export/import' method='post'>";
//
//echo elgg_view('input/securitytoken');
//
//echo "<div style='margin-left:20px;text-indent:-10px'>";
//
//echo "<p><strong>Import object data from file:</strong><br>";
//echo "<input name='import_path' value='/tmp/clipit_export/backup.xlsx' type='text' size='50'> ";
//echo "<input name='import_options' type='submit' value='Import from file'>";
//echo "</p>";
//echo "</div>";
//echo "</form>";

