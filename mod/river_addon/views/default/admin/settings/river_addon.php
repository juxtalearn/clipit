<?php
/**
 * River Addon tabs
 */

$tab = get_input('tab', 'settings');

echo "<div class=\"elggzone-options-panel\">";
	echo "<div class=\"elggzone-holder\">";

		echo elgg_view('navigation/tabs', array(
			'tabs' => array(
				array(
					'text' => elgg_echo('river_addon:tab:general'),
					'href' => '/admin/settings/river_addon?tab=general',
					'selected' => ($tab == 'general'),
				),
				array(
					'text' => elgg_echo('river_addon:tab:sidebar'),
					'href' => '/admin/settings/river_addon?tab=sidebar',
					'selected' => ($tab == 'sidebar'),
				),
				array(
					'text' => elgg_echo('river_addon:tab:announcement'),
					'href' => '/admin/settings/river_addon?tab=announcements',
					'selected' => ($tab == 'announcements'),
				)
			)
		));
		
		switch ($tab) {
			case 'announcements':
				echo elgg_view_form('river_addon/admin/announcements', array('class' => 'settings-optionspanel'));
				break;
			case 'sidebar':
				echo elgg_view_form('river_addon/admin/sidebar', array('class' => 'settings-optionspanel'));
				break;
			default:
			case 'general':
				echo elgg_view_form('river_addon/admin/general', array('class' => 'settings-optionspanel'));
				break;
		}

	echo "</div>";
echo "</div>";


