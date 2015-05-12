<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   18/06/14
 * Last update:     18/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$accepted_inputs = array('filter', 'task_id');
$search_term = get_input("search");
?>
<form class="pull-right hidden-xs">
    <div class="search-box">
        <?php foreach(array_intersect($accepted_inputs, array_keys($_REQUEST)) as $request_input):?>
            <input type="hidden" value="<?php echo get_input($request_input);?>" name="<?php echo $request_input;?>">
        <?php endforeach; ?>
        <input type="text" value="<?php echo isset($search_term) ? $search_term : "";?>" placeholder="<?php echo elgg_echo('search');?>" name="search">
        <div class="input-group-btn">
            <span></span>
            <button type="submit">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </div>
</form>