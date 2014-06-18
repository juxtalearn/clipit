<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   18/06/14
 * Last update:     18/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$user_id = elgg_get_logged_in_user_guid();
$user = array_pop(ClipitUser::get_by_id(array($user_id)));
$user_elgg = new ElggUser($user_id);
$body = elgg_view('output/img', array(
    'src' => $user_elgg->getIconURL('small'),
    'class' => 'image-block'
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

echo elgg_view_module('aside', '', $body, array('class' => 'activity-group-block'));
?>

