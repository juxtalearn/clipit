<?php
/**
 * Created by PhpStorm.
 * User: Pablo Llinás
 * Date: 28/05/2015
 * Time: 17:12
 */


echo "<h3>Import / Export options</h3><br>";

// EXPORT

echo "<form action='".elgg_get_site_url()."action/import_export/export' method='post'>";

echo elgg_view('input/securitytoken');

echo "<div style='margin-left:20px;text-indent:-10px'>";

echo "<p><strong>Export all object data to ZIP file:</strong><br>";
echo "<input name='filename' value='clipit_export.zip' type='text' size='50'> ";
echo "<input name='export_options' type='submit' value='Export all'>";
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

