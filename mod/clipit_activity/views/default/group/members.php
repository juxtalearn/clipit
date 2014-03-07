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
    $user = new ElggUser($user->id);
?>
    <div class="col-md-4">
        <div style="border-bottom: 1px solid #bae6f6; padding: 5px;overflow: hidden">
        <?php echo elgg_view('output/img', array(
            'src' => $user->getIconURL('small'),
            'alt' => $user->name,
            'title' => elgg_echo('profile'),
            'style' => 'margin-right: 10px;',
            'class' => 'pull-left'));
        ?>
            <div class="text-truncate">
            <?php echo elgg_view('output/url', array(
                'href'  => "profile/".$user->username,
                'title' => $user->name,
                'text'  => $user->name));
            ?>
                <div class="show">
                    <?php echo elgg_view('output/url', array(
                        'href'  => "message/send/".$user->username,
                        'title' => $user->name,
                        'text'  => '<i class="fa fa-envelope"></i>',
                    )); ?>
                    <small>@<?php echo $user->username; ?></small>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>
    </div>
<?php endif ?>