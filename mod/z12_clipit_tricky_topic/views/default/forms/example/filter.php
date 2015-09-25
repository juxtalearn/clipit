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
$tags = implode(",", get_search_input('tags'));
echo elgg_view("input/hidden", array(
    'name' => 'page',
    'value' => 'tricky_topics/examples'
));
?>
<?php
echo elgg_view("input/hidden", array(
    'name' => 'tags',
    'id' => 'input_tags',
    'value' => $tags
));
?>
<div class="form-group">
    <label class="text-muted" for="search[name]"><?php echo elgg_echo('example:name');?></label>
    <?php echo elgg_view("input/text", array(
        'name' => 'search[name]',
        'class' => 'form-control',
        'value' => get_search_input('name')
    ));
    ?>
</div>
<div class="form-group">
    <label class="text-muted" for="search[tricky_topic]"><?php echo elgg_echo('tricky_topic');?></label>
    <?php echo elgg_view("input/text", array(
        'name' => 'search[tricky_topic]',
        'class' => 'form-control',
        'value' => get_search_input('tricky_topic')
    ));
    ?>
</div>
<div class="form-group">
    <label class="text-muted"><?php echo elgg_echo('tags');?></label>
    <ul id="tags"></ul>
</div>
<div class="form-group">
    <label class="text-muted" for="search[location]"><?php echo elgg_echo('location');?></label>
    <?php echo elgg_view("input/text", array(
        'name' => 'search[location]',
        'id' => 'search[location]',
        'class' => 'form-control',
        'value' => get_search_input('location')
    ));
    ?>
</div>
<div class="form-group">
    <label class="text-muted" for="search[country]"><?php echo elgg_echo('country');?></label>
    <?php echo elgg_view("input/dropdown", array(
        'name' => 'search[country]',
        'style' => 'padding: 0;height: 25px;',
        'value' => get_search_input('country'),
        'class' => 'form-control select-question-type',
        'options_values' => get_countries_list(),
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