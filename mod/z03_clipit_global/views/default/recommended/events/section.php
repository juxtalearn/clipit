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
<li class="event">
    <?php echo elgg_view('output/url', array(
        'href'  => "clipit_activity/".$activity->id,
        'title' => $activity->name,
        'text'  => '<div class="circle-activity" style="background: #'.$activity->color.'"></div>',
    ));
    ?>
    <div class="event-section">
        <div>
            <div class="image-block">
                <?php echo elgg_view("recommended/events/author_image", array('author_id' => $author, 'activity' => $activity));?>
            </div>
            <div class="content-block">
                <?php echo elgg_view("recommended/events/author", array('author_id' => $author, 'activity' => $activity));?>
                <i class="fa <?php echo $vars['icon'];?>" style="color: #<?php echo $activity->color;?>;"></i>
                <span style="color: #666;"><?php echo $vars['title'];?></span>
            </div>
        </div>
        <?php if($body = $vars['body']):?>
        <div class="event-details">
            <div class="section">
                <?php echo $body;?>
            </div>
        </div>
        <?php endif; ?>
        <div class="event-date text-right">
            <?php echo elgg_view('output/friendlytime', array('time' => $vars["time_created"]));?>
        </div>
    </div>
</li>
