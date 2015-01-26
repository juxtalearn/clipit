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
$tags = get_input('tags');
?>
<?php
echo elgg_view("input/hidden", array(
    'name' => 'tags',
    'id' => 'input_tags',
    'value' => $tags
));
?>
<div class="form-group">
    <label class="text-muted"><?php echo elgg_echo('quiz:name');?></label>
    <?php echo elgg_view("input/text", array(
        'name' => 'quiz',
        'class' => 'form-control',
        'value' => get_input('quiz')
    ));
    ?>
</div>
<div class="form-group">
    <label class="text-muted"><?php echo elgg_echo('tricky_topic');?></label>
    <?php echo elgg_view("input/text", array(
        'name' => 'tricky_topic',
        'class' => 'form-control',
        'value' => get_input('tricky_topic')
    ));
    ?>
</div>
<div class="form-group">
    <label class="text-muted"><?php echo elgg_echo('tags');?></label>
    <ul id="tags"></ul>
</div>

<div class="text-right">
    <?php echo elgg_view('input/submit', array(
        'class' => 'btn btn-primary btn-sm',
        'value'  => elgg_echo('search'),
    ));
    ?>
</div>