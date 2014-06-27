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
$href = elgg_extract('href', $vars);
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
                'href' => "{$href}/view/{$video->id}",
                'text' => '<div class="bg-video" style="background-image: url(\''.$video->preview.'\');"></div>',
                'title' => $video->name,
                'is_trusted' => true,
            ));
            ?>
            <div>
                <h4>
                    <?php echo elgg_view('output/url', array(
                        'href' => "{$href}/view/{$video->id}",
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
                <?php echo elgg_view('tricky_topic/tags/view', array('tags' => $video->tag_array, 'width' => 105, 'limit' => 2)); ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>