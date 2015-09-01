<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   01/09/2015
 * Last update:     01/09/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entities = elgg_extract('entities', $vars);
$files = array();
$videos = array();
$videos = elgg_extract('videos', $vars);
$files = elgg_extract('files', $vars);
$href = elgg_extract('href', $vars);

$activity_get = get_input('activity');

function activity_total_found($activity_id, $videos, $files){
    $t_videos = array();
    $t_videos = get_visible_items_by_activity($activity_id, $videos, 'videos');
    $t_files = array();
    return count(array_merge($t_videos, $t_files));
}
foreach($entities as $entity){
    $visible_files = array();
    $visible_videos = array();
    $visible_videos = get_visible_items_by_activity($entity->id, $videos, 'videos');
    $visible_files = get_visible_items_by_activity($entity->id, $files, 'files');
    $total_items_found = count(array_merge($visible_videos, $visible_files));
    $selected = false;
    if($activity_get == $entity->id){
        $selected = true;
    }
    $icon = '
    <div class="image-block">
        <span class="activity-point" style="background: #'.$entity->color.'"></span>
    </div>';
    elgg_register_menu_item('explore:activities', array(
        'name' => 'explore_'.$entity->id,
        'text' => $icon.$entity->name,
        'title' => $entity->name,
        'class' => 'text-truncate',
        'href' => "explore{$href}activity={$entity->id}",
        'selected' => $selected,
        'badge' => $total_items_found > 0 ? $total_items_found : false,
    ));
}
echo elgg_view_menu('explore:activities', array(
    'sort_by' => 'register',
    'class' => 'scroll-list-300',
));

