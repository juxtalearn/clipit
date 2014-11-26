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
$video = elgg_extract('entity', $vars);
$date = date("M d, Y H:i", $video->time_created);
$edu = array_pop(ClipitActivity::get_by_id(array(ClipitVideo::get_activity($video->id))));
$edu_file = array_pop(ClipitFile::get_by_id(array(array_pop($edu->file_array))));
?>
<style>
    .container .content{
        background: transparent !important;
    }
</style>
<div class="multimedia-pub">
    <h3 class="margin-0 margin-bottom-20"><?php echo $video->name;?></h3>
    <div class="frame-container">
        <iframe src="<?php echo get_video_url_embed($video->url, true);?>" frameborder="0" allowfullscreen="true"></iframe>
    </div>
    <div class="details">
        <div class="description shorten row" style="background: #fff;">
            <div class="col-md-7">
                <small class="show margin-bottom-10">
                    <strong><?php echo elgg_echo('published:on');?></strong>
                    <?php echo $date;?>
                    (<?php echo elgg_view('output/friendlytime', array('time' => $video->time_created));?>)
                </small>
                <?php if($video->description):?>
                    <p>
                        <?php echo $video->description; ?>
                    </p>
                <?php endif;?>
                <?php if($tags):?>
                <small class="show"><strong><?php echo elgg_echo('tags');?></strong></small>
                <div class="tags">
                    <a href="http://www.clipit.es/trials/dcm/explore/search?by=tag&amp;id=79" class="label label-primary" title="Learning Analytics">Learning Analytics</a>
                    <a href="http://www.clipit.es/trials/dcm/explore/search?by=tag&amp;id=79" class="label label-primary" title="Learning Analytics">Moocs</a>
                </div>
                <?php endif;?>
            </div>
            <div class="col-md-5">
                <?php echo elgg_view('output/img',array(
                    'src' => $edu_file->thumb_small['url'],
                    'class' => 'image-block',
                    'style' => 'width: 40px;',
                ));?>
                <div class="content-block">
                    <strong>
                        <?php echo elgg_view('output/url', array(
                            'href' => "http://www.clipit.es/".$edu->description,
                            'text'  => $edu->name,
                            'title' => $edu->name
                        ));
                        ?>
                    </strong>
                    <div>
                        <?php echo elgg_view('output/url', array(
                            'href' => "videos/".$edu->description,
                            'text'  => '<i class="fa fa-youtube-play"></i> '.elgg_echo('videos:view_all'),
                            'title' => elgg_echo('videos:view_all')
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>