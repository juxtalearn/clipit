<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   03/11/2014
 * Last update:     03/11/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$id = elgg_extract('id', $vars);
$input_prefix = elgg_extract('input_prefix', $vars);
?>
<div class="show text-muted margin-bottom-10">
    <?php echo elgg_echo('quiz:question:answer:write');?>
</div>
<label for="<?php echo $input_prefix;?>[question][<?php echo $id;?>][number]"></label>
<hr class="margin-0 margin-bottom-20">
<input type="text"
       name="<?php echo $input_prefix;?>[question][<?php echo $id;?>][number]"
       value="<?php echo $vars['checked'];?>"
       data-rule-number="true"
       required="true"
       class="form-control">