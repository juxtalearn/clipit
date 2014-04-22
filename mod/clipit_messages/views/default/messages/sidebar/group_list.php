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
 * @package         Clipit
 */
$user_loggedin = elgg_get_logged_in_user_guid();
$user_groups = ClipitUser::get_groups($user_loggedin);

if(!empty($user_groups)):
?>
<h3><?php echo elgg_echo('messages:contactmembersgroup'); ?></h3>
<div class="group-members" id="accordion">
<!-- User group list -->
<?php
    foreach($user_groups as $group_id):
        $group = array_pop(ClipitGroup::get_by_id(array($group_id)));
        $activity_id = ClipitGroup::get_activity($group->id);
        $activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
?>
<div class="group">
    <strong>
    <a class="show text-truncate" style="color: #<?php echo $activity->color; ?>" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $group->id;?>">
        <i class="pull-right fa fa-caret-down"></i> <?php echo $group->name; ?>
    </a>
    </strong>
    <ul class="panel-collapse collapse no-transition members-list" id="collapse<?php echo $group->id;?>">
        <?php
            foreach(ClipitGroup::get_users($group->id) as $user_id):
                if($user_id != $user_loggedin):
                $user = array_pop(ClipitUser::get_by_id(array($user_id)));
                $user_elgg = new ElggUser($user->id);
        ?>
        <li class="text-truncate">
            <?php echo elgg_view("page/components/modal_remote", array('id'=> "send-message-{$user->id}" )); ?>
            <?php echo elgg_view('output/img', array(
                'src' => $user_elgg->getIconURL('tiny'),
                'alt' => $user->name,
                'title' => elgg_echo('profile'),
                'style' => 'margin-right: 10px;',
                'class' => 'pull-left'));
            ?>
            <div class="text-truncate">
                <?php echo elgg_view('output/url', array(
                        'href'  => "ajax/view/modal/messages/send?id=".$user->id,
                        'title' => $user->name,
                        'class' => 'pull-right',
                        'text'  => '<i class="fa fa-envelope"></i>',
                        'data-target' => '#send-message-'.$user->id,
                        'data-toggle' => 'modal'
                    )); ?>
                <?php echo elgg_view('output/url', array(
                    'href'  => "profile/".$user->login,
                    'title' => $user->name,
                    'text'  => $user->name));
                ?>
            </div>
        </li>
        <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</div>
<?php endforeach; ?>
<!-- User group list end-->
</div>
<?php endif; ?>