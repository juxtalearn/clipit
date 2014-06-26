<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   25/06/14
 * Last update:     25/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entities = elgg_extract("entities", $vars);
$group = elgg_extract("group", $vars);
$activity_id = ClipitGroup::get_activity($group->id);
$href = "clipit_activity/{$activity_id}/group/{$group->id}/multimedia/view";
?>
<div class="attachment-files message-owner" style="overflow: hidden;">
    <span class="total-files"><i class="fa fa-paperclip"></i> <?php echo count($entities);?> multimedia attachments</span>
    <?php foreach($entities as $entity_id):
        $object = ClipitSite::lookup($entity_id);
        $entity = array_pop($object['subtype']::get_by_id(array($entity_id)));
        $file = "";
        switch($object['subtype']){
            case "ClipitFile":
                $file = $entity;
                break;
            case "ClipitStoryboard":
                $file = array_pop(ClipitFile::get_by_id(array($entity->file)));
                break;
        }
        ?>
        <?php echo elgg_view('multimedia/attach/view', array('entity' => $entity, 'href' => $href, 'file' => $file));?>
    <?php endforeach;?>
</div>