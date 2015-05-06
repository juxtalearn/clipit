<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity = elgg_extract('entity', $vars);
$video_ids = elgg_extract('videos', $vars);
$href = elgg_extract("href", $vars);
$rating = elgg_extract("rating", $vars);
$task_id = elgg_extract("task_id", $vars);
$user_id = elgg_get_logged_in_user_guid();
$user = array_pop(ClipitUser::get_by_id(array($user_id)));
?>
<?php if($vars['add_video']):?>
    <?php
    $modal = elgg_view("page/components/modal",
        array(
            "dialog_class"     => "modal-md",
            "target"    => "add-video",
            "title"     => elgg_echo("video:add"),
            "form"      => true,
            "body"      => elgg_view('forms/multimedia/videos/save', array('entity'  => $entity)),
            "cancel_button" => true,
            "ok_button" => elgg_view('input/submit',
                array(
                    'value' => elgg_echo('add'),
                    'class' => "btn btn-primary"
                ))
        ));

    ?>
    <?php echo elgg_view_form('', array(
            'data-validate'=> "true",
            'body' => $modal,
            'enctype' => 'multipart/form-data'
        ),
        array('entity'  => $entity)
    );
    ?>
    <div class="block" style="margin-bottom: 20px;">
        <button type="button" data-toggle="modal" data-target="#add-video" class="btn btn-default"><?php echo elgg_echo("video:add");?></button>
    </div>
<?php endif; ?>

<ul class="video-list">
<?php
    foreach($video_ids as $video_id):
        $video = array_pop(ClipitVideo::get_by_id(array($video_id)));
        $tags = ClipitVideo::get_tags($video->id);
        $description = trim(elgg_strip_tags($video->description));
        // Description truncate max length 280
        if(mb_strlen($description)>280){
            $description = substr($description, 0, 280)."...";
        }
        $published = false;
        if($vars['send_site']) {
            echo elgg_view("page/components/modal_remote", array('id' => "publish-{$video->id}"));
        }
        $href_video = $href."/view/".$video->id . ($task_id ? "?task_id=".$task_id."#evaluate": "");
    ?>
    <li class="video-item row list-item">
        <?php
        if($vars['preview'] !== false):
            echo elgg_view("page/components/modal_remote", array('id'=> "viewer-id-{$video->id}" ));
            $href_viewer = "ajax/view/multimedia/viewer?id=".$video->id;
        endif;
        ?>
        <div class="col-md-2">
            <?php if($vars['preview']):?>
                <a data-toggle="modal" data-target="#viewer-id-<?php echo $video->id;?>" href="<?php echo elgg_get_site_url()."{$href_viewer}"; ?>">
                    <div class="img-preview">
                        <img src="<?php echo $video->preview;?>">
                    </div>
                </a>
            <?php else:?>
                <a href="<?php echo elgg_get_site_url().$href_video; ?>">
                    <div class="img-preview">
                        <img src="<?php echo $video->preview;?>">
                    </div>
                </a>
            <?php endif;?>
        </div>
        <div class="col-md-10">
            <?php if($vars['actions']): ?>
                <?php echo elgg_view("multimedia/owner_options", array(
                    'entity' => $video,
                    'type' => 'video'
                )); ?>
            <?php endif; ?>
            <div class="pull-right text-right">
                <?php if($vars['author_bottom'] !== true):?>
                <div class="margin-bottom-5">
                    <?php echo elgg_view("publications/owner_summary", array(
                        'entity' => $video,
                        'entity_class' => 'ClipitVideo',
                        'msg' => elgg_echo('multimedia:uploaded_by')
                    ));
                    ?>
                </div>
                <?php endif;?>
                <?php if($vars['send_site']):?>
                    <div class="margin-bottom-5">
                        <?php
                        echo elgg_view('output/url', array(
                            'href'  => "ajax/view/modal/publications/publish?id={$video->id}",
                            'text'  => '<i class="fa fa-globe"></i> '.elgg_echo('send:to_site'),
                            'class' => 'btn btn-xs btn-primary',
                            'data-toggle'   => 'modal',
                            'data-target' => '#publish-'.$video->id,
                        ));
                        ?>
                    </div>
                <?php endif; ?>
                <?php if($rating):?>
                    <?php echo elgg_view("performance_items/summary", array(
                        'entity' => $video,
                    ));
                    ?>
                <?php endif; ?>
            </div>
            <h4 class="text-truncate">
                <?php if($vars['preview']):?>
                    <?php echo elgg_view('output/url', array(
                        'href'  => $href_viewer,
                        'title' => $video->name,
                        'data-target' => '#viewer-id-'.$video->id,
                        'data-toggle' => 'modal',
                        'text'  => $video->name
                    ));
                    ?>
                <?php else:?>
                    <?php echo elgg_view('output/url', array(
                        'href'  => $href_video,
                        'title' => $video->name,
                        'text'  => $video->name));
                    ?>
                <?php endif;?>
            </h4>
            <div class="tags">
                <?php echo elgg_view("tricky_topic/tags/view", array('tags' => $tags)); ?>
            </div>

            <small class="show" style="margin: 0">
                <?php if($vars['view_comments'] !== false):?>
                <?php
                    $total_comments = array_pop(ClipitComment::count_by_destination(array($video->id), true));
                ?>
                    <!-- Count total comments -->
                    <strong>
                        <?php echo elgg_view('output/url', array(
                            'href'  => $href_video."#comments",
                            'title' => elgg_echo('comments'),
                            'class' => 'pull-right btn btn-xs btn-xs-5 btn-blue-lighter',
                            'text'  => $total_comments. ' <i class="fa fa-comments"></i>'))
                        ?>
                    </strong>
                    <!-- Count total comments end-->
                <?php endif; ?>
                <?php if($vars['author_bottom']):?>
                    <div class="inline-block margin-right-10">
                    <?php echo elgg_view("publications/owner_summary", array(
                        'entity' => $video,
                        'entity_class' => 'ClipitVideo',
                        'msg' => elgg_echo('multimedia:uploaded_by')
                    ));
                    ?>
                    </div>
                <?php endif;?>
                <i>
                    <?php echo elgg_view('output/friendlytime', array('time' => $video->time_created));?>
                </i>
            </small>
        </div>
    </li>
    <?php endforeach;?>
</ul>