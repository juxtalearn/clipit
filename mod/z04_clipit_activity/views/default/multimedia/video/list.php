<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$entity = elgg_extract('entity', $vars);
$entities_ids = elgg_extract('entities', $vars);
$videos = ClipitVideo::get_by_id($entities_ids);

$href = elgg_extract("href", $vars);
$rating = elgg_extract("rating", $vars);
$task_id = elgg_extract("task_id", $vars);
$unlink = elgg_extract("unlink", $vars);
$user_id = elgg_get_logged_in_user_guid();
if($unlink){
    $user_groups = ClipitUser::get_groups($user_id);
}
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
    // if create var contains additional data
    $modal .= $vars['create_form'];
    ?>
    <?php echo elgg_view_form('', array(
            'action' => 'action/multimedia/videos/save',
            'data-validate'=> "true",
            'body' => $modal,
            'enctype' => 'multipart/form-data'
        ),
        array('entity'  => $entity)
    );
    ?>
    <div class="block" style="margin-bottom: 20px;">
        <button type="button" data-toggle="modal" data-target="#add-video" class="btn btn-default">
            <?php echo elgg_echo("video:add");?>
        </button>
    </div>
<?php endif; ?>
<div class="clearfix"></div>
<ul class="video-list">
    <?php
    foreach($videos as $video):
        $tags = ClipitVideo::get_tags($video->id);
        $description = trim(elgg_strip_tags($video->description));
        $description = elgg_get_excerpt($description, 150);
        $published = false;
        $unlinked = false;
        if($unlink && in_array(ClipitVideo::get_group($video->id), $user_groups)){
            $unlinked = true;
        }
        $href_video = $href."/view/".$video->id . ($task_id ? "?task_id=".$task_id: "");
    ?>
        <li class="video-item row list-item">
            <?php if($vars['send_site']):?>
                <?php echo elgg_view("page/components/modal_remote", array('id'=> "publish-{$video->id}" ));?>
            <?php endif;?>
            <div class="col-md-4">
                <a href="<?php echo elgg_get_site_url().$href_video; ?>">
                    <div class="img-preview">
                        <img src="<?php echo $video->preview;?>">
                    </div>
                </a>
            </div>
            <div class="col-md-8">
                <?php
                if($task_id && $vars['task_type'] == ClipitTask::TYPE_RESOURCE_DOWNLOAD):
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
                        'href'  => "{$href}/publish/{$video->id}".($task_id ? "?task_id=".$task_id: ""),
                        'title' => elgg_echo('select'),
                        'style' => 'background: #47a447;color: #fff;font-weight: bold;margin-left:10px;',
                        'class' => 'btn-sm btn pull-right btn-primary',
                        'text'  => elgg_view('page/components/tooltip', array('text' => elgg_echo('publications:select:tooltip')))
                                   .elgg_echo('select').'...'
                    ));
                    ?>
                <?php endif; ?>

                <?php if($vars['actions']):?>
                    <?php echo elgg_view("multimedia/owner_options", array(
                        'entity' => $video,
                        'type' => 'video',
                        'remove' => count(ClipitVideo::get_clones($video->id)) > 0 ? false:true,
                    ));
                    ?>
                <?php endif; ?>
                <div class="pull-right text-right">
                    <?php if($vars['send_site']):?>
                    <div class="margin-bottom-5">
                        <?php if(ClipitVideo::get_site($video->id, true)):?>
                            <strong class="green">
                                <i class="fa fa-check "></i> <?php echo elgg_echo('published');?>
                            </strong>
                        <?php else:?>
                            <?php echo elgg_view('output/url', array(
                                'href'  => "ajax/view/modal/publications/publish?id={$video->id}",
                                'class' => 'btn btn-sm btn-primary',
                                'text'  => '<i class="fa fa-globe"></i> '.elgg_echo('send:to_site'),
                                'data-toggle'   => 'modal',
                                'data-target' => '#publish-'.$video->id,
                            ));
                            ?>
                        <?php endif;?>
                    </div>
                    <?php endif; ?>
                    <?php if($unlinked):?>
                        <?php echo elgg_view('output/url', array(
                            'href'  => 'action/multimedia/videos/remove?id='.$video->id.'&unlink=true',
                            'is_action' => true,
                            'class'  => 'btn btn-xs btn-border-red btn-primary margin-bottom-10 remove-object',
                            'title' => elgg_echo('task:remove_video'),
                            'text'  => '<i class="fa fa-trash-o"></i> '.elgg_echo('task:remove_video')
                        ));
                        ?>
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
                <?php echo elgg_view('tricky_topic/tags/view', array('tags' => $tags, 'limit' => 3)); ?>
                <p class="hidden-xs">
                    <?php echo $description;?>
                </p>
                <div class="clearfix"></div>
                <small class="show">
                    <?php
                    if($vars['total_comments']):
                        $total_comments = array_pop(ClipitComment::count_by_destination(array($video->id), false));
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