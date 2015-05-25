<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   24/07/14
 * Last update:     24/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$activity = elgg_extract('activity', $vars);
$task = elgg_extract('task', $vars);
$quiz = elgg_extract('quiz', $vars);
$entities_ids = array_keys($entities);
$users = elgg_extract('entities', $vars);
$users = ClipitUser::get_by_id($users);
$groups = ClipitActivity::get_groups($activity->id);
elgg_load_js('jquery:chartjs');
?>
<script>
(function($) {
    $.fn.bootstrapResponsiveTabs = function(options) {

        var settings = $.extend({
            // These are the defaults.
            minTabWidth: "80",
            maxTabWidth: "150"
        }, options );

        // Helper function to debounce window resize events
        var wait_for_repeating_events = (function () {
            var timers = {};
            return function (callback, timeout, timer_name) {
                if (!timer_name) {
                    timer_name = "default timer"; //all calls without a uniqueID are grouped as "default timer"
                }
                if (timers[timer_name]) {
                    clearTimeout(timers[timer_name]);
                }
                timers[timer_name] = setTimeout(callback, timeout);
            };
        })();

        // Helper function to sort tabs base on their original index positions
        var sort_tabs = function ($tabsContainer) {
            var $tabs = $tabsContainer.find(".js-tab");
            $tabs.sort(function(a,b){
                return +a.getAttribute('tab-index') - +b.getAttribute('tab-index');
            });
            $tabsContainer.detach(".js-tab").append($tabs);
        }


        // Main functions for each instantiated responsive tabs
        this.each(function() {

            $container = $(this);

            var ResponsiveTabs;
            ResponsiveTabs = (function () {
                function ResponsiveTabs() {

                    TABS_OBJECT = this;
                    TABS_OBJECT.activeTabId = 1;
                    TABS_OBJECT.tabsHorizontalContainer = $container;

                    TABS_OBJECT.tabsHorizontalContainer.addClass("responsive-tabs").wrap("<div class='responsive-tabs-container clearfix'></div>");

                    // Update tabs
                    var update_tabs = function () {

                        var menuWidth = TABS_OBJECT.tabsHorizontalContainer.width();

                        // Determine which tabs to show/hide
                        var $tabs = TABS_OBJECT.tabsHorizontalContainer.children('li');
                        $tabs.width("100%");

                        var defaultTabWidth = $tabs.first().width();
                        var numTabs = $tabs.length;

                        var numVisibleHorizontalTabs = (Math.floor(menuWidth / defaultTabWidth)) + 1; // Offset by 1 to catch half cut-off tabs
                        var numVisibleVerticalTabs = numTabs - numVisibleHorizontalTabs;

                        for(var i = 0; i < $tabs.length; i++){
                            var horizontalTab = $tabs.eq(i);
                            var tabId = horizontalTab.attr("tab-id");
                            var verticalTab = TABS_OBJECT.tabsVerticalContainer.find(".js-tab[tab-id=" + tabId + "]");
                            var isVisible = i < numVisibleHorizontalTabs;

                            horizontalTab.toggleClass('hidden', !isVisible);
                            verticalTab.toggleClass('hidden', isVisible);
                        }

                        // Set new dynamic width for each tab based on calculation above
                        var tabWidth = 100 / numVisibleHorizontalTabs;
                        var tabPercent = tabWidth + "%";
                        $tabs.width(tabPercent);

                        // Toggle the Tabs dropdown if there are more tabs than can fit in the tabs horizontal container
                        var hasVerticalTabs = (numVisibleVerticalTabs > 0)
                        TABS_OBJECT.tabsVerticalContainer.toggleClass("hidden", !hasVerticalTabs)
                        TABS_OBJECT.tabsVerticalContainer.siblings(".dropdown-toggle").find(".count").text("Tabs " + "(" + numVisibleVerticalTabs + ")");

                        // Make 'active' tab always visible in horizontal container
                        // and hidden in vertical container

                        activeTab = TABS_OBJECT.tabsHorizontalContainer.find(".js-tab[tab-id=" + TABS_OBJECT.activeTabId + "]");
                        activeTabCurrentIndex = activeTab.index();
                        activeTabDefaultIndex = activeTab.attr("tab-index");
                        lastVisibleHorizontalTab = TABS_OBJECT.tabsHorizontalContainer.find(".js-tab:visible").last();
                        lastVisibleTabIndex = lastVisibleHorizontalTab.index()

                        lastHiddenVerticalTab = TABS_OBJECT.tabsVerticalContainer.find(".js-tab.hidden").last();
                        activeVerticalTab = TABS_OBJECT.tabsVerticalContainer.find(".js-tab[tab-index=" + activeTabCurrentIndex + "]");

                        if (activeTabCurrentIndex >= numVisibleHorizontalTabs) {
                            activeTab.insertBefore(lastVisibleHorizontalTab);
                            activeTab.removeClass("hidden");
                            lastVisibleHorizontalTab.addClass("hidden");

                            lastHiddenVerticalTab.removeClass("hidden");
                            activeVerticalTab.addClass("hidden");
                        }

                        if ((activeTabCurrentIndex < activeTabDefaultIndex) && (activeTabCurrentIndex < lastVisibleTabIndex)) {
                            activeTab.insertAfter(lastVisibleHorizontalTab);
                        }
                        console.log(TABS_OBJECT.tabsHorizontalContainer.find('.js-tab').length);
                        console.log(TABS_OBJECT.tabsHorizontalContainer.find('.js-tab.hidden').length);
                        if(TABS_OBJECT.tabsHorizontalContainer.find('.js-tab.hidden').length == 0){
                            console.log('respons');
                            TABS_OBJECT.tabsHorizontalContainer.siblings(".tabs-dropdown").hide();
                        } else{
                            TABS_OBJECT.tabsHorizontalContainer.siblings(".tabs-dropdown").show();
                        }
                    }

                    // SETUP
                    var setup = function () {
                        // Reset all tabs for calc function
                        var totalWidth = 0;
                        var $tabs      = TABS_OBJECT.tabsHorizontalContainer.children('li');

                        // Stop function if there are no tabs in container
                        if ($tabs.length === 0) {
                            return;
                        }

                        // Mark each tab with a 'tab-id' for easy access
                        $tabs.each(function(i) {
                            tabIndex = $(this).index();
                            $(this)
                                .addClass("js-tab")
                                .attr("tab-id", i+1)
                                .attr("tab-index", tabIndex)
                                .find('> a').addClass('text-truncate');
                        });

                        // Attach a dropdown to the right of the tabs bar
                        // This will be toggled if tabs can't fit in a given viewport size

                        TABS_OBJECT.tabsHorizontalContainer.after("<div class='nav navbar-nav navbar-right dropdown tabs-dropdown js-tabs-dropdown'> \
              <a href='#' class='dropdown-toggle' data-toggle='dropdown'><i class='fa fa-ellipsis-h'></i></a> \
              <ul class='dropdown-menu' role='menu'> \
              </ul> \
            </div>");

                        // Clone each tab into the dropdown
                        TABS_OBJECT.tabsVerticalContainer = TABS_OBJECT.tabsHorizontalContainer.siblings(".tabs-dropdown").find(".dropdown-menu");
                        $tabs.clone().appendTo(TABS_OBJECT.tabsVerticalContainer);

                        // Add min and max width to horizontal tabs only
                        $tabs.each(function(i) {
                            $(this)
                                .css("min-width", settings.minTabWidth + "px")
                                .css("max-width", settings.maxTabWidth + "px");
                        });

                        // Update tabs
                        update_tabs();
                    }()


                    /**
                     * Change Tab
                     */
                    change_tab = function (e) {
                        TABS_OBJECT.tabsHorizontalContainer.parents(".responsive-tabs-container").on("click", ".js-tab", function(e) {

                            // Set 'activeTabId' property from clicked tab
                            var target = $(e.target);
                            TABS_OBJECT.activeTabId = $(this).attr("tab-id");

                            // Update tab 'active' class for horizontal container if tab is clicked
                            // from dropdown. Otherwise Bootstrap handles the normal 'active' class placement.
                            var verticalTabSelected = target.parents(".dropdown-menu").length > 0
                            if (verticalTabSelected) {
                                TABS_OBJECT.tabsHorizontalContainer.find(".js-tab").removeClass("active");
                                TABS_OBJECT.tabsHorizontalContainer.find(".js-tab[tab-id=" + TABS_OBJECT.activeTabId + "]").addClass("active");
                            }

                            TABS_OBJECT.tabsVerticalContainer.find(".js-tab").removeClass("active");

                            // Call 'sort_tabs' to re-arrange tabs based on their original index positions
                            // Call 'update_tabs' to resize tabs and determine which one to show/hide
                            sort_tabs(TABS_OBJECT.tabsHorizontalContainer);
                            sort_tabs(TABS_OBJECT.tabsVerticalContainer);
                            update_tabs();
                        });
                    }()

                    // Update tabs on window resize
                    $(window).resize(function() {
                        wait_for_repeating_events(function(){
                            update_tabs();
                        }, 300, "Resize Tabs");
                    });
                }

                return ResponsiveTabs();
            })();
        });
    };
})(jQuery);
</script>
<script>
$(function(){
    $('.nav.nav-tabs').bootstrapResponsiveTabs({
        minTabWidth: 80,
        maxTabWidth: 150
    });
});
</script>
<style>
    .responsive-tabs li.hidden{
        display: none;
    }
    .nav-tabs {
        width: 100%;
        float: left;
    }

    .tabs-dropdown .dropdown-toggle {
        text-align:center;
        font-family: Helvetica,Arial,sans-serif;
        font-size: 15px;
        letter-spacing: 1px;
        color: #9c9e9f;
        background-color: #f7f7f7;
        margin-right: 4px;
    }




