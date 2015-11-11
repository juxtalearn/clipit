<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$user_loggedin = elgg_get_logged_in_user_guid();
$user_groups = ClipitUser::get_groups($user_loggedin);

if(!empty($user_groups)):
    ?>
    <h4><?php echo elgg_echo('messages:contactmembersgroup'); ?></h4>
    <div class="group-members" id="accordion">
        <!-- User group list -->
        <?php
        foreach($user_groups as $group_id):
            $group = array_pop(ClipitGroup::get_by_id(array($group_id)));
            $activity_id = ClipitGroup::get_activity($group->id);
            $activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
            if($activity->status != ClipitActivity::STATUS_CLOSED):
            ?>
            <div class="group">
                <a class="text-truncate child-decoration-none" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $group->id;?>">
                    <i class="pull-right fa fa-caret-down"></i>
                    <strong><?php echo $group->name; ?></strong>
                    <span class="text-muted text-truncate">
                        <i class="activity-point" style="background: #<?php echo $activity->color; ?>"></i>
                        <?php echo $activity->name;?>
                    </span>
                </a>
                <ul class="panel-collapse collapse no-transition members-list" id="collapse<?php echo $group->id;?>">
                    <?php
                    foreach(ClipitGroup::get_users($group->id) as $user_id):
                        if($user_id != $user_loggedin):
                            $user = array_pop(ClipitUser::get_by_id(array($user_id)));
                            ?>
                            <li class="text-truncate list-item">
                                <?php echo elgg_view("page/elements/user_block", array("entity" => $user));?>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
        <?php endforeach; ?>
        <!-- User group list end-->
    </div>
<?php endif; ?>