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

echo "<h3>This will check-out the latest ClipIt stable version and apply all necessary updates</h3>";
echo "<br>";
echo "<h3>Current version: ".get_config("clipit_version")."</h3>";
$clipit_tag_branch = get_config("clipit_tag_branch");
if(!empty($clipit_tag_branch)){
    echo "<h4>ClipIt Tag Branch: $clipit_tag_branch</h4>";
}
echo "<br>";
echo "<form action='".elgg_get_site_url()."action/update_clipit' method='post'>";
echo elgg_view('input/securitytoken');
echo "Are you sure you want to proceed? <input name='update_clipit' value='Update' type='submit'>";
echo "</form>";
