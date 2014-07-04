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
$recommended_events = ClipitEvent::get_recommended_events($user_id, 0, $limit);
$content = '<div class="margin-bar"></div> <ul class="events">';
foreach ($recommended_events as $event_log){
    $content .= view_recommended_event($event_log);
}
$content .= "</ul>";
$content .= "<div>";
$content .= elgg_view('output/url', array(
    'href'  => 'ajax/view/navigation/pagination_timeline?view=full&type=user&offset='.$limit,
    'text'  => 'More',
    'class' => 'events-more-link'
));
$content .= "</div>";
echo elgg_view('landing/module', array(
    'name'      => 'events',
    'title'     => "Events",
    'content'   => $content,
));

?>