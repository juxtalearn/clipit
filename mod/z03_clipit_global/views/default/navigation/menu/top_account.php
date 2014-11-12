<?php
/**
 * Footer clipit navigation menu
 *
 */

$items = elgg_extract('menu', $vars);
$class = elgg_extract('class', $vars, false);
?>
<ul class="<?php echo $class; ?>">
    <?php echo elgg_view("navigation/menu/top");?>
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
</ul>