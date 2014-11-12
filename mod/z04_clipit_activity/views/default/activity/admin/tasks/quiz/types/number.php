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
?>
<div class="show text-muted margin-bottom-10">
    Write the correct answer
</div>
<hr class="margin-0 margin-bottom-20">
<input type="number" name="question[<?php echo $id;?>][number]" value="<?php echo $vars['checked'];?>" class="form-control">