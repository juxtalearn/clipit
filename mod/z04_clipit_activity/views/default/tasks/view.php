<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   9/06/14
 * Last update:     9/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$task = elgg_extract('entity', $vars);
?>
<h3>
    <?php echo $task->name;?>
    <span class="pull-right blue-lighter">
        <?php echo elgg_view('output/friendlytime', array('time' => $task->end));?>
    </span>
</h3>
<div class="description">
    <?php echo $task->description;?>
</div>
<div>
    <?php echo $vars['body']; ?>
</div>