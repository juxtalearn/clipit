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
$file = elgg_extract('entity', $vars);
$scope = ClipitFile::get_resource_scope($file->id);
?>
<div class="overflow-hidden">
    <?php echo elgg_view("publications/view_scope", array('entity' => $file));?>
    <?php
    if($scope == 'group'):
        $group = ClipitFile::get_group($file->id);
        $related_discussion = false;
        ?>
        <?php foreach(ClipitPost::get_by_destination(array($group)) as $discussion):
        $discussion = array_pop($discussion);
        if(in_array($file->id, $discussion->video_array)):
            $related_discussion = true;
            $activity_id = ClipitFile::get_activity($file->id);
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
        <?php echo elgg_view_form("discussion/create_from_multimedia", array(), array('entity' => $file));?>
    <?php endif;?>
    <?php endif;?>
</div>
<hr class="margin-0 margin-bottom-10">
<?php if($vars['preview']):?>
    <div class="multimedia-preview">
        <?php echo elgg_view('output/url', array(
        'href'  => $file_url,
        'title' => $file->name,
        'text'  => elgg_view("multimedia/file/preview", array('file'  => $file))));?>
    </div>
<?php endif;?>
<div>
    <?php echo elgg_view('output/url', array(
        'href'  => "file/download/".$file->id,
        'title' => elgg_echo('download'),
        'target' => '_blank',
        'class' => 'btn btn-default',
        'text'  => '<i class="fa fa-download"></i> '.elgg_echo('file:download')));
    ?>
    <div class="file-info">
        <strong class="show"><?php echo elgg_echo("file:" . $file->mime_type['short']);?></strong>
        <?php echo formatFileSize($file->size);?>
    </div>
</div>
<?php echo elgg_view('multimedia/file/view', array(
    'file'  => $file,
    'size' => 'original'));
?>