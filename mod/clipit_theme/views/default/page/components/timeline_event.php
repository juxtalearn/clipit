<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 19/02/14
 * Time: 11:38
 * To change this template use File | Settings | File Templates.
 */
$event_title = elgg_extract('title', $vars);
$id_event = elgg_extract('id', $vars);
$event_icon = elgg_extract('icon', $vars);
$color = elgg_extract('color', $vars);
$href = elgg_extract('href', $vars);
$details = elgg_extract('details', $vars);
$time = elgg_extract('time', $vars, true);
$img_details = elgg_extract('img', $vars['details']);
$icon_details = elgg_extract('icon', $vars['details']);
$title_details = elgg_extract('title', $vars['details']);
$sub_title_details = elgg_extract('sub-title', $vars['details']);
$description_details = elgg_extract('description', $vars['details']);

if(isset($icon_details)){
    $icon_details = "<i class='icon fa fa-{$icon_details}'></i>";
}

// Time
$friendly_time = elgg_get_friendly_time($time);
$timestamp = htmlspecialchars(date(elgg_echo('friendlytime:date_format'), $time));
?>
<li class="event" data-event-id="<?php echo $id_event; ?>">
    <div class="circle-activity" style="background: #<?php echo $color; ?>;"></div>
    <div class="event-section">
        <?php if($event_icon){ ?>
        <i class="fa fa-<?php echo $event_icon; ?>" style="color: #<?php echo $color; ?>;"></i>
        <?php } ?>
        <?php
        echo elgg_view('output/url', array(
            'href' => $href,
            'text' => $event_title,
        ));
        ?>
        <?php if($details){ ?>
        <div class="event-details">
            <?php echo $img_details.$icon_details; ?>
            <div class="section">
                <div class="title">
                    <a href=""><?php echo $title_details;?></a>
                </div>
                <?php if($sub_title_details){ ?>
                <div class="sub-title">
                    <?php echo $sub_title_details;?>
                </div>
                <?php if($description_details){ ?>
                <div class="description">
                    <?php echo $description_details;?>
                </div>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
        <?php } ?>
        <abbr class="text-right event-date" title="<?php echo $timestamp; ?>">
            <?php echo $friendly_time;?>
        </abbr>
    </div>
</li>