<?php

/**
 * User settings
 */

$user = elgg_get_logged_in_user_entity();
$user_guid = $user->getGUID();

$show_groups = elgg_get_plugin_setting('show_groups', 'river_addon');
$group_count = elgg_get_plugin_user_setting('group_count', $user_guid, 'river_addon');

if ($show_groups == 'no'){
	echo '<div>';
	echo "<div class=\"attention\">" . elgg_echo('river_addon:info:notenabled') . "</div>";
	echo '</div>';
}

echo elgg_echo('river_addon:label:groupcount');

?>

<select name="params[group_count]">
	<option value="2" <?php if ($group_count == 2) echo " selected=\"yes\" "; ?>>2</option>
	<option value="4" <?php if ($group_count == 4) echo " selected=\"yes\" "; ?>>4</option>
	<option value="6" <?php if ($group_count == 6) echo " selected=\"yes\" "; ?>>6</option>
	<option value="8" <?php if ($group_count == 8) echo " selected=\"yes\" "; ?>>8</option>
</select>

