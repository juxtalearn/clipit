<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   7/07/14
 * Last update:     7/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$user_id = elgg_get_logged_in_user_guid();
?>
<li <?php echo elgg_in_context('activities') ? 'class="active"': '';?>>
    <?php echo elgg_view('output/url', array(
        'href'  => "#",
        'data-toggle' => 'dropdown',
        'id' => 'my_activities',
        'title' => elgg_echo('activities'),
        'text'  => '<i class="fa fa-list-alt visible-xs visible-sm"></i>
                    <i class="fa fa-caret-down pull-right hidden-xs hidden-sm" style="float: right !important;"></i>
                    <span class="hidden-xs hidden-sm">'.elgg_echo('activities'). '</span>'
    ));
    ?>
    <!-- My activities dropdown menu -->
    <ul id="menu_activities" class="dropdown-menu" role="menu" aria-labelledby="activities">
        <li style="border-bottom: 1px solid #EFEFEF;padding: 5px 10px;">
            <small>
                <?php echo elgg_view('output/url', array(
                    'href'  => "activities",
                    'class'  => 'pull-right',
                    'title' => elgg_echo('view_all'),
                    'text'  => elgg_echo('view_all'),
                ));
                ?>
                <?php echo elgg_echo('my_activities:active');?>
            </small>
        </li>
    <?php
    $activities_found = false;
    if($my_activities = ClipitUser::get_activities($user_id)):
        foreach($my_activities as $activity_id):
        $activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
        if($activity->status != 'closed'):
            $activities_found = true;
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
    <?php endif; ?>
    <?php if(!$activities_found): ?>
        <li style="padding: 5px 10px;">
            <small>
                <strong><?php echo elgg_echo('my_activities:none');?></strong>
            </small>
        </li>
    <?php endif;?>
    </ul>
</li>
<li class="separator">|</li>