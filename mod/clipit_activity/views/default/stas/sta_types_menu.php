<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   24/03/14
 * Last update:     24/03/14
 *
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, JuxtaLearn Project
 * @version         $Version$
 * @link            http://juxtalearn.org
 * @license         GNU Affero General Public License v3
 *                  (http://www.gnu.org/licenses/agpl-3.0.txt)
 *                  This program is free software: you can redistribute it and/or modify
 *                  it under the terms of the GNU Affero General Public License as
 *                  published by the Free Software Foundation, version 3.
 *                  This program is distributed in the hope that it will be useful,
 *                  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *                  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *                  GNU Affero General Public License for more details.
 *                  You should have received a copy of the GNU Affero General Public License
 *                  along with this program. If not, see
 *                  http://www.gnu.org/licenses/agpl-3.0.txt.
 */
$activity = elgg_extract('entity', $vars);

$tabs = array(
    'files' => array(
        'text' => elgg_echo('sta:files').' (n)',
        'href' => "clipit_activity/{$activity->id}/stas?filter=files",
        'priority' => 200,
    ),
    'videos' => array(
        'text' => elgg_echo('sta:videos').' (n)',
        'href' => "clipit_activity/{$activity->id}/stas?filter=videos",
        'priority' => 300,
    ),
    'links' => array(
        'text' => elgg_echo('sta:links').' (n)',
        'href' => "clipit_activity/{$activity->id}/stas?filter=links",
        'priority' => 400,
    ),
);

foreach ($tabs as $name => $tab) {
    $tab['name'] = $name;

    if ($vars['selected'] == $name) {
        $tab['selected'] = true;
    }

    elgg_register_menu_item('filter', $tab);
}

echo elgg_view_menu('filter', array('sort_by' => 'priority', 'class' => 'menu-activity-section nav nav-tabs'));
