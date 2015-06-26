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

// Fetch current options
$allow_registration = (bool)get_config("allow_registration");
$timezone = (string)get_config("timezone");
$clipit_tag_branch = (string)get_config("clipit_tag_branch");
$clipit_site_type = (string)get_config("clipit_site_type");
$clipit_global_url = (string)get_config("clipit_global_url");
$clipit_global_login = (string)get_config("clipit_global_login");
$clipit_global_password = (string)get_config("clipit_global_password");
$clipit_global_published = (bool)get_config("clipit_global_published");
$performance_palette = (bool)get_config("performance_palette");
$example_types = (bool)get_config("example_types");
$quiz_results_after_task_end = (bool)get_config("quiz_results_after_task_end");

echo "<p><strong>*** WARNING *** </strong> These options can break ClipIt, be careful!</p>";

// Table structure
echo "<table>";
// Main options form
echo "<form action='".elgg_get_site_url()."action/clipit_options/apply' method='post'>";
echo elgg_view('input/securitytoken');
echo "<tr height='40'>";
echo "<td>";
echo "<h3>General Options</h3>";
echo "</td>";
echo "</tr>";

echo "<tr height='40'>";
echo "<td width='300'>";
echo "<strong>ClipIt Tag Branch:</strong>";
echo "</td>";
echo "<td>";
echo "<input name='clipit_tag_branch' value=$clipit_tag_branch type='text' size='40'/>";
echo "</td>";
echo "</tr>";

echo "<tr height='40'>";
echo "<td width='300'>";
echo "<strong>Site time zone:</strong>";
echo "<br>(see <u><a href='http://www.php.net/manual/en/timezones.php' target='_blank'>PHP Time Zones</a></u>)";
echo "</td>";
echo "<td>";
echo "<input name='timezone' value=$timezone type='text' size='40'/>";
echo "</td>";
echo "</tr>";

echo "<tr height='40'>";
echo "<td>";
echo "<strong>Site type:</strong> ";
echo "</td>";
echo "<td>";
switch($clipit_site_type){
    case ClipitSite::TYPE_SITE:
        echo "<input name='clipit_site_type' value=".ClipitSite::TYPE_SITE." type='radio' checked> ".strtoupper(ClipitSite::TYPE_SITE)." ";
        echo "<input name='clipit_site_type' value=".ClipitSite::TYPE_GLOBAL." type='radio'> ".strtoupper(ClipitSite::TYPE_GLOBAL)." ";
        echo "<input name='clipit_site_type' value=".ClipitSite::TYPE_DEMO." type='radio'> ".strtoupper(ClipitSite::TYPE_DEMO)." ";
        break;
    case ClipitSite::TYPE_GLOBAL:
        echo "<input name='clipit_site_type' value=".ClipitSite::TYPE_SITE." type='radio'> ".strtoupper(ClipitSite::TYPE_SITE)." ";
        echo "<input name='clipit_site_type' value=".ClipitSite::TYPE_GLOBAL." type='radio' checked> ".strtoupper(ClipitSite::TYPE_GLOBAL)." ";
        echo "<input name='clipit_site_type' value=".ClipitSite::TYPE_DEMO." type='radio'> ".strtoupper(ClipitSite::TYPE_DEMO)." ";
        break;
    case ClipitSite::TYPE_DEMO:
        echo "<input name='clipit_site_type' value=".ClipitSite::TYPE_SITE." type='radio'> ".strtoupper(ClipitSite::TYPE_SITE)." ";
        echo "<input name='clipit_site_type' value=".ClipitSite::TYPE_GLOBAL." type='radio'> ".strtoupper(ClipitSite::TYPE_GLOBAL)." ";
        echo "<input name='clipit_site_type' value=".ClipitSite::TYPE_DEMO." type='radio' checked> ".strtoupper(ClipitSite::TYPE_DEMO)." ";
        break;
}
echo "</td>";
echo "</tr>";

