<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 17/02/14
 * Time: 17:46
 * To change this template use File | Settings | File Templates.
 */
$activity_id =  (int)elgg_get_page_owner_guid();

$groups_id = ClipitActivity::get_groups($activity_id);
?>

<div class="row">
<?php
foreach($groups_id as $group_id):
    $users_id = ClipitGroup::get_users($group_id);
    $group = array_pop(ClipitGroup::get_by_id(array($group_id)));
?>
    <div class="col-md-6">
        <div style="border-bottom: 6px solid #bae6f6; padding-bottom: 15px;">
            <h2><?php echo $group->name; ?></h2>
            <?php if(count($users_id) > 0): ?>
            <ul style="height: 250px;overflow-y: auto;">
            <?php
            foreach($users_id as $user_id):
                $user = array_pop(ClipitUser::get_by_id(array($user_id)));
                $user = new ElggUser($user->id);
                $params_message = array('text' => '');
                // Other members can send msg
                if($user_id != elgg_get_logged_in_user_guid()){
                    // Remote modal, form content
                    echo elgg_view("page/components/modal_remote", array('id'=> "send-message-{$user_id}" ));
                    $params_message = array(
                        'text'  => '<i class="fa fa-envelope"></i>',
                        'data-target' => '#send-message-'.$user_id,
                        'data-toggle' => 'modal'
                    );
                }
            ?>
                <li style='border-bottom: 1px solid #bae6f6; padding: 5px;' class="text-truncate">
                    <?php echo elgg_view('output/img', array(
                        'src' => $user->getIconURL('tiny'),
                        'alt' => $user->name,
                        'title' => elgg_echo('profile'),
                        'style' => 'margin-right: 10px;',
                        'class' => 'elgg-border-plain elgg-transition'));
                    ?>
                    <?php echo elgg_view('output/url', array(
                        'href'  => "profile/".$user->username,
                        'title' => $user->name,
                        'text'  => $user->name));
                    ?>
                    <div class="pull-right">
                        <small>@<?php echo $user->username; ?></small>
                        &nbsp;
                        <?php echo elgg_view('output/url', array(
                                'href'  => "ajax/view/modal/messages/send?id=".$user_id,
                                'title' => $user->name,

                            ) + $params_message); ?>
                    </div>
                </li>
            <?php endforeach ?>
            </ul>
            <?php endif ?>
        </div>
    </div>
<?php endforeach ?>

</div>
