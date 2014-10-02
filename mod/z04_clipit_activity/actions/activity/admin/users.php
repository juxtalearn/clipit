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
