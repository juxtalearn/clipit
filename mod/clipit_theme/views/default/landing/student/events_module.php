<script type="text/javascript">
    (function($){

        /**
         * Copyright 2012, Digital Fusion
         * Licensed under the MIT license.
         * http://teamdf.com/jquery-plugins/license/
         *
         * @author Sam Sehnert
         * @desc A small plugin that checks whether elements are within
         *		 the user visible viewport of a web browser.
         *		 only accounts for vertical position, not horizontal.
         */
        $.fn.visible = function(partial){

            var $t				= $(this),
                $w				= $(window),
                viewTop			= $w.scrollTop(),
                viewBottom		= viewTop + $w.height(),
                _top			= $t.offset().top,
                _bottom			= _top + $t.height(),
                compareTop		= partial === true ? _bottom : _top,
                compareBottom	= partial === true ? _top : _bottom;

            return ((compareBottom <= viewBottom) && (compareTop >= viewTop));
        };

    })(jQuery);

$(document).ready(function() {
    $(window).scroll(function() {
        var isVisible_firstElem = $(".module-group_activity").visible();
        var isVisible_secondElem = $(".module-tags").visible();
        if(!isVisible_firstElem && !isVisible_secondElem){
            if($("#pending-clone").length == 0){
                var pendingClone = $(".module-pending").clone();
                var col = $(".col-md-6:last");
                pendingClone.hide();
                $(pendingClone).insertAfter(col);
                var cloneWrap = pendingClone.wrap('<div class="col-md-12"></div>');
                cloneWrap.attr("id", "pending-clone");
                pendingClone.fadeIn(1000);
            }
        } else {
            if($("#pending-clone").length > 0){
                $("#pending-clone").remove();
            }
        }
    });

});
</script>
<style>
    .stuck {
        position:fixed;
        top:0;
        box-shadow:0 2px 4px rgba(0, 0, 0, .3);
    }

    .events-more-link {
        display:none;
    }
    .events {
        width:480px;
        margin-left:-20px;
        overflow:hidden;
        position:relative;
        opacity: 1;
    }
    .events.events-loading{
        opacity: .6;
    }
    .events.events-loading:after {
        content: "Loading...";
        height: 30px;
        line-height: 29px;
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        text-align: center;
        z-index: 1000;
        border-radius: 3px;
        background: #32b4e5;
        border: 2px solid #fff;
        color: #fff;
        font-weight: bold;
    }
</style>
<?php
$user_id = elgg_get_logged_in_user_guid();
$limit = 5;
$recommended_events = ClipitEvent::get_recommended_events($user_id, 0, $limit);
$content = '<div class="margin-bar"></div> <ul class="events">';
$content .= clipit_student_events($recommended_events);
$content .= '<li><a href="/sandbox/clipit_befe/ajax/view/navigation/pagination_timeline?offset='.$limit.'" class="events-more-link">More</a></li>';
$content .= "</ul>";

echo elgg_view('landing/module', array(
    'name'      => 'events',
    'title'     => "Events",
    'content'   => $content,
));



///**
// * Created by JetBrains PhpStorm.
// * User: equipo
// * Date: 6/02/14
// * Time: 12:37
// * To change this template use File | Settings | File Templates.
// */
//
////////
//
//$items_relationship = array(
//    // Groups
//    'group-user', 'group-file',
//    // Activity
//    'activity-file'
//);
//$user_id = elgg_get_logged_in_user_guid();
//$my_groups = ClipitUser::get_groups($user_id);
//$members_group_list = array();
//foreach($my_groups as $group){
//    $members_group_list = array_merge($members_group_list, ClipitGroup::get_users($group));
//}
//$members_group = array_unique($members_group_list);
//
//$relationships = array();
//foreach($items_relationship as $item_rel){
//    $events_list = ClipitEvent::get_filtered(
//        $event_type = 'create',
//        $user_array = $members_group,
//        $object_id = 0,
//        $object_type = 'relationship',
//        $relation_type = $item_rel
//    );
//    if(!empty($events_list)){
//        $relationships = array_merge($relationships, $events_list);
//    }
//}
//// Array timestamp sort
//$timestamps = array();
//foreach ($relationships as $key => $value) {
//    $timestamps[$key] = $value->time_created;
//}
//array_multisort($timestamps, SORT_DESC, $relationships);
//$relationships = array_slice($relationships, 0, 5); // Array limit
//
//$content = '<div class="margin-bar"></div> <ul class="events">';
//$content .= clipit_student_events($relationships);
//$content .= '<li><a href="/sandbox/clipit_befe/ajax/view/navigation/pagination_timeline?last_id=1548" class="events-more-link">More</a></li>';
//$content .= "</ul>";
//
///*
// * Users added to group
// */
//$events_group = ClipitEvent::get_filtered(
//    $event_type = 'create',
//    $user_array = $members_group,
//    $object_id = 0,
//    $object_type = 'relationship',
//    $relation_type = 'group-user'
//);
//foreach($events_group as $event_group){
//    $relationship = get_relationship($event_group->object_id);
//    $group = ClipitGroup::get_by_id(array($relationship->guid_one));
//    $relationships = array_merge($relationships, array($event_group));
//}
//
///*
// * Files added to group
// */
//$events_file = ClipitEvent::get_filtered(
//    $event_type = 'create',
//    $user_array = $members_group,
//    $object_id = 0,
//    $object_type = 'relationship',
//    $relation_type = 'group-file'
//);
//foreach($events_file as $event_file){
//    $relationship = get_relationship($event_file->object_id);
//    $file = ClipitFile::get_by_id(array($relationship->guid_two));
//    $relationships = array_merge($relationships, array($event_file));
//}
//
//$timestamps = array();
//foreach ($relationships as $key => $value) {
//    $timestamps[$key] = $value->time_created;
//}
//array_multisort($timestamps, SORT_DESC, $relationships);
////print_r($relationships);
//
//
//
//
//echo elgg_view('landing/module', array(
//    'name'      => 'events',
//    'title'     => "Events",
//    'content'   => $content,
//));
//
//
?>