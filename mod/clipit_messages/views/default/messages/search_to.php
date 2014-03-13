<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   10/03/14
 * Last update:     10/03/14
 *
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, JuxtaLearn Project
 * @version         $Version$
 * @link            http://juxtalearn.org
 * @license         GNU Affero General Public License v3
 *                  (http://www.gnu.org/licenses/agpl-3.0.txt)
 *                  This program is free software: you can redistribute it and/or modify
 *                  it under the terms of the GNU Affero General Public License as
 *                  published by the Free Software Foundation, version 3.
 *                  This program is distributed in the hope that it will be useful,
 *                  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *                  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *                  GNU Affero General Public License for more details.
 *                  You should have received a copy of the GNU Affero General Public License
 *                  along with this program. If not, see
 *                  http://www.gnu.org/licenses/agpl-3.0.txt.
 */
$query = stripslashes(get_input('q', get_input('tag', '')));
$display_query = mb_convert_encoding($query, 'HTML-ENTITIES', 'UTF-8');
$display_query = htmlspecialchars($display_query, ENT_QUOTES, 'UTF-8', false);
// Simulate
$all_users = ClipitUser::get_all();

foreach($all_users as $user){
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
print_r(json_encode($json_output));
?>
