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
    'value' => 'tricky_topics'
));

$tags = implode(",", get_search_input('tags'));
echo elgg_view("input/hidden", array(
    'name' => 'tags',
    'id' => 'input_tags',
    'value' => $tags
));
?>
<div class="form-group">
    <label class="text-muted" for="search[name]"><?php echo elgg_echo('tricky_topic');?></label>
    <?php echo elgg_view("input/text", array(
        'name' => 'search[name]',
        'id' => 'search[name]',
        'class' => 'form-control',
        'value' => get_search_input('name')
    ));
    ?>
</div>
<div class="form-group">
    <label class="text-muted"><?php echo elgg_echo('tags');?></label>
    <ul id="tags"></ul>
</div>
<div class="form-group">
    <label class="text-muted" for="search[education_level]"><?php echo elgg_echo('education_level');?></label>
    <?php echo elgg_view("input/dropdown", array(
        'name' => 'search[education_level]',
        'id' => 'search[education_level]',
        'style' => 'padding: 0;height: 25px;',
        'value' => get_search_input('education_level'),
        'class' => 'form-control select-question-type',
        'options_values' => get_education_levels(),
    ));
    ?>
</div>
<div class="form-group">
    <label class="text-muted" for="search[subject]"><?php echo elgg_echo('tricky_topic:subject');?></label>
    <?php echo elgg_view("input/text", array(
        'name' => 'search[subject]',
        'id' => 'search[subject]',
        'class' => 'form-control',
        'value' => get_search_input('subject')
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