<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   29/05/14
 * Last update:     29/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$activity = elgg_extract('activity', $vars);
$author = elgg_extract('author', $vars);
?>
<style>
.event-simple .section .video-item{
    width: 50%;
}
.event-simple .section{
    margin-top: 10px;
    background: #fafafa;
    padding: 10px;
    overflow: hidden;
}
.event-simple .description{
    color: #666666;
}
.event-simple .description.discussion-text{
    margin-bottom: 5px;
    border-bottom: 1px solid #EBEBEB;
    padding-bottom: 5px;
}
</style>
<li class="list-item event-simple event">
    <div class="event-section">
        <div>
            <div class="image-block">
                <?php echo elgg_view("recommended/events/author_image", array('author_id' => $author, 'activity' => $activity));?>
            </div>
            <div class="content-block">
                <small class="pull-right">
                    <?php echo elgg_view('output/friendlytime', array('time' => $vars["time_created"]));?>
                </small>
                <?php echo elgg_view("recommended/events/author", array('author_id' => $author, 'activity' => $activity));?>
                <small class="show">
                    <i class="fa <?php echo $vars['icon'];?>" style="color: #<?php echo $activity->color;?>;"></i>
                    <?php echo $vars['title'];?>
                </small>
                <?php if($body = $vars['body']):?>
                    <div class="event-details" style="  ">
                        <div class="section">
                            <?php echo $body;?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</li>
