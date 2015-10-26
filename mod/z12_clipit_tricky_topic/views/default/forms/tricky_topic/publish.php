<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   26/10/2015
 * Last update:     26/10/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity = elgg_extract('entity', $vars);
echo elgg_view('input/hidden',array(
    'name' => 'entity-id',
    'value' => $entity->id
));
?>
<div class="margin-bottom-10 margin-top-5">
    <label><?php echo elgg_echo('send:to_global:question');?></label>
    <label style="font-weight: normal;" class="inline-block margin-right-10">
        <input name="remote" value="1" type="radio" checked> <?php echo elgg_echo('option:yes');?>
    </label>
    <label style="font-weight: normal;" class="inline-block">
        <input name="remote" value="0" type="radio"> <?php echo elgg_echo('option:no');?>
    </label>
</div>
