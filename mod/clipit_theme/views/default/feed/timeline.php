<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$event = elgg_extract("event", $vars);
$author = $event['author'];
$activity = $event['activity'];
$item = $event['item'];
$object = $event['object'];


if($event):
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
            <img src="<?php echo $author["icon"]; ?>" class="pull-left" style="margin-right: 10px;">
            <div style="overflow: hidden">
                <?php echo elgg_view('output/url', array(
                    'href'  => $author["url"],
                    'title' => $author["name"],
                    'text'  => $author["name"],
                    'class' => 'show'
                ));
                ?>
                <i class="fa fa-<?php echo $event['icon'];?>" style=" color: #<?php echo $activity->color; ?>; "></i>
                <span style="color: #666;"><?php echo $event['message'];?></span>
                <?php if(!$item['name'] || !$item['icon']):?>
                    <?php echo elgg_view('output/url', array(
                        'href'  => $object['url'],
                        'title' => $object['name'],
                        'text'  => $object['name'],
                    ));
                    ?>
                <?php endif; ?>
            </div>

        </div>
    <?php
        if($item['description']):
            $description = trim(elgg_strip_tags($item['description']));
            // text truncate max length 90
            if(mb_strlen($description)>90){
                $description = substr($description, 0, 90)."<b>...</b>";
            }
    ?>
    <div class="event-details">
        <?php if($item['icon']): ?>
        <i class="fa fa-file-o fa-<?php echo $item['icon'];?> icon"></i>
        <?php endif; ?>
        <div class="section">
            <div class="title">
                <strong>
                <?php echo elgg_view('output/url', array(
                    'href'  => $item['url'],
                    'title' => $item['name'],
                    'text'  => $item['name'],
                    'class' => 'show'
                ));
                ?>
                </strong>
            </div>
            <div class="description">
                <?php echo $description;?>
            </div>
        </div>
    </div>
<?php endif; ?>
<div class="event-date text-right">
    <?php echo elgg_view('output/friendlytime', array('time' => $event['time']));?>
</div>

</div>
</li>
<?php endif; ?>