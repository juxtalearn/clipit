<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   7/07/14
 * Last update:     7/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$user_id = elgg_get_logged_in_user_guid();
?>
<li <?php echo elgg_in_context('activities') ? 'class="active"': '';?>>
    <?php echo elgg_view('output/url', array(
        'href'  => "#",
        'data-toggle' => 'dropdown',
        'id' => 'activities',
        'title' => elgg_echo('activities'),
        'text'  => '<i class="fa fa-list-alt visible-xs visible-sm"></i>
                    <i class="fa fa-caret-down pull-right hidden-xs hidden-sm" style="float: right !important;"></i>
                    <span class="hidden-xs hidden-sm">'.elgg_echo('activities'). '</span>'
    ));
    ?>
    <!-- My activities dropdown menu -->
    <ul id="menu_activities" class="dropdown-menu" role="menu" aria-labelledby="activities">
        <?php
        $activities_found = false;
        if($my_activities = ClipitUser::get_activities($user_id)):
            ?>
            <li>
                <a style="border-bottom: 1px solid #EFEFEF;">
                    <small class="show">
                        <?php echo elgg_echo('my_activities:active');?>
                    </small>
                </a>
            </li>
            <?php
            foreach($my_activities as $activity_id):
                $activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
                if($activity->status != ClipitActivity::STATUS_CLOSED):
                    $activities_found = true;
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
                                <small class="show">
                                    <?php echo count($activity->student_array); ?> <?php echo elgg_echo('students');?>
                                </small>
                            </div>
                        </a>
                    </li>
                    <li role="presentation" class="divider"></li>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if(!$activities_found): ?>
            <li role="presentation">
                <a>
                    <small class="show"><?php echo elgg_echo('my_activities:none');?></small>
                </a>
            </li>
            <li role="presentation" class="divider"></li>
        <?php endif;?>
        <li class="options" style="margin-top:0;">
            <?php echo elgg_view('output/url', array(
                'href'  => "create_activity",
                'class' => 'btn btn-primary btn-sm',
                'title' => elgg_echo('activity:create'),
                'text'  => elgg_echo('activity:create'),
            ));
            ?>
            <?php echo elgg_view('output/url', array(
                'href'  => "activities",
                'class' => 'pull-right margin-top-5',
                'title' => elgg_echo('view_all'),
                'text'  => elgg_echo('view_all'),
            ));
            ?>
        </li>
    </ul>
</li>
<li class="separator">|</li>