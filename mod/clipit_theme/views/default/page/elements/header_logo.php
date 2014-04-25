<?php
/*
 * Project Name:            ClipIt Theme
 * Project Description:     Theme for Elgg 1.8
 */
$url = $CONFIG->url;
$username = elgg_get_logged_in_user_entity()->username;
$context = elgg_get_context();
$messages = messages_count_unread();
?>

<div class="elgg-heading-logo">
    <img src="<?=$url?>mod/clipit/graphics/clipit.png"/> 
</div>
<div class="span8 pull-right">
    <ul class="nav nav-pills pull-right">
        <?php if (elgg_is_logged_in()) { ?>
            <li <?php if ($context == "messages") echo "class='active'"; ?>><a href="<?php echo $url; ?>messages/inbox/<?php echo $username; ?>"><text style="color:#f00;"><?php echo $messages; ?></text> <?=elgg_echo("messages");?></a></li>
            <li <?php if ($context == "profile") echo "class='active'"; ?>><a href="<?php echo $url; ?>profile/<?php echo $username; ?>"><?=elgg_echo("profile");?></a></li>
            <li <?php if ($context == "settings") echo "class='active'"; ?>><a href="<?php echo $url; ?>settings/user/<?php echo $username; ?>"><?=elgg_echo("settings");?></a></li>
            <li><a href="<?php echo $url; ?>action/logout"><?=elgg_echo("logout");?></a></li>
            <?php if (elgg_is_admin_logged_in()) { ?>
                <li><a href="<?php echo $CONFIG->url; ?>admin"><?=elgg_echo("admin");?></a></li>
            <?php } ?>
        <?php } else { ?>
            <!--
            <li><a class="socia_login" href="<?php echo $CONFIG->url; ?>login"><?=elgg_echo("login");?></a></li>
            <li><a class="socia_register" href="<?php echo $CONFIG->url; ?>register"><?=elgg_echo("register");?></a></li>
            -->
            <li><a href="<?=$url?>"><?=elgg_echo("back");?></a></li>
            <?php } ?>
    </ul>
</div>

<script>
    (function() {
        $(".elgg-heading-logo").click(function() {
            window.location = elgg.config.wwwroot;
        });
    })();
</script>