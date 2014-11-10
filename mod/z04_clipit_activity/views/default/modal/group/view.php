<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   4/07/14
 * Last update:     4/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$id = (int)get_input("id");
if($group = array_pop(ClipitGroup::get_by_id(array($id)))){
    $users_id = ClipitGroup::get_users($id);
    $body = '<ul style="font-size: 14px;list-style: none;padding: 0;">';
    foreach($users_id as $user_id){
        $user = array_pop(ClipitUser::get_by_id(array($user_id)));
        $body .= '
        <li class="list-item">
            '.elgg_view("page/elements/user_block", array("entity" => $user, 'mail' => false)).'
        </li>';
    }
    $body .='</ul>';
    echo elgg_view("page/components/modal",
        array(
            "dialog_class"     => "modal-md",
            "remote"    => true,
            "target"    => "group-{$group->id}",
            "title"     => $group->name,
            "form"      => false,
            "body"      => $body,
            "footer"    => false
        ));
}