echo "<tr height='40'>";
echo "<td>";
echo "<h3>Global site setup</h3>";
echo "</td>";
echo "</tr>";


echo "<tr height='40'>";
echo "<td>";
echo "<strong>Global site URL:</strong>";
echo "</td>";
echo "<td>";
echo "<input name='clipit_global_url' value=$clipit_global_url type='text' size='40'/>";
echo "</td>";
echo "</tr>";

echo "<tr height='40'>";
echo "<td>";
echo "<strong>Administrator login:</strong>";
echo "</td>";
echo "<td>";
echo "<input name='clipit_global_login' value=$clipit_global_login type='text' size='40'/><br>";
echo "</td>";
echo "</tr>";

echo "<tr height='40'>";
echo "<td>";
echo "<strong>Administrator password:</strong>";
echo "</td>";
echo "<td>";
echo "<input name='clipit_global_password' value=$clipit_global_password type='text' size='40'/>";
echo "</td>";
echo "</tr>";

echo "<tr height='40'>";
echo "<td>";
echo "<strong>Republish this site to global site?</strong> ";
echo "</td>";
echo "<td>";
echo "<input name='clipit_global_published' value='1' type='radio' checked> NO ";
echo "<input name='clipit_global_published' value='0' type='radio'> YES ";
echo "</td>";
echo "</tr>";

echo "<tr height='40'>";
echo "<td>";
echo "<h3>Authoring Tool Options</h3><br>";
echo "</td>";
echo "</tr>";

echo "<tr height='40'>";
echo "<td>";
echo "<strong>Reload problem example types palette?</strong> ";
echo "</td>";
echo "<td>";
echo "<input name='example_types' value='1' type='radio' checked> NO ";
echo "<input name='example_types' value='0' type='radio'> YES ";
echo "</td>";
echo "</tr>";

echo "<tr height='40'>";
echo "<td>";
echo "<h3>Activity Options</h3><br>";
echo "</td>";
echo "</tr>";

echo "<tr height='40'>";
echo "<td>";
echo "<strong>Allow students to register in ClipIt?</strong> ";
echo "</td>";
echo "<td>";
if($allow_registration){
    echo "<input name='allow_registration' value='0' type='radio'> NO ";
    echo "<input name='allow_registration' value='1' type='radio' checked> YES ";
} else{
    echo "<input name='allow_registration' value='0' type='radio' checked> NO ";
    echo "<input name='allow_registration' value='1' type='radio'> YES ";
}
echo "</td>";
echo "</tr>";

echo "<tr height='40'>";
echo "<td>";
echo "<strong>Wait until end of quiz tasks to show results?</strong> ";
echo "<br>(else show results to each student as they finish)";
echo "</td>";
echo "<td>";
if($quiz_results_after_task_end){
    echo "<input name='quiz_results_after_task_end' value='0' type='radio'> NO ";
    echo "<input name='quiz_results_after_task_end' value='1' type='radio' checked> YES ";
} else{
    echo "<input name='quiz_results_after_task_end' value='0' type='radio' checked> NO ";
    echo "<input name='quiz_results_after_task_end' value='1' type='radio'> YES ";
}
echo "</td>";
echo "</tr>";

echo "<tr height='40'>";
echo "<td>";
echo "<h3>Other Options</h3><br>";
echo "</td>";
echo "</tr>";

echo "<tr height='40'>";
echo "<td>";
echo "<strong>Clean malformed user accounts:</strong> ";
echo "<br>(removes accounts with no role)";
echo "</td>";
echo "<td>";
echo "<input name='clean_accounts' type='radio' value='no' checked> NO ";
echo "<input name='clean_accounts' type='radio' value='yes'> YES ";
echo "</td>";
echo "</tr>";

echo "<tr height='40'>";
echo "<td></td>";
echo "<td>";
echo "<input name='submit_options' type='submit' value='Apply'>";
echo "</td>";
echo "</tr>";

echo "</form>";

echo "</table>";
