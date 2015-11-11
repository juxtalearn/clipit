<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   01/09/2015
 * Last update:     01/09/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$entity_id = elgg_extract('entity_id', $vars);
$entity = array_pop(ClipitTrickyTopic::get_by_id(array($entity_id)));
?>
<div class="bg-info">
    <h4><?php echo elgg_echo('explore:tags:related_tricky_topic');?></h4>
    <?php echo elgg_view('tricky_topic/tags/view', array('tags' => $entity->tag_array)); ?>
</div>