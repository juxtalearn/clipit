<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   14/07/14
 * Last update:     14/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$storyboard = elgg_extract('entity', $vars);
$file = elgg_extract('file', $vars);
$scope = ClipitStoryboard::get_resource_scope($storyboard->id);
?>
<div class="overflow-hidden">
<?php echo elgg_view("publications/view_scope", array('entity' => $storyboard));?>
<?php
if($scope == 'group'):
    $group = ClipitStoryboard::get_group($storyboard->id);
    $related_discussion = false;
?>
    <?php
    foreach(ClipitPost::get_by_destination(array($group)) as $discussion):
        $discussion = array_pop($discussion);
        if(in_array($storyboard->id, $discussion->storyboard_array)):
            $related_discussion = true;
            $activity_id = ClipitStoryboard::get_activity($storyboard->id);
            ?>
            <?php echo elgg_view('output/url', array(
            'title' => elgg_echo('discussion:multimedia:go'),
            'text' => '<i class="fa fa-comments"></i> '.elgg_echo('discussion:multimedia:go'),
            'href' => "clipit_activity/{$activity_id}/group/{$group}/discussion/view/{$discussion->id}",
            'class' => 'btn btn-primary pull-right',
        ));
            ?>
    <?php
        endif;
    endforeach;
    ?>
        <?php if(!$related_discussion):?>
            <?php echo elgg_view_form("discussion/create_from_multimedia", array(), array('entity' => $storyboard));?>
        <?php endif;?>
<?php endif;?>
</div>
<hr class="margin-0 margin-bottom-10">
<?php echo elgg_view("multimedia/file/body", array('entity' => $file));?>