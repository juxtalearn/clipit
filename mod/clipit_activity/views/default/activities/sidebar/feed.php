<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$my_groups_id = elgg_extract("my_groups", $vars);
$events_log = ClipitEvent::get_by_object($my_groups_id, 0, 6);
?>
<h3>Last activity</h3>
<div class="events-list elgg-module module-events elgg-module-widget elgg-module-info">
    <div class="margin-bar"></div>
    <ul class="events">
    <?php foreach ($events_log as $event_log): ?>
        <?php echo clipit_event($event_log, 'timeline'); ?>
    <?php endforeach; ?>
    </ul>
</div>
