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

switch($action){
    case "create":
        $user_name = get_input('user-name');
        $user_login = get_input('user-login');
        $user_password = get_input('user-password');
        $user_email = get_input('user-email');
        $users = get_input('user');
        $role = get_input('role');
        foreach($users as $user){
            if(
                trim($user['login']) != "" &&
                trim($user['password']) != "" &&
                trim($user['name']) != "" &&
                filter_var($user['email'], FILTER_VALIDATE_EMAIL)
            ) {
                $user_id = ClipitUser::create(array(
                    'login'     => $user['login'],
                    'password'  => $user['password'],
                    'name'      => $user['name'],
                    'email'     => $user['email'],
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
                    ClipitActivity::add_teachers($activity_id, $users);
                    break;
            }
        }

        echo json_encode($output);
        break;
    case "to_site":
        ClipitActivity::remove_students($activity_id, array($id));
        break;
    case "to_activity":
        ClipitActivity::add_students($activity_id, array($id));
        break;
    case "get_users":
        $role = get_input("role", "student");
        if(!$activity = array_pop(ClipitActivity::get_by_id(array($activity_id)))){
            register_error(elgg_echo("users:cantget"));
        }
        foreach(array_pop(ClipitUser::get_by_role(array($role))) as $user):
            if(!in_array($user->id, $activity->student_array)):
        ?>
            <li data-user="<?php echo $user->id;?>" style="padding: 2px;" class="cursor-pointer list-item-5" value="<?php echo $user->id;?>">
                <?php echo elgg_view('output/img', array(
                    'src' => get_avatar($user, 'small'),
                    'class' => 'avatar-tiny'
                ));
                ?>
                <?php echo $user->name;?>
            </li>
        <?php
            endif;
        endforeach;
        break;
}
