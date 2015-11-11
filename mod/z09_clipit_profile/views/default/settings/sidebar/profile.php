<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   18/06/14
 * Last update:     18/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$user_id = elgg_get_page_owner_guid();
$user = array_pop(ClipitUser::get_by_id(array($user_id)));
$body = elgg_view('output/img', array(
    'src' => get_avatar($user, 'small'),
    'class' => 'image-block avatar-small'
));
$body .= '<div class="content-block">
            <h3 class="text-truncate">';
                $body .= elgg_view('output/url', array(
                    'href' => "profile/{$user->login}",
                    'text' => $user->name
                ));
$body .= '
            </h3>
        </div>';
$body .= '<small class="show">@'.$user->login.'</small>';

echo elgg_view_module('aside', '', $body, array('class' => 'activity-group-block margin-bottom-10'));
?>

