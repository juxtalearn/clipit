<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 17/02/14
 * Time: 17:46
 * To change this template use File | Settings | File Templates.
 */
$group =  elgg_extract('entity', $vars);
$users_id = ClipitGroup::get_users($group->id);
?>
<?php if(count($users_id) > 0): ?>
   <div class="row">
<?php
foreach($users_id as $user_id):
    $user = array_pop(ClipitUser::get_by_id(array($user_id)));
    $user_elgg = new ElggUser($user->id);
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
    <div class="col-md-4" style="margin-bottom: 10px;">
        <div style="border-bottom: 1px solid #bae6f6; padding: 5px;overflow: hidden">
        <?php echo elgg_view('output/img', array(
            'src' => $user_elgg->getIconURL('small'),
            'alt' => $user->name,
            'title' => elgg_echo('profile'),
            'style' => 'margin-right: 10px;',
            'class' => 'pull-left'));
        ?>
            <div class="text-truncate">

            <?php echo elgg_view_form("group/remove_member" , array('class' => 'pull-right'), array('entity' => $user, 'group' => $group)); ?>

            <?php echo elgg_view('output/url', array(
                'href'  => "profile/".$user->login,
                'title' => $user->name,
                'text'  => $user->name));
            ?>
                <div class="show">
                    <?php echo elgg_view('output/url', array(
                        'href'  => "ajax/view/modal/messages/send?id=".$user_id,
                        'title' => $user->name,

                    ) + $params_message); ?>
                    <small>@<?php echo $user->login; ?></small>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>
    </div>
<?php endif ?>