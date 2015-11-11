<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   24/07/14
 * Last update:     24/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
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
$activity_ids = ClipitUser::get_activities($user_id, true);
$activities = ClipitActivity::get_by_id($activity_ids);
echo elgg_view("page/components/pending_tasks_activities", array('entities' => $activities));