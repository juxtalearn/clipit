<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 24/02/14
 * Time: 17:06
 * To change this template use File | Settings | File Templates.
 */
$activity = elgg_extract("entity", $vars);
$groups_id = ClipitActivity::get_groups($activity->id);
$user_owner = elgg_get_logged_in_user_guid();
$user_group = ClipitGroup::get_from_user_activity($user_owner, $activity->id);

if(!$user_group){
    // Create group form
    echo elgg_view_form('group/create', array(), array('entity'  => $activity));
}
$content = '<div class="row">';
foreach($groups_id as $group_id){
    $users_id = ClipitGroup::get_users($group_id);
    $group = array_pop(ClipitGroup::get_by_id(array($group_id)));

    $optGroup = "";
    if(!$user_group){
        $optGroup = "join";
    }elseif($user_group == $group_id){
         $optGroup = "leave";
    }
    if($optGroup){
        $optButton = elgg_view_form('group/'.$optGroup,
            array('class'   => 'pull-right'),
            array('entity'  => $group)
        );
    }


    $content .= '<div class="col-md-6 col-lg-4 group-info"><div style="border-bottom: 6px solid #bae6f6; padding-bottom: 15px; ">';
    // Button group join/leave
    $content .= $optButton;
    $content .= "<h3 class='title-bold'>{$group->name}</h3>";
    if(count($users_id) > 0){
        $content .= '<ul style="height: 150px;overflow-y: auto;" class="member-list">';
        foreach($users_id as $user_id){
            $user = array_pop(ClipitUser::get_by_id(array($user_id)));
            $user_elgg = new ElggUser($user->id);
            $content .= "<li style='border-bottom: 1px solid #bae6f6; padding: 5px;'>";
            $content .= elgg_view('output/img', array(
                'src' => $user_elgg->getIconURL('tiny'),
                'alt' => $user->name,
                'title' => elgg_echo('profile'),
                'style' => 'margin-right: 10px;',
                'class' => 'elgg-border-plain elgg-transition',
            ));
            $content .= elgg_view('output/url', array(
                'href'  => "profile/".$user->login,
                'title' => $user->name,
                'text'  => $user->name,
            ));
            $content .= "</li>";
        }
        $content .= '</ul>';
    }
    $content .= '</div></div>';
}
$content .= '</div>';

echo $content;