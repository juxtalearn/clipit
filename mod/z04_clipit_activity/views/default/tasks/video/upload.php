<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   9/06/14
 * Last update:     9/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
// Video list
$video_ids = elgg_extract('videos', $vars);
$href = elgg_extract('href', $vars);
$body .= '<input type="file" name="files" id="uploadfilebutton" multiple>';
$body .= '<input type="submit">';
echo elgg_view_form("youtube", array('body' => $body, "enctype" => "multipart/form-data"), array());
?>
<ul class="video-list" style="
    background: #fafafa;  padding: 20px;
    overflow-y: auto;
">
    <?php
    foreach($video_ids as $video_id):
        $video = array_pop(ClipitVideo::get_by_id(array($video_id)));
        $tags = ClipitVideo::get_tags($video->id);
    ?>
    <li class="video-item row list-item">
        <div class="col-xs-2">
            <a target="_blank" href="<?php echo elgg_get_site_url()."{$href}/view/{$video->id}"; ?>">
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
        <div class="col-xs-10">
            <?php echo elgg_view('output/url', array(
                'href'  => "{$href}/publish/{$video->id}",
                'title' => elgg_echo('publish'),
                'style' => 'padding: 1px 5px;  background: #47a447;color: #fff;font-weight: bold;margin-left:10px;',
                'class' => 'btn-xs btn pull-right',
                'text'  => '<i class="fa fa-arrow-circle-up"></i> '.elgg_echo('select')));
            ?>
            <h5 class="text-truncate" style="margin: 0;">
                <strong>
                <?php echo elgg_view('output/url', array(
                    'href'  => "{$href}/view/".$video->id,
                    'target' => "_blank",
                    'title' => $video->name,
                    'text'  => $video->name));
                ?>
                </strong>
            </h5>
            <div class="tags">
                <?php echo elgg_view("page/elements/tags", array('tags' => $tags)); ?>
            </div>
        </div>
    </li>
    <?php endforeach; ?>
</ul>