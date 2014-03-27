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
?>