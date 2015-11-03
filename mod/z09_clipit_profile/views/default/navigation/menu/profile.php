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
$user = array_pop(ClipitUser::get_by_id(array($user_id)));
?>
<li class="separator">|</li>
<li class="margin-left-10 user-profile">
    <?php echo elgg_view('output/url', array(
        'title' => $user->name,
        'href'  => "#",
        'data-toggle' => 'dropdown',
        'id' => 'settings',
        'class' => 'avatar-user text-truncate',
        'text'  => '<i class="fa fa-caret-down pull-right hidden-xs hidden-sm margin-top-10" style="float: right !important;"></i>'.
            elgg_view('output/img', array(
                'src' => get_avatar($user, 'small'),
                'alt' => $user->name,
                'title' => elgg_echo('profile'),
                'class' => 'elgg-border-plain elgg-transition avatar-small',
            ))."<span class='hidden-xs hidden-sm'> ".$user->name."</span>"
    ));
    ?>
    <!-- Profile menu -->
    <ul id="menu_settings" class="dropdown-menu caret-menu" role="menu" aria-labelledby="settings">
        <?php if ($user->role == ClipitUser::ROLE_ADMIN):?>
        <li role="presentation">
            <?php echo elgg_view('output/url', array(
                'href'  => "admin",
                'title' => elgg_echo('admin:page'),
                'text'  => '<i class="fa fa-edit"></i> '.elgg_echo('admin:page'),
            ));
            ?>
        </li>
        <li role="presentation" class="divider"></li>
        <?php endif;?>
        <li role="presentation">
            <?php echo elgg_view('output/url', array(
                'href'  => "profile/".$user->login,
                'title' => elgg_echo('profile:view'),
                'text'  => '<i class="fa fa-user"></i> '.elgg_echo('profile:view'),
            ));
            ?>
        </li>
        <li role="presentation" class="divider"></li>
        <li role="presentation">
            <?php echo elgg_view('output/url', array(
                'href'  => "settings/user",
                'title' => elgg_echo('profile:settings:edit_profile'),
                'text'  => '<i class="fa fa-cog"></i> '.elgg_echo('profile:settings:edit_profile'),
            ));
            ?>
        </li>
        <li role="presentation" class="divider"></li>
        <li>
            <?php echo elgg_view('output/url', array(
                'href'  => "action/logout",
                'class' => 'logout',
                'title' => elgg_echo('user:logout'),
                'text'  => '<i class="fa fa-sign-out"></i> '. elgg_echo('user:logout')
            ));
            ?>
        </li>
    </ul>
</li>