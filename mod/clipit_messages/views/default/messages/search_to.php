<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$query = stripslashes(get_input('q', get_input('tag', '')));

$display_query = mb_convert_encoding($query, 'HTML-ENTITIES', 'UTF-8');
$display_query = htmlspecialchars($display_query, ENT_QUOTES, 'UTF-8', false);
// Simulate
$users = ClipitUser::get_all();
$user_id = $vars['user_id'];
if($user_id){
    $users = ClipitUser::get_by_id(array($user_id));
    $display_query = $users[$user_id]->name;
}

foreach($users as $user){
    $user_elgg = new ElggUser($user->id);
    if( stripos( $user->name, $display_query )!== false  ||  stripos( $user->login, $display_query )!== false ){
        $user_avatar = $user_elgg->getIconURL('tiny');
        $json_output[] = array(
            "id" => $user->id,
            "first_name" => $user->name,
            "username"     => "@".$user->login,
            "avatar" =>  $user_avatar,
        );
    }
}

echo json_encode($json_output);
?>
