<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   28/07/14
 * Last update:     28/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$entity = elgg_extract('entity', $vars);
?>
<?php echo elgg_view("input/hidden",
    array(
        'name' => 'entity-id',
        'value' => $entity->id,
    ));
?>
<?php echo elgg_view('input/submit',
    array(
        'value' => elgg_echo('discussion:start'),
        'class' => "btn btn-primary btn-xs pull-right"
    ));
?>