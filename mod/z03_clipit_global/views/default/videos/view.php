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
$video = elgg_extract('entity', $vars);
$date = date("M d, Y H:i", $video->time_created);
$edu = elgg_extract('site', $vars);
?>
<style>
    .container .content{
        background: transparent !important;
        padding: 0 !important;
    }
    .tags{
        display: block;
    }
</style>
<div class="multimedia-pub">
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
                <?php if(!empty($video->tag_array)):?>
                    <h4><?php echo elgg_echo('tags');?></h4>
                    <?php echo elgg_view("global/tags/view", array('tags' => $video->tag_array)); ?>
                <?php endif;?>
            </div>
            <div class="col-md-5">
                <div class="content-block">
                    <small><strong><?php echo elgg_echo('educational:centers');?></strong></small>
                    <div>
                        <?php echo elgg_view('output/url', array(
                            'href' => $edu->url,
                            'class' => 'pull-right btn btn-xs btn-primary',
                            'text'  => elgg_echo('connect'),
                            'title' => elgg_echo('connect')
                        ));
                        ?>
                        <?php echo $edu->name;?>
                        <div class="clearfix"></div>
                        <?php echo elgg_view('output/url', array(
                            'href' => "videos/".elgg_get_friendly_title($edu->name)."/".$edu->id,
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