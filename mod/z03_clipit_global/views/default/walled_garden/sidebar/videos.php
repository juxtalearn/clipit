<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   21/10/2014
 * Last update:     21/10/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$videos = elgg_extract('videos', $vars);
?>
<h3 class="title-block margin-top-20"><?php echo elgg_echo('latest:videos');?></h3>
<ul>
    <?php
    foreach($videos as $video):
        $activity = array_pop(ClipitActivity::get_by_id(array(ClipitVideo::get_activity($video->id))));
        $video_url = "video/".$video->id."/".elgg_get_friendly_title($video->name);
    ?>
        <li class="list-item overflow-hidden">
            <?php
            echo elgg_view('output/url', array(
                'href' => $video_url,
                'text'  => '
                <div class="image-block"
                 style="
                     background-image: url(\''.get_video_thumbnail($video->url, 'small').'\');
            width: 60px;
            height: 60px;
            background-position: 50% 50%;
            ">
            </div>',
                'title' => $video->name,
            ));
            ?>

            <div class="content-block">
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
                        'href' => "videos/".$activity->description,
                        'text'  => $activity->name,
                        'class' => 'text-muted',
                        'title' => $activity->name,
                    ));
                    ?>
                </small>
            </div>
        </li>
    <?php endforeach;?>
</ul>