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
        <?php echo elgg_view('dashboard/module', array(
            'name'      => 'group_activity',
            'title'     => elgg_echo('group:activity'),
            'content'   => elgg_view('dashboard/modules/activity_groups_status',
                array(
                    'entities' => ClipitUser::get_activities($user->id)
                )
            ),
        ));
        ?>
    </div>
    <div class="col-md-6">
        <?php echo elgg_view('dashboard/module', array(
            'name'      => 'activity_admin',
            'title'     => elgg_echo('activity:admin'),
            'content'   => elgg_view('dashboard/modules/activity_admin',
                array(
                    'entities' => ClipitUser::get_activities($user->id)
                )
            ),
        ));
        ?>
    </div>
</div>
