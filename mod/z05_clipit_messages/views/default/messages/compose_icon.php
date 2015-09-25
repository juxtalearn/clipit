<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   9/05/14
 * Last update:     9/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$user = elgg_extract("entity", $vars);

$params_message = array('text' => '');
// Other members can send msg
if($user->id != elgg_get_logged_in_user_guid()){
    // Remote modal, form content
    echo elgg_view("page/components/modal_remote", array('id'=> "send-message-{$user->id}" ));
    $params_message = array(
        'aria-hidden' => 'true',
        'text'  => '<i class="fa fa-envelope" style="border-right: 1px solid #C9C9C9;padding-right: 5px;"></i>'. $vars['text'],
        'data-target' => '#send-message-'.$user->id,
        'data-toggle' => 'modal',
        'class' => $vars['class'] ? $vars['class'] : false,
    );
}
echo elgg_view('output/url', array(
        'href'  => "ajax/view/modal/messages/send?id=".$user->id,
        'title' => elgg_echo('message:send'),

    ) + $params_message); ?>