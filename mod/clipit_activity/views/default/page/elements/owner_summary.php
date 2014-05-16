<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   16/05/14
 * Last update:     16/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$owner_id = elgg_extract("owner_id", $vars);
$msg = elgg_extract("msg", $vars);

$object = ClipitSite::lookup($owner_id);
if($object['type'] == 'user'){
    $user = array_pop(ClipitUser::get_by_id(array($owner_id)));
    $output = $msg." ";
    $output .= elgg_view('output/url', array(
        'href'  => "profile/".$user->login,
        'title' => $user->name,
        'text'  => $user->name));
} else {
    switch($object['subtype']){
        case "clipit_group":
            $entity = array_pop(ClipitGroup::get_by_id(array($owner_id)));
            $output = '<a class="btn btn-primary btn-xs">'.$entity->name.'</a>';
            break;
    }
}
echo $output;
?>