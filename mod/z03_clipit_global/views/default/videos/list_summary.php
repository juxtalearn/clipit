<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   23/11/2015
 * Last update:     23/11/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entities = elgg_extract('entities', $vars);
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
<ul class="row margin-bottom-20">
    <?php
    foreach($entities as $video):
        $edu = array_pop(ClipitRemoteSite::get_by_id(array($video->remote_site)));
        $video_url = "video/".elgg_get_friendly_title($video->name)."/".$video->id;
    ?>
        <li class="col-md-4 margin-bottom-20">
            <div class="col-md-12">
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
            <div class="col-md-12">
                <strong>
                    <?php
                    echo elgg_view('output/url', array(
                        'href' =>  $video_url,
                        'class' => 'text-truncate',
                        'text'  => $video->name,
                        'title' => $video->name,
                    ));
                    ?>
                </strong>
                <small class="show">
                    <?php
                    if(isset($edu)) {
                        echo elgg_view('output/url', array(
                            'href' => "videos/" . elgg_get_friendly_title($edu->name) . "/" . $edu->id,
                            'text' => $edu->name,
                            'class' => 'text-muted',
                            'title' => $edu->name,
                        ));
                    }
                    ?>
                </small>
            </div>
        </li>
    <?php endforeach;?>
</ul>
