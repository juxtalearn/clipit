<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   25/04/14
 * Last update:     25/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$messages = elgg_extract('entity', $vars);
$items = array();
foreach($messages as $message){
    $user = array_pop(ClipitUser::get_by_id(array($message->owner_id)));
    $user_elgg = new ElggUser($message->owner_id);

    $message->description = trim(elgg_strip_tags($message->description));
    // Message text truncate max length 50
    if(mb_strlen($message->description) > 50){
        $message->description = substr($message->description, 0, 50)."...";
    }
    // Options
    $move_msg_url = "action/messages/list?set-option=to_inbox&check-msg[]={$message->id}";
    $message->option = array(
        elgg_view('output/url', array(
            'href'  => elgg_add_action_tokens_to_url($move_msg_url, true),
            'title' => elgg_echo("message:movetoinbox"),
            'style' => 'padding: 3px 9px;',
            'text'  => '<i class="fa fa-check"></i> '.elgg_echo("message:movetoinbox"),
            'class' => 'btn btn-success-o btn-xs',
        ))
    );
    $check_msg = '<input type="checkbox" name="check-msg[]" value="'.$message->owner_id.'" class="select-simple">';
    $text_user_from = $user->name;
    if($message->owner_id == $user_logged_in){
        $text_user_from = "<strong>".elgg_echo("me")."</strong>";
    }
    $user_data = '<img src="'.$user_elgg->getIconURL("tiny").'">';
    $user_data .= elgg_view('output/url', array(
        'href'  => "profile/".$user->login,
        'title' => $user->name,
        'text'  => $text_user_from));
    $item = array(
        $check_msg,
        array(
            'item_class' => 'user-avatar',
            ''
        ),
        $message->description,
        implode("", $message->option)
    );
    $items = array_merge($items, array($item));
}
echo elgg_view("messages/list/section", array('items' => $items));
?>
