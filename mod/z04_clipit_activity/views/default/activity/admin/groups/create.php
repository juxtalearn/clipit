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
$users = elgg_extract('users', $vars);
$activity = elgg_extract('activity', $vars);
$groups = elgg_extract('groups', $vars);
?>
<script>
$(function(){
    $(".upload-users").fileupload({
        maxFileSize: 500000000, // 500 MB
        url: "<?php echo elgg_add_action_tokens_to_url("action/activity/create/add_users_upload", true);?>",
        acceptFileTypes: /(\.|\/)(xlsx|xls)$/i,
        autoUpload: true,
        previewCrop: false
    }).on('fileuploadadd', function (e, data) {
        var alertOptions = {
            title: elgg.echo(elgg.echo('loading')+"..."),
            buttons: {
                ok: {
                    className: "hide"
                }
            },
            message: elgg.echo('called:students:add_from_excel:waiting')
        };
        bootbox.alert(alertOptions);
    }).on('fileuploadstop', function (e, data) {
//        $('.bootbox').modal('hide');
    }).on('fileuploadprocessalways', function (e, data) {
        var messages_content = $(".upload-messages");
        var index = data.index,
            file = data.files[index],
            node = messages_content;
        if (file.error) {
            node.html($('<span class="text-danger"/>').text(file.error));
        }
    }).on('fileuploaddone', function (e, data) {
        var parent_id = $(this).parent("a").attr("id"),
            has_group = false,
            count = 0,
            result_count = Object.keys(data.result).length;
        $.each(data.result, function(group, users) {
            if(group != 0) {
                has_group = true;
            }
            $.each(users, function (i, user) {
                $('#called_users').multiSelect('addOption',
                    {value: user.id, text: user.name, index: 0}
                );
            });
            count++;
            if(count == result_count) {
                $('#called_users').multiSelect('refresh');
                if (has_group) {
                    $("#groups_default").val(JSON.stringify(data.result));
                    $("#save-groups").click();
                } else{
                    $('.bootbox').modal('hide');
                }
            }
        });
    });
});
</script>
<?php echo elgg_view("multimedia/file/templates/attach"); ?>
<select id="called_users" name="called_users[]" multiple="multiple">
    <?php
    foreach($users as $user):
        if(!ClipitGroup::get_from_user_activity($user->id, $activity->id)):
    ?>
            <option class="activity_users" value="<?php echo $user->id;?>">
                <?php echo $user->name;?>
            </option>
    <?php else:
            $group_students[] = $user;
        endif;
    endforeach;
    ?>
    <?php foreach($group_students as $group_student):?>
        <option class="activity_users" value="<?php echo $group_student->id;?>" disabled>
            <?php echo $group_student->name;?>
        </option>
    <?php endforeach;?>
</select>
<?php echo elgg_view("input/hidden", array(
    'name' => "entity-id",
    'value' => $activity->id,
));
?>
<div class="row margin-top-10">
    <div class="col-md-6 form-group">
        <!-- Add students -->
        <?php echo elgg_view('activity/admin/groups/add_students', array('entity' => $activity));?>
        <!-- Add students end -->

    </div>
    <div class="col-md-6 text-right">
        <i class="fa fa-spinner fa-spin blue margin-right-10" id="move-loading" style="display: none;"></i>
        <select class="form-control" id="move-group" style="display: inline-block;width: auto;padding: 2px;">
            <option value=""><?php echo elgg_echo('groups:select:move');?></option>
            <?php foreach($groups as $group):?>
                <option value="<?php echo $group->id;?>">
                    <?php echo $group->name;?>
                </option>
            <?php endforeach;?>
        </select>
        <div style="display: inline-block;text-transform: uppercase;margin: 0 10px;" class="text-muted">
            <i class="fa fa-minus"></i> <?php echo elgg_echo('clipit:or');?> <i class="fa fa-minus"></i>
        </div>
        <?php echo elgg_view('input/button',
            array(
                'id'    => 'create',
                'value' => elgg_echo('create'),
                'class' => "btn btn-primary"
            ));
        ?>
    </div>
</div>
