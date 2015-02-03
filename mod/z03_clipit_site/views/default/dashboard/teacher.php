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
elgg_load_js("nvd3:d3_v2");
elgg_load_js("nvd3");
elgg_load_css("nvd3:css");

$activities = ClipitUser::get_activities($user->id);
$activities = ClipitActivity::get_by_id($activities);
$active_activities = array();
foreach($activities as $activity){
    if($activity->status != 'closed'){
        $active_activities[] = $activity;
    }
}
?>
<div class="col-md-4 events-list">
    <?php echo elgg_view('dashboard/module', array(
        'name'      => 'events',
        'title'     => '',
        'content'   => elgg_view('dashboard/modules/events',
            array(
                'entity' => $user
            )
        ),
    ));
    ?>
</div>

<div class="col-md-8">
    <div class="col-md-6">
        <?php if(!empty($active_activities)):?>
            <?php echo elgg_view('dashboard/module', array(
                'name'      => 'activity_status',
                'title'     => elgg_echo('activity:status'),
                'content'   => elgg_view('dashboard/modules/activity_status', array(
                    'entities' => $active_activities
                )),
            ));
            ?>
        <?php endif;?>
        <?php
        if(!empty($active_activities)){
            echo elgg_view('dashboard/module', array(
                'name'      => 'group_activity',
                'title'     => elgg_echo('group:activity'),
                'content'   => elgg_view('page/components/loading_block', array('height' => '245px', 'text' => elgg_echo('loading:charts'))),
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
    <div class="col-md-6">
        <?php
        $content = elgg_view('page/components/not_found', array('height' => '245px', 'text' => elgg_echo('activities:active:none')));
        if(!empty($active_activities)){
            $content = elgg_view('dashboard/modules/activity_admin',
                array(
                    'entities' => $active_activities
                )
            );
        }
        ?>
        <?php echo elgg_view('dashboard/module', array(
            'name'      => 'activity_admin',
            'title'     => elgg_echo('activity:overview'),
            'content'   => $content,
        ));
        ?>
    </div>
</div>
