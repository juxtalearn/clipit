<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   19/01/2015
 * Last update:     19/01/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
echo elgg_view("input/hidden", array(
    'name' => 'page',
    'value' => 'rubrics'
));
?>
<div class="form-group">
    <label class="text-muted"><?php echo elgg_echo('rubric:name');?></label>
    <?php echo elgg_view("input/text", array(
        'name' => 'search[name]',
        'class' => 'form-control',
        'value' => get_search_input('name'),
        'aria-label' => elgg_echo('filter:rubric:name'),
    ));
    ?>
</div>
<div class="form-group">
    <label class="text-muted"><?php echo elgg_echo('author');?></label>
    <?php echo elgg_view("input/text", array(
        'name' => 'search[author]',
        'class' => 'form-control',
        'value' => get_search_input('author'),
        'aria-label' => elgg_echo('filter:author:name'),
    ));
    ?>
</div>
<div class="text-right">
    <?php echo elgg_view('input/submit', array(
        'class' => 'btn btn-primary btn-sm',
        'value'  => elgg_echo('search:btn'),
    ));
    ?>
</div>