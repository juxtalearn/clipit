<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   21/10/2014
 * Last update:     21/10/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$videos = elgg_extract('videos', $vars);
?>
<style>
    .wrapper-ratio{
        position: relative;
    }
    .wrapper-ratio:after{
        padding-top: 56.25%;
        /* 16:9 ratio */
        display: block;
        content: '';
    }
    .wrapper-ratio .aspect-ratio{
        position: absolute;
        top: 0;
        bottom: 0;
        right: 0;
        left: 0;
        display: block;
        background-repeat: no-repeat;
        background-position: 50% 50%;
        background-size: cover;
    }
</style>
<h3 class="title-block margin-top-20"><?php echo elgg_echo('latest:videos');?></h3>
<ul class="row">
    <?php
    foreach($videos as $video):
        $edu = array_pop(ClipitRemoteSite::get_by_id(array($video->remote_site)));
        $video_url = "video/".elgg_get_friendly_title($video->name)."/".$video->id;
    ?>
        <li class="list-item overflow-hidden">
            <div class="col-md-5">
                <div class="wrapper-ratio">
                <?php echo elgg_view('output/url', array(
                    'href' => $video_url,
                    'class' => 'aspect-ratio',
                    'style'  => 'background-image: url(\''.get_video_thumbnail($video->url, 'normal').'\');',
                    'text' => '',
                    'title' => $video->name,
                ));
                ?>
                </div>
            </div>
            <div class="col-md-7">
                <strong>
                <?php
                echo elgg_view('output/url', array(
                    'href' =>  $video_url,
                    'text'  => $video->name,
                    'title' => $video->name,
                ));
                ?>
                </strong>
                <small class="show">
                    <?php
                    echo elgg_view('output/url', array(
                        'href' => "videos/".elgg_get_friendly_title($edu->name)."/".$edu->id,
                        'text'  => $edu->name,
                        'class' => 'text-muted',
                        'title' => $edu->name,
                    ));
                    ?>
                </small>
            </div>
        </li>
    <?php endforeach;?>
</ul>