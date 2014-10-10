<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   23/07/14
 * Last update:     23/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entities = elgg_extract('entities', $vars);
$activities = ClipitActivity::get_by_id($entities);
$user_id = elgg_get_logged_in_user_guid();
?>
<div class="wrapper separator">
    <?php
    foreach($activities as $activity):
        if($activity->status != 'closed'):
        $group_id = ClipitGroup::get_from_user_activity($user_id, $activity->id);
        $group_object = ClipitSite::lookup($group_id);
        $progress = get_group_progress($group_id);
        if($progress == 0){
            $progress = 5;
        }
        ?>
        <div class="bar" style="max-width:100%;width:<?php echo $progress;?>%;background: #<?php echo $activity->color;?>;">
            <div>
                <h4>
                    <?php echo elgg_view('output/url', array(
                        'href' => "clipit_activity/{$activity->id}",
                        'text' => $activity->name,
                        'title' => $activity->title,
                        'is_trusted' => true,
                    ));
                    ?>
                    <small class="show"><?php echo $group_object['name'];?></small>
                </h4>
            </div>
        </div>
        <?php endif;?>
    <?php endforeach;?>
</div>