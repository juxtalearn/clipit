<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   26/10/2015
 * Last update:     26/10/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$entity = elgg_extract('entity', $vars);
echo elgg_view('input/hidden',array(
    'name' => 'entity-id',
    'value' => $entity->id
));
?>
<div class="margin-bottom-10 margin-top-5">
    <label>
        <input name="remote" value="0" type="radio" checked> <?php echo elgg_echo('send:to_site:input');?>
    </label>
    <label>
        <input name="remote" value="1" type="radio"> <?php echo elgg_echo('send:to_global:input');?>
    </label>
</div>
