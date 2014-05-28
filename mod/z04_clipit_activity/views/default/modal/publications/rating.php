<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   21/05/14
 * Last update:     21/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$id = (int)get_input("id");
$by_target_id = (int)get_input("by_target");

if($rating = array_pop(ClipitRating::get_by_id(array($id)))){
    $body = elgg_view('publications/rating_full', array('entity'  => $rating));
    $user = array_pop(ClipitUser::get_by_id(array($rating->owner_id)));
    echo elgg_view("page/components/modal",
        array(
            "dialog_class"     => "modal-lg",
            "remote"    => true,
            "target"    => "rating-average-{$rating->id}",
            "title"     => elgg_echo("publications:rating:name", array("@".$user->login)),
            "form"      => false,
            "body"      => $body,
            "footer"    => false
        ));

} elseif($rating_target = array_pop(ClipitRating::get_by_target(array($by_target_id)))){
    $activity_id = (int)get_input("activiy_id");
    $body = elgg_view('publications/rating_list', array('entity'  => $rating_target, 'activity_id' => $activity_id));
    echo elgg_view("page/components/modal",
        array(
            "dialog_class"     => "modal-lg",
            "remote"    => true,
            "target"    => "rating-list-{$rating_target->id}",
            "title"     => elgg_echo("publications:rating:list"),
            "form"      => false,
            "body"      => $body,
            "footer"    => false
        ));
}