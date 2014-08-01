<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   29/07/14
 * Last update:     29/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$groups = elgg_extract('groups', $vars);
?>
<?php
foreach($groups as $group):
    $group_users = ClipitUser::get_by_id($group->user_array, $order_by_name = true);
    $id = uniqid();
    ?>
    <div class="col-md-4 group-list margin-bottom-10">
        <a title="Delete" href="javascript:;" class="pull-right btn btn-xs btn-danger delete-group" rel="nofollow"><i class="fa fa-trash-o"></i></a>
        <input type="text" name="group[<?php echo $id;?>][name]" value="<?php echo $group->name;?>" style="width: 85%;" class="form-control margin-bottom-10">
        <ul class="items-padding">
            <?php foreach($group_users as $group_user):?>
                <li data-user="<?php echo $group_user->id;?>">
                    <?php echo elgg_view('output/url', array(
                        'title' => elgg_echo('delete'),
                        'text' => '<i class="fa fa-trash-o"></i>',
                        'href' => "javascript:;",
                        'style' => 'display:none;',
                        'class' => 'pull-right btn btn-xs btn-danger delete-user',
                    ));
                    ?>
                    <?php echo elgg_view('output/img', array(
                        'src' => get_avatar($group_user, 'small'),
                        'class' => 'image-block avatar-tiny'
                    ));
                    ?>
                    <?php echo $group_user->name;?>
                </li>
            <?php endforeach;?>
            <input type="hidden" class="input-group" name="group[<?php echo $id;?>][id]" value="<?php echo $group->id;?>">
            <input type="hidden" class="input-users" name="group[<?php echo $id;?>][users]" value="<?php echo implode(",", $group->user_array);?>">
            <input type="hidden" class="input-remove-group" name="group[<?php echo $id;?>][remove]">
        </ul>
    </div>
<?php endforeach;?>