.responsive-tabs-container { position: relative; }

.responsive-tabs-container .responsive-tabs { padding-right: 50px; }

.responsive-tabs-container .tabs-dropdown {
    position: absolute;
    right: -4px;
    margin-right: 0 !important;
}

.responsive-tabs-container .tabs-dropdown.navbar-nav { margin: 0 !important; }
@media only screen and (max-width: 767px) {

    .responsive-tabs-container .tabs-dropdown .dropdown-menu {
        right: 0;
        left: auto;
    }

    .responsive-tabs-container .tabs-dropdown .dropdown-menu .dropdown-header {
        position: fixed;
        left: 21px;
        right: 21px;
        background: #FFF;
        margin-top: -50px;
        padding-top: 18px;
        border-radius: 4px 4px 0 0;
    }

    .responsive-tabs-container .tabs-dropdown .dropdown-menu .close {
        position: absolute;
        top: 14px;
        right: 20px;
    }

    .responsive-tabs-container .tabs-dropdown .dropdown-menu .divider { margin: 0; }
}

.responsive-tabs-container .tabs-dropdown .dropdown-toggle {
    width: 50px;
    position: relative;
    display: block;
    padding: 10px 15px;
}

.responsive-tabs-container .tabs-dropdown .dropdown-toggle .count { margin-right: 5px; }

