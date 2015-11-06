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
    'value' => 'quizzes'
));
?>
<div class="form-group">
    <label class="text-muted"><?php echo elgg_echo('quiz:name');?></label>
    <?php echo elgg_view("input/text", array(
        'name' => 'search[name]',
        'class' => 'form-control',
        'value' => get_search_input('name'),
        'aria-label' => elgg_echo('filter:quizname'),
    ));
    ?>
</div>
<div class="form-group">
    <label class="text-muted"><?php echo elgg_echo('tricky_topic');?></label>
    <?php echo elgg_view("input/text", array(
        'name' => 'search[tricky_topic]',
        'class' => 'form-control',
        'value' => get_search_input('tricky_topic'),
        'aria-label' => elgg_echo('filter:tricky'),
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