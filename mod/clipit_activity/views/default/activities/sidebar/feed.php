<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   1/04/14
 * Last update:     1/04/14
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
$my_groups_id = elgg_extract("my_groups", $vars);
$events_log = ClipitEvent::get_by_object($my_groups_id, 0, 60);
?>
<h3>Last activity</h3>
<div style=" border-left: 10px solid #bae6f6; margin-left: -5px; ">
    <ul style=" padding-left: 10px; background: #fff; padding: 10px; margin-left: 10px; ">
    <?php foreach ($events_log as $event_log): ?>
        <?php echo clipit_event($event_log, 'summary'); ?>
    <?php endforeach; ?>
    </ul>
</div>