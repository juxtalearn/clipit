<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   18/06/14
 * Last update:     18/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$user_id = elgg_get_logged_in_user_guid();
?>
<ul id="menu_activities" class="dropdown-menu" role="menu" aria-labelledby="activities">
<?php
foreach($my_activities = ClipitUser::get_activities($user_id) as $activity_id):
    $activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
    if($activity->status != 'closed'):
        $group_id = ClipitGroup::get_from_user_activity($user_id, $activity_id);
        $group = array_pop(ClipitGroup::get_by_id(array($group_id)));
        ?>
        <li role="presentation">
            <a role="menuitem" tabindex="-1" href="<?php echo elgg_get_site_url();?>clipit_activity/<?php echo $activity_id;?>">
                <div class="image-block">
                    <span class="activity-point" style="background: #<?php echo $activity->color;?>"></span>
                </div>
                <div class="content-block">
                    <div class="text-truncate blue">
                        <span><?php echo $activity->name; ?></span>
                    </div>
                    <?php if($group_id): ?>
                        <small class="show"><?php echo $group->name; ?></small>
                    <?php endif; ?>
                </div>
            </a>
        </li>
        <li role="presentation" class="divider"></li>
    <?php endif; ?>
<?php endforeach; ?>
</ul>