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
$activities = elgg_extract("activities", $vars);
elgg_load_js("nvd3:d3_v2");
elgg_load_js("nvd3");
elgg_load_css("nvd3:css");
?>
<div class="col-md-4 events-list hidden-xs hidden-sm">
    <?php echo elgg_view('dashboard/module', array(
        'name'      => 'events',
        'title'     => elgg_echo('event:timeline'),
        'content'   => elgg_view('dashboard/modules/events',
            array(
                'events' => ClipitEvent::get_recommended_events(
                    elgg_get_logged_in_user_guid(), 0, 3, get_recommended_relationships()
                )
            )),
    ));
    ?>
</div>

<div class="col-md-8">
    <div class="row">
        <div class="col-md-6">
            <?php echo elgg_view('dashboard/module', array(
                'name'      => 'pending',
                'title'     => elgg_echo('activity:upcoming_tasks'),
                'content'   => elgg_view('dashboard/modules/pending'),
            ));
            ?>
            <?php
            $content = elgg_view('page/components/not_found', array('height' => '245px', 'text' => elgg_echo('activities:active:none')));
            if(!empty($activities)){
                $content = elgg_view('dashboard/modules/group_progress', array(
                    'entities' => $activities
                ));
            }
            echo elgg_view('dashboard/module', array(
                'name'      => 'activity_status',
                'title'     => elgg_echo('my_group:progress'),
                'content'   => $content,
            ));
            ?>
            <?php
            $content = elgg_view('page/components/not_found', array('height' => '245px', 'text' => elgg_echo('activities:active:none')));
            if(!empty($activities)){
                $content = elgg_view('page/components/loading_block', array('height' => '245px', 'text' => elgg_echo('loading:charts')));
                $content = elgg_view('dashboard/modules/activity_groups_status', array(
                    'entities' => $activities
                ));
            }
            echo elgg_view('dashboard/module', array(
                'name'      => 'group_activity',
                'title'     => elgg_echo('group:activity'),
                'content'   => $content,
            ));
            ?>
        </div>
        <div class="col-md-6" style="background: #EBEBEB;">
            <?php
            $open_activities = ClipitActivity::get_all_public();
            $activities = array();
            foreach($open_activities as $activity){
                $index = 0;
                switch($activity->status){
                    case ClipitActivity::STATUS_ENROLL: $index = 0; break;
                    case ClipitActivity::STATUS_ACTIVE: $index = 1; break;
                    case ClipitActivity::STATUS_CLOSED: $index = 2; break;
                }
                $activities[$index][$activity->id] = $activity;
            }
            ksort($activities, SORT_REGULAR );
            $activities = array_flatten($activities);

            if($activities) {
                echo elgg_view('dashboard/module', array(
                    'name' => 'open_activities',
                    'title' => elgg_echo('activities:open'),
                    'content' => elgg_view('dashboard/modules/open_activities', array(
                        'entities' => $activities
                    )),
                ));
            }
            ?>
            <?php echo elgg_view('dashboard/module', array(
                'name'      => 'recommended_videos',
                'title'     => elgg_echo('videos:recommended'),
                'content'   => elgg_view('dashboard/modules/recommended_videos'),
            ));
            ?>
            <?php echo elgg_view('dashboard/module', array(
                'name'      => 'tags',
                'title'     => elgg_echo('tags'),
                'content'   => elgg_view('dashboard/modules/tags'),
            ));
            ?>
        </div>
    </div>
</div>