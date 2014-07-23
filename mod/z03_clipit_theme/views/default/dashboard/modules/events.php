<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   23/07/14
 * Last update:     23/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
?>
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
                if(!$(".module-group_activity").visible(true) && !$(".module-tags").visible(true)){
                    $(".module-pending").addClass('pending-fixed');
                } else {
                    $(".module-pending").removeClass('pending-fixed');
                }
            });

        });
    </script>
    <style>
        .pending-fixed{
            position: fixed;
            top: 50px;
            right: auto;
            left: auto;
            width: 50%;
        }
    </style>
<?php
$user_id = elgg_get_logged_in_user_guid();
$limit = 3;
//    $user_groups = ClipitUser::get_groups($user_id);
//    $user_activities = array();
//    foreach($user_groups as $group) {
//        if($activity_id = ClipitGroup::get_activity($group)) {
//            $user_activities[] = $activity_id;
//        }
//    }
//    $object_array = array_merge($user_groups, $user_activities);
//    return static::get_by_object($object_array, $offset, $limit);
$activities = ClipitUser::get_activities($user_id);
$tasks = array();
foreach($activities as $activity_id){
    $tasks = array_merge($tasks, ClipitActivity::get_tasks($activity_id));
}
$object_array = array_merge($tasks, $activities);
$recommended_events = ClipitEvent::get_by_object($object_array, $limit);

//$recommended_events = ClipitEvent::get_recommended_events($user_id, 0, $limit);
?>
<div class="margin-bar"></div>
<ul class="events">
    <?php foreach ($recommended_events as $event_log):?>
        <?php echo view_recommended_event($event_log);?>
    <?php endforeach;?>
</ul>
<div>
    <?php echo elgg_view('output/url', array(
        'href'  => 'ajax/view/navigation/pagination_timeline?view=full&type=user&offset='.$limit,
        'text'  => 'More',
        'class' => 'events-more-link'
    ));
    ?>
</div>