<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   19/05/14
 * Last update:     19/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$labels = elgg_extract("labels", $vars);
if(!$labels): ?>
    <span class="text-muted">no labels added</span>
<?php endif; ?>
<?php
foreach($labels as $label_id):
    $label = array_pop(ClipitLabel::get_by_id(array($label_id)));
    ?>
    <?php echo elgg_view('output/url', array(
    'href'  => "explore/".$label->name,
    'title' => $label->name,
    'text'  => $label->name,
    'style' => 'border-bottom: 1px dotted #32b4e5;margin-right: 5px;',
));
    ?>
<?php endforeach; ?>