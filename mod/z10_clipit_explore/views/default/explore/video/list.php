<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   23/06/14
 * Last update:     23/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$videos = elgg_extract('videos', $vars);
$href = elgg_extract('href', $vars);
?>
<div class="row">
    <?php
    foreach($videos as $video):
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
                <?php echo elgg_view('tricky_topic/tags/view', array('tags' => $video->tag_array, 'width' => 105, 'limit' => 2)); ?>
                <small class="show" style="margin-top: -5px;">
                    <?php
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
                    <?php echo elgg_view('output/friendlytime', array('time' => $video->time_created));?>
                </small>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>