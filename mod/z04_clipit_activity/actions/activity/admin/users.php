<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   02/10/2014
 * Last update:     02/10/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$action = get_input("act");
$activity_id = get_input("activity_id");
$id = get_input("id");
$role = get_input("role", "student");

switch($action){
    case "create":
        $users = get_input('user');
        foreach($users as $user){
            if(
                trim($user['login']) != "" &&
                trim($user['password']) != "" &&
                trim($user['name']) != ""
            ) {
                $user_id = ClipitUser::create(array(
                    'login'     => $user['login'],
                    'password'  => $user['password'],
                    'name'      => $user['name'],
                    'email'     => filter_var($user['email'], FILTER_VALIDATE_EMAIL),
                    'role'      => $role
                ));
                $output[] = array(
                    'name' => $user['name'],
                    'id' => $user_id,
                );
                $users_added[] = $user_id;
            }
        }
        if(count($users_added) > 0) {
            switch ($role) {
                case ClipitUser::ROLE_STUDENT:
                    ClipitActivity::add_students($activity_id, $users_added);
                    break;
                case ClipitUser::ROLE_TEACHER:
                    ClipitActivity::add_teachers($activity_id, $users_added);
                    break;
            }
        }

        echo json_encode($output);
        break;
    case "to_site":
        ClipitActivity::remove_students($activity_id, array($id));
        break;
    case "to_activity":
        $select_users = get_input('select_users');
        if($id){
            $select_users = array($id);
        }
        switch ($role) {
            case ClipitUser::ROLE_STUDENT:
                ClipitActivity::add_students($activity_id, $select_users);
                break;
            case ClipitUser::ROLE_TEACHER:
                ClipitActivity::add_teachers($activity_id, $select_users);
                break;
        }
        break;
    case "remove_from_activity":
        ClipitActivity::remove_teachers($activity_id, array($id));
        break;
    case "get_users":

        if(!$activity = array_pop(ClipitActivity::get_by_id(array($activity_id)))){
            register_error(elgg_echo("users:cantget"));
        }
        switch($role){
            case ClipitUser::ROLE_TEACHER:
                $users = ClipitActivity::get_teachers($activity->id);
                break;
            case ClipitUser::ROLE_STUDENT:
                $users = ClipitActivity::get_students($activity->id);
                break;
        }
        foreach(array_pop(ClipitUser::get_by_role(array($role))) as $user):
            if(!in_array($user->id, $users)):
                $output[] = array(
                    'id' => $user->id,
                    'avatar' => elgg_view('output/img', array(
                        'src' => get_avatar($user, 'small'),
                        'class' => 'avatar-tiny',
                        'alt' => 'Avatar',
                    )),
                    'name' => $user->name
                );
            endif;
        endforeach;
            echo json_encode($output);
        break;
}
