<?php
/**
 * Footer clipit navigation menu
 *
 */

$items = elgg_extract('menu', $vars);
$class = elgg_extract('class', $vars, false);

/*foreach ($vars['menu'] as $section => $menu_items) {

    echo elgg_view('navigation/menu/elements/section', array(
        'items' => $menu_items,
        'class' => "$class",
        'section' => $section,
        'name' => $vars['name']
    ));
}
*/
$viewer = elgg_get_logged_in_user_entity();
$context = elgg_get_context();
?>
<ul class="<?php echo $class; ?>">
    <li <?php if ($context == "settings") echo "class='open'"; ?>>
        <a title="<?php echo $viewer->name; ?>" class="avatar-user text-truncate" href="<?php echo $CONFIG->wwwroot; ?>profile/<?php echo $viewer->username; ?>">
        <?php echo elgg_view('output/img', array(
            'src' => $viewer->getIconURL('small'),
            'alt' => $viewer->name,
            'title' => elgg_echo('profile'),
            'class' => 'elgg-border-plain elgg-transition',
        )); ?>
        <?php echo $viewer->name; ?>
        </a>
    </li>
    <li class="separator">|</li>
    <li><a href="<?php echo $CONFIG->wwwroot; ?>my_activities">My activities</a></li>
    <li class="separator">|</li>
    <li><a href="<?php echo $url; ?>explore"><?=elgg_echo("Explore");?></a></li>
    <li>
        <a id="notifications" role="button" data-toggle="dropdown" href="javascript:;">
            <span class="badge">10</span>
            <i class="fa fa-bell"></i>
        </a>
        <ul id="menu_notifications" class="dropdown-menu" role="menu" aria-labelledby="notifications">
            <!-- foreach-->
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
            <!-- endforeach -->
        </ul>
    </li>
    <li>
        <a id="messages" role="button" data-toggle="dropdown" href="javascript:;">
            <span class="badge">5</span>
            <i class="fa fa-envelope"></i>
        </a>
        <ul id="menu_messages" class="dropdown-menu" role="menu" aria-labelledby="messages">
            <!-- foreach-->
            <?php for($i=0; $i<=3; $i++){ ?>
            <li role="presentation">
                <a style="padding: 5px 10px;width: 300px;" role="menuitem" tabindex="-1" href="">
                    <img style="float:left;margin-right: 10px;" src="http://juxtalearn.org/sandbox/clipit_befe/_graphics/icons/user/defaultsmall.gif">
                    <div style=" font-size: 13px; text-transform: none; overflow: hidden; letter-spacing: 0;">
                        <button class="btn btn-primary btn-xs" style=" font-size: 12px; line-height: 1.5; border-radius: 3px; padding: 3px 5px; margin-right: 5px; float: right;">
                            <i class="fa fa-user" style=" color: #FFF; font-size: 15px; padding: 0; "></i>
                        </button>
                        <span>Miguel Ángel Gutiérrez</span>
                        <small style="display: block;">12:00H, NOV 18, 2013</small>
                        <div style="color: #333;" class="text-truncate">
                            Duis et ante turpis. Praesent risusligula, porta vitae hendrerit quis
                        </div>
                    </div>
                </a>
            </li>
            <li role="presentation" style="display: block;" class="divider"></li>
            <?php } ?>
            <!-- endforeach -->
        </ul>
    </li>
    <li>
        <a href="<?php echo $CONFIG->wwwroot; ?>action/logout">
            <i style="color: #ff4343;" class="fa fa-power-off"></i>
        </a>
    </li>
</ul>