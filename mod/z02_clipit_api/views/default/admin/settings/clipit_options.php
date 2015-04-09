<?php
session_start();

elgg_echo("<h2>admin:settings:clipit_settings</h2>");

// Save posted options
if(isset($_POST["submit_options"])) {
    set_config("allow_registration", (bool)$_POST["allow_registration"]);
    set_config("timezone", (string)$_POST["timezone"]);
    set_config("clipit_site_type", (string)$_POST["clipit_site_type"]);
    set_config("clipit_global_url", (string)$_POST["clipit_global_url"]);
    set_config("clipit_global_login", (string)$_POST["clipit_global_login"]);
    set_config("clipit_global_password", (string)$_POST["clipit_global_password"]);
    set_config("clipit_global_published", (bool)$_POST["clipit_global_published"]);
    set_config("performance_palette", (bool)$_POST["performance_palette"]);
    set_config("example_types", (bool)$_POST["example_types"]);
    set_config("fixed_performance_rating", (bool)$_POST["fixed_performance_rating"]);
}

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
echo "<form action='clipit_options' method='post'>";

echo "<h3>General Options</h3>";

echo "<p><h4>Site time zone (see <a href='http://www.php.net/manual/en/timezones.php' target='_blank'>PHP Time Zones</a>):</h4>";
echo "<input name='timezone' value=$timezone type='text' size='60'>";
echo "</p>";

echo "<p><h4>Site type:</h4>";
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

echo "<p><h4>Global site setup:</h4>";
echo "<input name='clipit_global_url' value=$clipit_global_url type='text' size='60'><br>";
echo "<input name='clipit_global_login' value=$clipit_global_login type='text' size='60'><br>";
echo "<input name='clipit_global_password' value=$clipit_global_password type='text' size='60'>";
echo "</p>";

echo "<p><h4>Republish this site to global site?</h4>";
echo "<input name='clipit_global_published' value='0' type='radio'> yes<br>";
echo "<input name='clipit_global_published' value='1' type='radio' checked> no";
echo "</p>";

echo "<h3>Authoring Tool Options</h3>";

echo "<p><h4>Reload performance palette?</h4>";
echo "<input name='performance_palette' value='0' type='radio'> yes<br>";
echo "<input name='performance_palette' value='1' type='radio' checked> no";
echo "</p>";

echo "<p><h4>Reload problem example palette?</h4>";
echo "<input name='example_types' value='0' type='radio'> yes<br>";
echo "<input name='example_types' value='1' type='radio' checked> no";
echo "</p>";

echo "<h3>Activity Options</h3>";

echo "<p><h4>Allow students to self-register?</h4>";
if($allow_registration){
    echo "<input name='allow_registration' value='1' type='radio' checked> yes<br>";
    echo "<input name='allow_registration' value='0' type='radio'> no";
} else{
    echo "<input name='allow_registration' value='1' type='radio'> yes<br>";
    echo "<input name='allow_registration' value='0' type='radio' checked> no";
}
echo "</p>";

echo "<p><h4>Teachers select performance items for feedback tasks?</h4>";
if($fixed_performance_rating) {
    echo "<input name='fixed_performance_rating' value='1' type='radio' checked> yes<br>";
    echo "<input name='fixed_performance_rating' value='0' type='radio'> no";
} else{
    echo "<input name='fixed_performance_rating' value='1' type='radio'> yes<br>";
    echo "<input name='fixed_performance_rating' value='0' type='radio' checked> no";
}
echo "</p>";

echo "<input name='submit_options' type='submit' value='Save'>";

echo "</form>";

