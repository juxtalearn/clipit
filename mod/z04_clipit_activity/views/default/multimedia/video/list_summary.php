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
    <?php
    $modal = elgg_view("page/components/modal",
        array(
            "dialog_class"     => "modal-md",
            "target"    => "add-video",
            "title"     => elgg_echo("video:add"),
            "form"      => true,
            "body"      => elgg_view('multimedia/video/add', array('entity'  => $entity)),
            "cancel_button" => true,
            "ok_button" => elgg_view('input/submit',
                array(
                    'value' => elgg_echo('add'),
                    'class' => "btn btn-primary"
                ))
        ));

    ?>
    <?php echo elgg_view_form('multimedia/videos/add', array(
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
    ?>
    <li class="video-item row list-item">
        <div class="col-md-2">
            <a href="<?php echo elgg_get_site_url()."{$href}/view/{$video->id}"; ?>">
                <div class="img-preview">
                    <img src="<?php echo $video->preview;?>">
                </div>
            </a>
        </div>
        <div class="col-md-10">
            <?php echo elgg_view("publications/owner_summary", array(
                'entity' => $video,
                'class' => 'pull-right',
                'entity_class' => 'ClipitVideo',
                'msg' => 'Uploaded by'
            )); ?>
            <h4 class="text-truncate">
                <?php echo elgg_view('output/url', array(
                    'href'  => "{$href}/view/".$video->id,
                    'title' => $video->name,
                    'text'  => $video->name));
                ?>
            </h4>
            <?php
            if($rating):
                $rating_average = ClipitPerformanceRating::get_average_target_rating($video->id);
                ?>
                <div class="pull-right rating ratings readonly" data-score="<?php echo $rating_average;?>">
                    <?php echo star_rating_view($rating_average);?>
                </div>
            <?php endif; ?>
            <div class="tags">
                <?php echo elgg_view("tricky_topic/tags/view", array('tags' => $tags)); ?>
            </div>
            <small class="show" style="margin: 0">
                <?php
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
                <i>
                    <?php echo elgg_view('output/friendlytime', array('time' => $video->time_created));?>
                </i>
            </small>
        </div>
    </li>
    <?php endforeach;?>
</ul>