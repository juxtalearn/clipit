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
<li <?php echo elgg_in_context('messages_page') ? 'class="active"': '';?>>
    <a id="messages" class="inbox-summary" role="button" data-toggle="dropdown" href="javascript:;" title="<?php echo elgg_echo('messages:inbox');?>">
        <?php if($unread_count > 0): ?>
            <span class="badge"><?php echo $unread_count; ?></span>
        <?php endif; ?>
        <i class="fa fa-envelope"></i>
    </a>
    <ul id="menu_messages" class="dropdown-menu" role="menu" aria-labelledby="messages">
        <li class="loading">
            <a><i class="fa fa-spinner fa-spin"></i> <?php echo elgg_echo('loading');?></a>
        </li>
    </ul>
</li>