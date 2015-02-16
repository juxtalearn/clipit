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
$entities_ids = elgg_extract('entities', $vars);
$href = elgg_extract("href", $vars);
$rating = elgg_extract("rating", $vars);
$user_id = elgg_get_logged_in_user_guid();
?>
<?php echo elgg_view("videos/search"); ?>

<?php if($vars['create']):?>
    <?php
    $modal = elgg_view("page/components/modal",
        array(
            "dialog_class"     => "modal-md",
            "target"    => "add-video",
            "title"     => elgg_echo("video:add"),
            "form"      => true,
            "body"      => elgg_view('forms/multimedia/videos/save', array('scope_entity'  => $entity)),
            "cancel_button" => true,
            "ok_button" => elgg_view('input/submit',
                array(
                    'value' => elgg_echo('add'),
                    'class' => "btn btn-primary"
                ))
        ));

    ?>
    <?php echo elgg_view_form('multimedia/videos/add', array(
            'action' => 'action/multimedia/videos/save',
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
    foreach($entities_ids as $video_id):
        $video = array_pop(ClipitVideo::get_by_id(array($video_id)));
        $tags = ClipitVideo::get_tags($video->id);
        $description = trim(elgg_strip_tags($video->description));
        // Description truncate max length 280
        if(mb_strlen($description)>280){
            $description = substr($description, 0, 280)."...";
        }
        $published = false;
        $href_video = $href."/view/".$video->id . ($vars['task_id'] ? "?task_id=".$vars['task_id']: "");
        ?>
        <li class="video-item row list-item">
            <div class="col-md-4">
                <a href="<?php echo elgg_get_site_url().$href_video; ?>">
                    <div class="img-preview">
                        <img src="<?php echo $video->preview;?>">
                    </div>
                </a>
            </div>
            <div class="col-md-8">
                <?php
                if($vars['task_id']):
                    if(array_pop(ClipitVideo::get_read_status($video->id, array($user_id)))):
                ?>
                <div class="pull-right margin-right-20 margin-top-5">
                    <i class="fa fa-eye blue" style="font-size: 16px;"></i>
                </div>
                <?php
                    endif;
                    endif;
                ?>
                <?php if($vars['publish']): ?>
                    <?php echo elgg_view('output/url', array(
                        'href'  => "{$href}/publish/{$video->id}".($vars['task_id'] ? "?task_id=".$vars['task_id']: ""),
                        'title' => elgg_echo('publish'),
                        'style' => 'padding: 1px 5px;  background: #47a447;color: #fff;font-weight: bold;margin-left:10px;',
                        'class' => 'btn-xs btn pull-right',
                        'text'  => '<i class="fa fa-arrow-circle-up"></i> '.elgg_echo('publish')));
                    ?>
                <?php endif; ?>
                <?php if($vars['actions']): ?>
                    <?php echo elgg_view("multimedia/owner_options", array('entity' => $video, 'type' => 'video')); ?>
                <?php endif; ?>
                <div class="pull-right text-right">
                    <?php if($vars['send_site']):?>
                    <div class="margin-bottom-5">
                        <?php echo elgg_view('output/url', array(
                            'href'  => $vars['href_site'].$video->id,
                            'class' => 'btn btn-xs btn-primary',
                            'text'  => '<i class="fa fa-globe"></i> '.elgg_echo('send:to_site')
                        ));
                        ?>
                    </div>
                    <?php endif; ?>
                    <?php if($rating):?>
                        <?php echo elgg_view("performance_items/summary", array(
                            'entity' => $video,
                            'show_check' => true,
                        ));
                        ?>
                    <?php endif; ?>
                </div>
                <h4 class="text-truncate">
                    <?php echo elgg_view('output/url', array(
                        'href'  => $href_video,
                        'title' => $video->name,
                        'text'  => $video->name));
                    ?>
                </h4>
                <?php echo elgg_view('tricky_topic/tags/view', array('tags' => $tags)); ?>
                <p>
                    <?php echo $description;?>
                </p>
                <small class="show">
                    <?php
                    if($vars['total_comments']):
                        $total_comments = array_pop(ClipitComment::count_by_destination(array($video->id), true));
                    ?>
                        <!-- Count total comments -->
                        <strong>
                        <?php echo elgg_view('output/url', array(
                        'href'  => "{$href}/view/{$video->id}#comments",
                        'title' => elgg_echo('comments'),
                        'class' => 'pull-right btn btn-xs btn-xs-5 btn-blue-lighter',
                        'text'  => $total_comments. ' <i class="fa fa-comments"></i>'))
                        ?>
                        </strong>
                        <!-- Count total comments end-->
                    <?php endif; ?>
                    <?php echo elgg_view("publications/owner_summary", array(
                        'entity' => $video,
                        'entity_class' => 'ClipitVideo',
                        'msg' => elgg_echo('multimedia:uploaded_by')
                    )); ?>
                    <i>
                        <?php echo elgg_view('output/friendlytime', array('time' => $video->time_created));?>
                    </i>
                </small>
            </div>
        </li>
    <?php endforeach;?>
</ul>