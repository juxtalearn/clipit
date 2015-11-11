<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$user = elgg_extract('entity', $vars);
$group = elgg_extract('group', $vars);
echo elgg_view("input/hidden", array(
    'name' => 'user-id',
    'value' => $user->id,
));
echo elgg_view("input/hidden", array(
    'name' => 'group-id',
    'value' => $group->id,
));

echo '<button class="pull-right btn btn-xs btn-danger" title="'.elgg_echo("group:member:remove").'"><i class="fa fa-times"></i></button>'
?>
