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
<div>
    <label>
        <input type="radio"
               name="<?php echo $input_prefix;?>[question][<?php echo $id;?>][true_false]"
                <?php echo $vars['checked'][0] ? 'checked' : '';?>
               value="true"/>
        <?php echo elgg_echo('true');?>
    </label>
    <label>
        <input type="radio"
               name="<?php echo $input_prefix;?>[question][<?php echo $id;?>][true_false]"
                <?php echo $vars['checked'][1] ? 'checked' : '';?>
               value="false"/>
        <?php echo elgg_echo('false');?>
    </label>
</div>