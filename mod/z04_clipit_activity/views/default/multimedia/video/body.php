<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   13/05/14
 * Last update:     13/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$video = elgg_extract("entity", $vars);
$scope = ClipitVideo::get_resource_scope($video->id);
?>
<div class="overflow-hidden">
<?php echo elgg_view("publications/view_scope", array('entity' => $video));?>
<?php
    if($scope == 'group'):
        $group = ClipitVideo::get_group($video->id);
        $related_discussion = false;
?>
    <?php foreach(ClipitPost::get_by_destination(array($group)) as $discussion):
        $discussion = array_pop($discussion);
        if(in_array($video->id, $discussion->video_array)):
            $related_discussion = true;
            $activity_id = ClipitVideo::get_activity($video->id);
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
        <?php echo elgg_view_form("discussion/create_from_multimedia", array(), array('entity' => $video));?>
    <?php endif;?>
<?php endif;?>
</div>
<hr class="margin-0 margin-bottom-10">
<div class="frame-container" style="width: 100%;">
    <?php echo elgg_view('output/iframe', array(
        'value'  => get_video_url_embed($video->url)));
    ?>
</div>