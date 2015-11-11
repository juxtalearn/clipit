<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   24/07/2015
 * Last update:     24/07/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$entities = elgg_extract('entities', $vars);
$href = elgg_extract('href', $vars);
foreach($entities as $entity){
    elgg_register_menu_item('filter:sites', array(
        'name' => 'filter_'.$entity->id,
        'text' => $icon.$entity->name,
        'title' => $entity->name,
        'class' => 'text-truncate',
        'href' => "public_activities{$href}site={$entity->id}",
        'selected' => get_input('site') == $entity->id ? true : false,
    ));
}
echo elgg_view_menu('filter:sites', array(
    'sort_by' => 'register',
    'class' => 'scroll-list-300',
));

