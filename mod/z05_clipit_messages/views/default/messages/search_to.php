<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$query = stripslashes(get_input('q', get_input('tag', '')));

$display_query = mb_convert_encoding($query, 'HTML-ENTITIES', 'UTF-8');
$display_query = htmlspecialchars($display_query, ENT_QUOTES, 'UTF-8', false);
// Simulate
$users = ClipitUser::get_from_search($display_query);
$user_id = $vars['user_id'];
if($user_id){
    $users = ClipitUser::get_by_id(array($user_id));
    $display_query = $users[$user_id]->name;
}

foreach(array_slice($users,0, 10) as $user){
    //if( stripos( $user->name, $display_query )!== false  ||  stripos( $user->login, $display_query )!== false ){
        $user_avatar = get_avatar_url($user,'small');
        $json_output[] = array(
            "id" => $user->id,
            "first_name" => $user->name,
            "username"     => "@".$user->login,
            "avatar" =>  $user_avatar,
        );
    //}
}

echo json_encode($json_output);
?>
