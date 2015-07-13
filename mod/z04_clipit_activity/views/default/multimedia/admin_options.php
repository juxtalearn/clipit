<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   30/07/14
 * Last update:     30/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity = elgg_extract('entity', $vars);
$object = ClipitSite::lookup($entity->id);
$entity_class = $object['subtype'];
$scope = $entity_class::get_scope($entity->id);

if($scope == 'group'):
    $group = $entity_class::get_group($entity->id);
    $related_discussion = false;
?>
<!-- Create or view discussion related -->
<?php foreach(array_pop(ClipitPost::get_by_destination(array($group))) as $discussion):
    //$discussion = array_pop($discussion);
    $items_array = array_merge($discussion->file_array, $discussion->video_array, $discussion->file_array);
    if(in_array($entity->id, $items_array)):
        $related_discussion = true;
        $activity_id = $entity_class::get_activity($entity->id);
        ?>
        <?php
        $output = elgg_view('output/url', array(
            'title' => elgg_echo('discussion:multimedia:go'),
            'text' => '<i class="fa fa-comments"></i> '.elgg_echo('discussion:multimedia:go'),
            'href' => "clipit_activity/{$activity_id}/group/{$group}/discussion/view/{$discussion->id}",
            'class' => 'btn btn-primary btn-xs pull-right',
        ));
    ?>
<?php
    endif;
endforeach;
?>
    <?php if(!$related_discussion):?>
        <?php $output = elgg_view_form("discussion/create_from_multimedia", array('class' => 'pull-right'), array('entity' => $entity));?>
    <?php endif;?>
<?php endif;?>
<!-- View scope dropdown -->
<?php $output .= elgg_view("publications/view_scope", array('entity' => $entity));?>

<?php if($output):?>
    <div class="bg-blue-lighter_2" style="padding: 10px;">
        <?php echo $output;?>
        <div class="clearfix"></div>
    </div>
<?php endif;?>
