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
?>
<?php if($vars['add_video']):?>
    <?php echo elgg_view_form('multimedia/videos/add', array('data-validate'=> "true" ), array('entity'  => $entity)); ?>
    <div class="block" style="margin-bottom: 20px;">
        <button type="button" data-toggle="modal" data-target="#add-video" class="btn btn-default">Add video</button>
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
        ?>
        <li class="video-item row list-item">
            <div class="col-lg-4">
                <a href="<?php echo elgg_get_site_url()."{$href}/view/{$video->id}"; ?>">
                    <div class="img-preview">
                        <?php
                        if($rating):
                            $rating_average = ClipitPerformanceRating::get_average_target_rating($video->id);
                        ?>
                        <div class="pull-right rating ratings readonly white-star" data-score="<?php echo $rating_average;?>">
                            <?php echo star_rating_view($rating_average);?>
                        </div>
                        <?php endif; ?>
                        <img src="<?php echo $video->preview;?>">
                        <span class="duration label"><?php echo get_format_time($video->duration);?></span>
                    </div>
                </a>
            </div>
            <div class="col-lg-8">
                <?php if($vars['actions'] && !$published): ?>
                    <?php echo elgg_view('output/url', array(
                        'href'  => "{$href}/publish/{$video->id}",
                        'title' => elgg_echo('publish'),
                        'style' => 'padding: 1px 5px;  background: #47a447;color: #fff;font-weight: bold;',
                        'class' => 'btn-xs btn pull-right',
                        'text'  => '<i class="fa fa-arrow-circle-up"></i> '.elgg_echo('publish')));
                    ?>
                    <?php echo elgg_view("multimedia/owner_options", array('entity' => $video, 'type' => 'video')); ?>
                <?php elseif($published): ?>
                    <?php echo elgg_view('output/url', array(
                        'href'  => "{$href}/publish/{$video->id}",
                        'title' => elgg_echo('published'),
                        'class' => 'green pull-right',
                        'text'  => '<i class="fa fa-check"></i> <strong>'.elgg_echo('published').'</strong>'));
                    ?>
                <?php endif; ?>
                <h4 class="text-truncate">
                    <?php echo elgg_view('output/url', array(
                        'href'  => "{$href}/view/".$video->id,
                        'title' => $video->name,
                        'text'  => $video->name));
                    ?>
                </h4>
                <div class="tags">
                    <?php echo elgg_view("page/elements/tags", array('tags' => $tags)); ?>
                </div>
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
                        'class' => 'pull-right',
                        'text'  => $total_comments. ' <i class="fa fa-comments"></i>'))
                        ?>
                        </strong>
                        <!-- Count total comments end-->
                    <?php endif; ?>
                    <?php echo elgg_view("publications/owner_summary", array(
                        'entity' => $video,
                        'entity_class' => 'ClipitVideo',
                        'msg' => 'Uploaded by'
                    )); ?>
                    <i>
                        <?php echo elgg_view('output/friendlytime', array('time' => $video->time_created));?>
                    </i>
                </small>
            </div>
        </li>
    <?php endforeach; ?>
</ul>