.responsive-tabs-container .tabs-dropdown .dropdown-toggle .caret {
    border-top: 4px solid transparent;
    border-bottom: 4px solid transparent;
    border-left: 6px solid;
    margin-left: 0;
    vertical-align: initial;
}
</style>
<script>
    $(function(){
        $(".show-chart").click(
            {quiz: <?php echo $quiz->id;?>},
            clipit.task.admin.quiz.showChart
        );
        $(".show-data").click(
            {quiz: <?php echo $quiz->id;?>},
            clipit.task.admin.quiz.showData
        );
        $('a[data-toggle="tab"]').on('shown.bs.tab',
            {quiz: <?php echo $quiz->id;?>},
            clipit.task.admin.quiz.onShowTab
        );
        // Start first tab
        $('a[data-toggle="tab"]:first').tab('show');
    });
</script>
<div>
    <small><?php echo elgg_echo('quiz:name');?></small>
    <h4 style="margin-top: 0;"><?php echo $quiz->name;?></h4>
</div>
<hr>
<div role="tabpanel">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation">
            <a href="#students" aria-controls="profile" role="tab" data-toggle="tab"><?php echo elgg_echo('students');?></a>
        </li>
        <?php if($groups):?>
        <li role="presentation">
            <a href="#groups" aria-controls="groups" role="tab" data-toggle="tab"><?php echo elgg_echo('groups');?></a>
        </li>
        <?php endif;?>
        <li role="presentation">
            <a href="#activity" aria-controls="activity" role="tab" data-toggle="tab"><?php echo elgg_echo('activity');?></a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane margin-top-10 active" id="students" style="padding: 10px;">
          <?php
          elgg_push_context('quizstudents');
            $params = array(
            'filter' => '',
            'num_columns' => 1,
            );
            echo "<div class=\"learning_analytics_dashboard\">";
            echo elgg_view_layout('la_widgets_quizresults', $params);
            echo "</div>";
            elgg_pop_context();
            ?>
            <ul>
            <?php
                $students = ClipitUser::get_by_id($activity->student_array);
                foreach($students as $student):
            ?>
                <li class="list-item" data-entity="<?php echo $student->id;?>">
                    <div class="pull-right">
                        <div class="margin-right-10 inline-block status text-muted">
                            <small class="msg-not-finished hidden-xs"></small>
                            <div class="counts " style="display: none;">
                                <span class="answered"></span> -
                                <i class="fa fa-check green"></i> <strong class="a-correct">-</strong>
                            </div>
                        </div>
                        <span class="pull-right">
                            <a href="#questions-<?php echo $student->id;?>"
                               class="show-data btn-primary btn btn-xs btn-icon fa-list fa btn-border-blue"
                               data-type="student"
                               data-entity-type="questions"
                               data-toggle="collapse"
                                ></a>
                            <a href="#chart-<?php echo $student->id;?>"
                               class="show-data margin-left-10 btn-icon btn-border-blue btn btn-xs fa fa-bar-chart-o"
                               data-toggle="collapse"
                               data-type="student"
                               data-entity-type="chart"
                               aria-expanded="false"
                                ></a>
                        </span>
                    </div>
                    <?php echo elgg_view("page/elements/user_block", array("entity" => $student)); ?>
                    <div class="clearfix"></div>
                    <div>
                        <div class="collapse margin-top-10 chart" style="margin-left: 35px;" id="chart-<?php echo $student->id;?>"></div>
                        <div class="collapse margin-top-10 questions" id="questions-<?php echo $student->id;?>"></div>
                    </div>
                </li>
            <?php endforeach;?>
            </ul>
        </div>
        <?php if($groups):?>
        <div role="tabpanel" class="tab-pane margin-top-10" id="groups" style="padding: 10px;">
            <?php
            elgg_push_context('quizgroups');
            $params = array(
                'filter' => '',
                'num_columns' => 1,
            );
            echo "<div class=\"learning_analytics_dashboard\">";
            echo elgg_view_layout('la_widgets_quizresults', $params);
            echo "</div>";
            elgg_pop_context();
            ?>
            <ul>
                <?php
                $groups = ClipitGroup::get_by_id($groups);
                natural_sort_properties($groups, 'name');
                foreach($groups as $group):
                ?>
                <li class="list-item" data-entity="<?php echo $group->id;?>">
                    <div class="pull-right">
                        <div class="margin-right-10 inline-block status text-muted">
                            <small class="msg-not-finished hidden-xs"></small>
                            <div class="counts " style="display: none;">
                                <span class="answered"></span> -
                                <i class="fa fa-check green"></i> <strong class="a-correct">-</strong>
                            </div>
                        </div>
                        <span class="pull-right">
                            <a href="#questions-<?php echo $group->id;?>"
                               class="show-data btn-primary btn btn-xs btn-icon fa-list fa btn-border-blue"
                               data-type="group"
                               data-entity-type="questions"
                               data-toggle="collapse"
                                ></a>
                            <a href="#chart-<?php echo $group->id;?>"
                               class="show-data margin-left-10 btn-icon btn-border-blue btn btn-xs fa fa-bar-chart-o"
                               data-toggle="collapse"
                               data-type="group"
                               data-entity-type="chart"
                               aria-expanded="false"></a>
                        </span>
                    </div>
                    <?php
                        echo elgg_view("page/components/modal_remote", array('id'=> "group-{$group->id}" ));
                        echo elgg_view('output/url', array(
                            'href'  => "ajax/view/modal/group/view?id={$group->id}",
                            'text'  => '<i class="fa fa-users"></i> '.$group->name,
                            'title' => $group->name,
                            'data-toggle'   => 'modal',
                            'data-target'   => '#group-'.$group->id
                        ));
                    ?>
                    <small class="show">
                        <?php echo count($group->user_array);?> <?php echo elgg_echo('students');?>
                    </small>
                    <div class="clearfix"></div>
                    <div>
                        <div class="collapse margin-top-10 chart" style="margin-left: 35px;" id="chart-<?php echo $group->id;?>"></div>
                        <div class="collapse margin-top-10 questions" id="questions-<?php echo $group->id;?>"></div>
                    </div>
                </li>
                <?php endforeach;?>
            </ul>
        </div>
        <?php endif;?>
        <div role="tabpanel" class="tab-pane margin-top-10" id="activity" style="padding: 10px;">
            <?php
            elgg_push_context('quizactivity');
            $params = array(
                'filter' => '',
                'num_columns' => 1, 
            );
            echo "<div class=\"learning_analytics_dashboard\">";
            echo elgg_view_layout('la_widgets_quizresults', $params);
            echo "</div>";
            elgg_pop_context();
            ?>
            <ul>
                <li data-entity="<?php echo $activity->id;?>">
                <a href="#questions-<?php echo $activity->id;?>"
                   class="show-data btn-primary btn btn-xs btn-icon btn-border-blue"
                   data-type="activity"
                   data-entity-type="questions"
                   data-toggle="collapse"
                    ><i class="fa-list fa"></i> <?php echo elgg_echo('quiz:questions');?></a>
                <a href="#chart-<?php echo $activity->id;?>"
                   class="show-data margin-left-10 btn-primary btn btn-xs btn-icon btn-border-blue"
                   data-toggle="collapse"
                   data-type="activity"
                   data-entity-type="chart"
                   aria-expanded="false"><i class="fa-bar-chart-o fa"></i> <?php echo elgg_echo('stats');?></a>
                <div>
                    <div class="collapse margin-top-10 chart" style="margin-left: 35px;" id="chart-<?php echo $activity->id;?>"></div>
                    <div class="collapse margin-top-10 questions" id="questions-<?php echo $activity->id;?>"></div>
                </div>
                </li>
            </ul>
        </div>
    </div>

</div>

<div>
<!--    --><?php //echo elgg_view('widgets/quizresult/content');?>
</div>
