<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   14/07/14
 * Last update:     14/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$entity = elgg_extract('entity', $vars);
$user_id = elgg_get_logged_in_user_guid();
$object = ClipitSite::lookup($entity->id);

$entity_class = $object['subtype'];
$activity_id = $entity_class::get_activity($entity->id);
$group_id = $entity_class::get_group($entity->id);

if(!in_array($group_id, ClipitUser::get_groups($user_id))){
    return false;
}
$clone_ids = array_flatten($entity_class::get_clone_tree($entity->id));

foreach($clone_ids as $clone_id){
    switch($entity_class::get_scope($clone_id)){
        case 'site':
            $outputs[] = array(
                'id' => $clone_id,
                'href' => "explore",
                'text' => elgg_echo('clipit:site'),
            );
            break;
        case 'task':
            $outputs[] = array(
                'id' => $clone_id,
                'href' => "clipit_activity/{$activity_id}/publications",
                'text' => elgg_echo('activity'),
            );
            break;
        case 'group':
            $outputs[] = array(
                'id' => $clone_id,
                'href' => "clipit_activity/{$activity_id}/group/{$group_id}/repository",
                'text' => elgg_echo('group'),
            );
            break;
    }
}
?>
<div class="dropdown inline-block">
    <button id="drop_scope" class="btn btn-primary btn-xs" data-toggle="dropdown" href="#"><?php echo elgg_echo('publications:view_scope');?> <span class="caret"></span></button>
    <ul id="menu1" class="dropdown-menu" role="menu" aria-labelledby="drop_scope">
        <?php foreach($outputs as $output):?>
            <li role="presentation">
                <?php echo elgg_view('output/url', array(
                    'href'  => $output['href']."/view/".$output['id'],
                    'text'  => $output['text'],
                    'role'    => 'menuitem',
                    'tabindex' => -1
                ));
                ?>
            </li>
        <?php endforeach;?>
    </ul>
</div>
