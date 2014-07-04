<?php
/**
 * Footer clipit navigation menu
 *
 */

$items = elgg_extract('menu', $vars);
$class = elgg_extract('class', $vars, false);
$user_id = elgg_get_logged_in_user_guid();
$user = array_pop(ClipitUser::get_by_id(array($user_id)));
$context = elgg_get_context();
?>
<ul class="<?php echo $class; ?>">
    <li>
        <a href="<?php echo elgg_get_site_url(); ?>my_activities"><?php echo elgg_echo("my_activities");?></a>
        <a href="#" data-toggle="dropdown" class="caret-down" style="height: 50px;" id="activities">
            <i class="fa fa-caret-down"></i>
        </a>
        <!-- My activities dropdown menu -->
        <?php echo elgg_view("my_activities/dropdown_menu");?>
    </li>
    <li class="separator">|</li>
    <li><a href="<?php echo elgg_get_site_url(); ?>explore"><?php echo elgg_echo("explore");?></a></li>
    <li class="separator">|</li>
    <!--
    <li>
        <a id="notifications" role="button" data-toggle="dropdown" href="javascript:;">
            <span class="badge">10</span>
            <i class="fa fa-bell"></i>
        </a>
        <ul id="menu_notifications" class="dropdown-menu" role="menu" aria-labelledby="notifications">
            <?php for($i=0; $i<=3; $i++){ ?>
                <li role="presentation">
                    <a style="padding: 5px 10px;width: 300px;" role="menuitem" tabindex="-1" href="">
                        <button class="btn btn-primary btn-xs" style=" font-size: 12px; line-height: 1.5; border-radius: 3px; padding: 3px 5px; margin-right: 5px; float: left;">
                            <i class="fa fa-exclamation-circle" style=" color: #FFF; font-size: 15px; padding: 0; "></i>
                        </button>
                        <div style=" font-size: 13px; text-transform: none; letter-spacing: 0; overflow: hidden;">
                            <div style="color: #333;" class="text-truncate">You must join in activity group</div>
                            <small style="display: block;">12:00H, NOV 18, 2013</small>
                        </div>
                    </a>
                </li>
                <li role="presentation" style="display: block;" class="divider"></li>
            <?php } ?>
        </ul>
    </li>
    -->
    <li>
        <?php echo elgg_view('object/elements/message_icon'); ?>
    </li>
    <li style="margin-left: 10px;" <?php if ($context == "settings") echo "class='open'"; ?>>
        <a title="<?php echo $user->name; ?>" class="avatar-user text-truncate" href="<?php echo elgg_get_site_url(); ?>profile/<?php echo $user->login; ?>">
            <?php echo elgg_view('output/img', array(
                'src' => get_avatar($user, 'small'),
                'alt' => $user->name,
                'title' => elgg_echo('profile'),
                'class' => 'elgg-border-plain elgg-transition avatar-small',
            )); ?>
            <?php echo $user->name; ?>
        </a>
        <a href="#" data-toggle="dropdown" class="caret-down" id="settings">
            <i class="fa fa-caret-down"></i>
        </a>
        <!-- Profile menu -->
        <?php echo elgg_view("profile/dropdown_menu");?>
    </li>
    <li class="separator">|</li>
    <li>
        <a href="<?php echo elgg_get_site_url(); ?>action/logout">
            <i style="color: #ff4343;" class="fa fa-power-off"></i>
        </a>
    </li>
</ul>