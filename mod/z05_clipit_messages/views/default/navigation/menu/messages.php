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
$unread_count = ClipitChat::get_inbox_unread($user_id);
?>
<li>
    <a id="messages" role="button" data-toggle="dropdown" href="javascript:;">
        <?php if($unread_count > 0): ?>
            <span class="badge"><?php echo $unread_count; ?></span>
        <?php endif; ?>
        <i class="fa fa-envelope"></i>
    </a>
    <ul id="menu_messages" class="dropdown-menu" role="menu" aria-labelledby="messages">
        <?php echo elgg_view('navigation/menu/message_summary'); ?>
    </ul>
</li>