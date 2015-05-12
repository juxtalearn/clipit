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
$user = elgg_extract("entity", $vars);
$activities = elgg_extract("activities", $vars);
elgg_load_js("nvd3:d3_v2");
elgg_load_js("nvd3");
elgg_load_css("nvd3:css");
?>
<div class="col-md-4 events-list" style="padding-right: 15px;">
    <?php echo elgg_view('dashboard/module', array(
        'name'      => 'events',
        'title'     => elgg_echo('event:timeline'),
        'content'   => elgg_view('dashboard/modules/events',
            array(
                'entity' => $user
            )
        ),
    ));
    ?>
</div>

<div class="col-md-8">
    <div class="row">
        <div class="col-md-6">
            <?php
            $content = elgg_view('page/components/not_found', array('height' => '245px', 'text' => elgg_echo('activities:active:none')));
            if(!empty($activities)){
                $content = elgg_view('dashboard/modules/activity_status_progress', array(
                    'entities' => $activities
                ));
            }
            ?>
            <?php echo elgg_view('dashboard/module', array(
                'name'      => 'activity_status',
                'title'     => elgg_echo('activity:status'),
                'content'   => $content,
            ));
            ?>
        </div>
        <div class="col-md-6">
            <?php
            if(!empty($activities)){
                echo elgg_view('dashboard/module', array(
                    'name'      => 'group_activity',
                    'title'     => elgg_echo('group:activity'),
                    'content'   => $content = elgg_view('dashboard/modules/activity_groups_status', array(
                        'entities' => $activities
                    )),
                ));
            } else {
                echo elgg_view('dashboard/module', array(
                    'name'      => 'group_activity_none',
                    'title'     => elgg_echo('group:activity'),
                    'content'   => elgg_view('page/components/not_found', array('height' => '245px', 'text' => elgg_echo('activities:active:none'))),
                ));
            }
            ?>
        </div>
    </div>
</div>
