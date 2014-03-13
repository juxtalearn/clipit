<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   10/03/14
 * Last update:     10/03/14
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

$tabs = array(
    'all' => array(
        'text' => elgg_echo('messages:all'),
        'href' => 'messages/inbox?filter=all',
        'priority' => 200,
    ),
    'private_msg' => array(
        'text' => elgg_echo('messages:private_msg'),
        'href' => 'messages/inbox?filter=private_msg',
        'priority' => 300,
    ),
    'my_activities' => array(
        'text' => elgg_echo('messages:my_activities'),
        'href' => 'messages/inbox?filter=my_activities',
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

echo elgg_view_menu('filter', array('sort_by' => 'priority', 'class' => 'nav nav-tabs elgg-menu-hz'));
