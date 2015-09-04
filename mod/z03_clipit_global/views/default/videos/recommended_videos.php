<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   02/03/2015
 * Last update:     02/03/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$videos = ClipitRemoteVideo::get_all();
$recommended_main = reset($videos);
$site = array_pop(ClipitRemoteSite::get_by_id(array($recommended_main->remote_site)));
?>
<div class="videos row">
    <div class="main-video col-md-9 margin-bottom-10">
        <div>
            <a class="cancel-video-view" style="display: none;" href="javascript:;">
                <i class="fa fa-times"></i>
            </a>
            <div id="show-video" class="frame-container" style="display: none;"></div>
            <div class="preview-video">
                <div class="details-video">
                    <h3 class="margin-0"><?php echo $recommended_main->name;?></h3>
                    <h4>
                        <a href="<?php echo $site->url;?>"><?php echo $site->name;?></a>
                    </h4>
                </div>
                <div class="cursor-pointer play-video" data-video="<?php echo $recommended_main->url;?>">
                    <div>
                        <div>
                            <a class="play-button" href="javascript:;">
                                <i class="fa fa-play"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php echo elgg_view('output/img', array(
                    'class' => 'bg-video',
                    'src' => get_video_thumbnail($recommended_main->url, 'large'),
                    'alt' => $recommended_main->name
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-3 row more-videos">
        <?php
        $recommended_videos = array_slice($videos, 1, 3);
        foreach($recommended_videos as $video):
        ?>
            <div class="col-md-12 col-xs-4 margin-bottom-10" data-video="<?php echo $video->url;?>">
                <a class="thumb-video" href="javascript:;">
                    <div class="bg-play">
                        <div>
                            <i class="fa fa-play-circle-o"></i>
                        </div>
                    </div>
                    <?php echo elgg_view('output/img', array(
                        'src' => get_video_thumbnail($video->url, 'normal'),
                        'alt' => $video->name,
                        'style' => 'width: 100%;height: 100%;'
                    ));
                    ?>
                </a>
            </div>
        <?php endforeach;?>
        <div class="col-md-12 text-center overflow-hidden">
            <div class="margin-top-10">
                <?php echo elgg_view('output/url', array(
                    'href' => 'videos',
                    'class' => 'view-more-videos btn',
                    'text' => elgg_echo('clipit:view:more_videos')
                ));
                ?>
            </div>
        </div>
    </div>
</div>
