<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   23/07/14
 * Last update:     23/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$activities = elgg_extract('entities', $vars);
?>
<div class="wrapper separator">
<?php
$activities_found = false;
foreach($activities as $activity):
    if($activity->status != 'closed'):
        $activity_progress = round(((time() - $activity->start)/($activity->end - $activity->start)) * 100);
        if($activity_progress == 0){
            $activity_progress = 5;
        }
?>
    <div class="bar" style="height: 35px;line-height: 35px;max-width:100%;width:<?php echo $activity_progress;?>%;background: #<?php echo $activity->color;?>;">
        <div>
            <h4>
             <?php echo elgg_view('output/url', array(
                    'href' => "clipit_activity/{$activity->id}",
                    'text' => $activity->name,
                    'title' => $activity->title,
                    'is_trusted' => true,
                    'name' => elgg_echo('activity:number'),
                ));
             ?>
            </h4>
        </div>
    </div>
    <?php endif;?>
<?php endforeach;?>
</div>