<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   29/05/14
 * Last update:     29/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$activity = elgg_extract('activity', $vars);
$author_id = elgg_extract('author_id', $vars);
$object = ClipitSite::lookup($author_id);

switch($object['subtype']){
    case "ClipitGroup":
        $hasGroup = ClipitGroup::get_from_user_activity(elgg_get_logged_in_user_guid(), $activity->id);
        if($hasGroup == $author_id){
            echo elgg_view('output/url', array(
                'href'  => "clipit_activity/".$activity->id."/group/".$hasGroup,
                'title' => $object['name'],
                'class' => 'show text-truncate',
                'text'  => $object['name'],
            ));
        } else {
            echo "<span class='show'>{$object[name]}</span>";
        }
        break;
    case "ClipitActivity":
        echo elgg_view('output/url', array(
            'href'  => "clipit_activity/".$author_id,
            'title' => $object['name'],
            'class' => 'show text-truncate',
            'text'  => $object['name'],
        ));
        break;
}
if($object['type'] == 'user'){
    $user = array_pop(ClipitUser::get_by_id(array($author_id)));
    echo elgg_view('output/url', array(
        'href'  => "profile/".$user->login,
        'title' => $user->name,
        'class' => 'show text-truncate event-author',
        'text'  => $user->name,
    ));
}