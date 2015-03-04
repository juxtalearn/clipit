<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   9/07/14
 * Last update:     9/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$file = $_FILES['upload-users'];
$activity_id = get_input('entity-id');
$output = array();

$outputSSSSSSSS = array(
    array(
        'id' => 4306, 'name' => 'Miguel', 'group' => 'Los chungitos'
    ),
    array(
        'id' => 30046, 'name' => 'Miguel 2', 'group' => 'Los chungitos'
    ),
    array(
        'id' => 30050, 'name' => 'Miguel 3', 'group' => 'Los manolos'
    ),
    array(
        'id' => 40044, 'name' => 'Miguel 4', 'group' => 'Los manolos'
    ),
    array(
        'id' => 55007, 'name' => 'Miguel 5', 'group' => 'Los gutierrez'
    ),
    array(
        'id' => 55006, 'name' => 'Miguel 6', 'group' => 'Los gutierrez'
    ),
    array(
        'id' => 44007, 'name' => 'Miguel 7', 'group' => 'Los martinez'
    ),
    array(
        'id' => 47006, 'name' => 'Miguel 8', 'group' => 'Los martinez'
    )
);

//echo json_encode(array(array('name'=>'JOSE', 'id' => 4077), array('name'=>'MANUEL', 'id' => 4508)));
//echo json_encode($output);
//die;
$groups = ClipitUser::import_data($file['tmp_name']);
$output = array();
foreach($groups as $group_name => $users){
    foreach($users as $user_id){
        $user = array_pop(ClipitUser::get_by_id(array($user_id)));
        if($user->role == ClipitUser::ROLE_STUDENT) {
            $output[] = array(
                'name' => $user->name,
                'id' => $user->id,
                'group' => $group_name
            );
        }
        if($activity_id){
            ClipitActivity::add_students($activity_id, array($user->id));
        }
    }
}
//foreach($users as $user_id){
//    $user = array_pop(ClipitUser::get_by_id(array($user_id)));
//    if($user->role == ClipitUser::ROLE_STUDENT) {
//        $output[] = array(
//            'name' => $user->name,
//            'id' => $user->id
//        );
//    }
//    if($activity_id){
//        ClipitActivity::add_students($activity_id, array($user->id));
//    }
//}

echo json_encode($output);
die();