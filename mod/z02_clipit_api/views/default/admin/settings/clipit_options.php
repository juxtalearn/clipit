<?php

// Fetch current options
$allow_registration = (bool)get_config("allow_registration");
$timezone = (string)get_config("timezone");
$clipit_site_type = (string)get_config("clipit_site_type");
$clipit_global_url = (string)get_config("clipit_global_url");
$clipit_global_login = (string)get_config("clipit_global_login");
$clipit_global_password = (string)get_config("clipit_global_password");
$clipit_global_published = (bool)get_config("clipit_global_published");
$performance_palette = (bool)get_config("performance_palette");
$example_types = (bool)get_config("example_types");
$fixed_performance_rating = (bool)get_config("fixed_performance_rating");

// Main options form
echo "<form action='".elgg_get_site_url()."action/clipit_options/save' method='post'>";

echo elgg_view('input/securitytoken');

echo "<h3>General Options</h3><br>";

echo "<div style='margin-left:20px;text-indent:-10px'>";

echo "<p><strong>Site time zone (see <a href='http://www.php.net/manual/en/timezones.php' target='_blank'>PHP Time Zones</a>)</strong><br>";
echo "<input name='timezone' value=$timezone type='text' size='60'>";
echo "</p>";

echo "<p><strong>Site type</strong><br>";
switch($clipit_site_type){
    case ClipitSite::TYPE_SITE:
        echo "<input name='clipit_site_type' value=".ClipitSite::TYPE_SITE." type='radio' checked>".ClipitSite::TYPE_SITE."<br>";
        echo "<input name='clipit_site_type' value=".ClipitSite::TYPE_GLOBAL." type='radio'>".ClipitSite::TYPE_GLOBAL."<br>";
        echo "<input name='clipit_site_type' value=".ClipitSite::TYPE_DEMO." type='radio'>".ClipitSite::TYPE_DEMO;
        break;
    case ClipitSite::TYPE_GLOBAL:
        echo "<input name='clipit_site_type' value=".ClipitSite::TYPE_SITE." type='radio'>".ClipitSite::TYPE_SITE."<br>";
        echo "<input name='clipit_site_type' value=".ClipitSite::TYPE_GLOBAL." type='radio' checked>".ClipitSite::TYPE_GLOBAL."<br>";
        echo "<input name='clipit_site_type' value=".ClipitSite::TYPE_DEMO." type='radio'>".ClipitSite::TYPE_DEMO;
        break;
    case ClipitSite::TYPE_DEMO:
        echo "<input name='clipit_site_type' value=".ClipitSite::TYPE_SITE." type='radio'>".ClipitSite::TYPE_SITE."<br>";
        echo "<input name='clipit_site_type' value=".ClipitSite::TYPE_GLOBAL." type='radio'>".ClipitSite::TYPE_GLOBAL."<br>";
        echo "<input name='clipit_site_type' value=".ClipitSite::TYPE_DEMO." type='radio' checked>".ClipitSite::TYPE_DEMO;
        break;
}
echo "</p>";

echo "<p><strong>Global site setup</strong><br>";
echo "URL:<br><input name='clipit_global_url' value=$clipit_global_url type='text' size='60'><br>";
echo "Login:<br><input name='clipit_global_login' value=$clipit_global_login type='text' size='60'><br>";
echo "Password:<br><input name='clipit_global_password' value=$clipit_global_password type='text' size='60'>";
echo "</p>";

echo "<p><strong>Republish this site to global site?</strong><br>";
echo "<input name='clipit_global_published' value='0' type='radio'> yes<br>";
echo "<input name='clipit_global_published' value='1' type='radio' checked> no";
echo "</p>";

echo "</div>";

echo "<h3>Authoring Tool Options</h3><br>";

echo "<div style='margin-left:20px;text-indent:-10px'>";

echo "<p><strong>Reload performance items palette?</strong><br>";
echo "<input name='performance_palette' value='0' type='radio'> yes<br>";
echo "<input name='performance_palette' value='1' type='radio' checked> no";
echo "</p>";

echo "<p><strong>Reload problem example types palette?</strong><br>";
echo "<input name='example_types' value='0' type='radio'> yes<br>";
echo "<input name='example_types' value='1' type='radio' checked> no";
echo "</p>";

echo "</div>";

echo "<h3>Activity Options</h3><br>";

echo "<div style='margin-left:20px;text-indent:-10px'>";

echo "<p><strong>Allow students to create an account in ClipIt?</strong><br>";
if($allow_registration){
    echo "<input name='allow_registration' value='1' type='radio' checked> yes<br>";
    echo "<input name='allow_registration' value='0' type='radio'> no";
} else{
    echo "<input name='allow_registration' value='1' type='radio'> yes<br>";
    echo "<input name='allow_registration' value='0' type='radio' checked> no";
}
echo "</p>";

echo "<p><strong>Teachers select performance items for feedback tasks?</strong><br>";
if($fixed_performance_rating) {
    echo "<input name='fixed_performance_rating' value='1' type='radio' checked> yes<br>";
    echo "<input name='fixed_performance_rating' value='0' type='radio'> no";
} else{
    echo "<input name='fixed_performance_rating' value='1' type='radio'> yes<br>";
    echo "<input name='fixed_performance_rating' value='0' type='radio' checked> no";
}
echo "</p>";

echo "</div>";

echo "<input name='submit_options' type='submit' value='Save'>";

echo "</form>";

