<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   23/06/14
 * Last update:     23/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$videos = elgg_extract('videos', $vars);
?>
<div class="row">
    <?php
    foreach($videos as $video):
        $activity_id = ClipitVideo::get_activity($video->id);
        $activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
        $tricky_topic = array_pop(ClipitTrickyTopic::get_by_id(array($activity->tricky_topic)));
    ?>
    <div class="col-md-5 col-lg-4">
        <div class="video_prev">
            <?php echo elgg_view('output/url', array(
                'href' => "explore/video/view/{$video->id}",
                'text' => '<div class="bg-video" style="background-image: url(\''.$video->preview.'\');"></div>',
                'title' => $video->name,
                'is_trusted' => true,
            ));
            ?>
            <div>
                <h4>
                    <?php echo elgg_view('output/url', array(
                        'href' => "explore/video/view/{$video->id}",
                        'text' => $video->name,
                        'title' => $video->name,
                        'is_trusted' => true,
                    ));
                    ?>
                </h4>
                <p class="date">
                    <?php echo elgg_view('output/url', array(
                        'href' => "explore/search?by=tricky_topic&id={$tricky_topic->id}",
                        'text' => $tricky_topic->name,
                        'title' => $tricky_topic->name,
                        'class' => 'pull-right',
                        'is_trusted' => true,
                    ));
                    ?>
                    <?php echo elgg_view('output/friendlytime', array('time' => $video->time_created));?>
                </p>
                <div class="sbs">
                    <?php
                    if($tags = $video->tag_array):
                    foreach(array_slice($tags, 0, 3) as $tag_id):
                        $tag = array_pop(ClipitTag::get_by_id(array($tag_id)));
                    ?>
                     <p>
                         <?php echo elgg_view('output/url', array(
                             'href' => "explore/search?by=tag&id={$tag->id}",
                             'text' => $tag->name,
                             'title' => $tag->name,
                             'is_trusted' => true,
                         ));
                         ?>
                     </p>
                    <?php endforeach;?>
                        <?php if(count($tags) > 3): ?>
                            <span class="more-sbs fa fa-plus"></span>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>