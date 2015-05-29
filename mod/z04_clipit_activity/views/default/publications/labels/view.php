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
    <span class="text-muted"><?php echo elgg_echo('labels:none');?></span>
<?php endif; ?>
<?php
foreach($labels as $label_id):
    $label = array_pop(ClipitLabel::get_by_id(array($label_id)));
    ?>
    <?php echo elgg_view('output/url', array(
    'href'  => "explore/search?by=label&id=".$label->id,
    'class' => 'text-truncate',
    'title' => $label->name,
    'text'  => $label->name,
    'style' => 'border-bottom: 1px dotted #32b4e5;margin-right: 5px;display:inline-block;max-width: 100px;',
));
    ?>
<?php endforeach; ?>
<script>
    clipit.shorten('#label_list', 45, '<?php echo elgg_echo('link:view:all');?>', '<?php echo elgg_echo('link:view:less');?>');
</script>