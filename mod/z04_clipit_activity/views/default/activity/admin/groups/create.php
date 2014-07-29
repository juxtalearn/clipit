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
        $(".upload-messages").show().html($("<span id='loading-file'><i class='fa fa-spinner fa-spin'/> loading</span>"));
    }).on('fileuploadstop', function (e, data) {
        $(".upload-messages").html("<strong>Uploaded</strong>").fadeOut(4000);

    }).on('fileuploadprocessalways', function (e, data) {
        var messages_content = $(".upload-messages");
        var index = data.index,
            file = data.files[index],
            node = messages_content;
        if (file.error) {
            node.html($('<span class="text-danger"/>').text(file.error));
        }
    }).on('fileuploaddone', function (e, data) {
        var parent_id = $(this).parent("a").attr("id");
        $.each(data.result, function(index, user) {
            $('#called_users').multiSelect('addOption',
                { value: user.id, text: user.name, index: 0}
            );
            $('#called_users').multiSelect('refresh');
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
<p class="pull-right margin-top-20">
<!--    --><?php //echo elgg_view('input/submit',
//        array(
//            'id'    => 'create',
//            'value' => elgg_echo('create'),
//            'class' => "btn btn-primary"
//        ));
//    ?>
    <?php echo elgg_view('input/button',
        array(
            'id'    => 'create',
            'value' => elgg_echo('create'),
            'class' => "btn btn-primary"
        ));
    ?>
</p>
<div class="form-group margin-top-10">
    <a class="btn btn-primary btn-xs fileinput-button" id="insert-site">
        <i class="fa fa-upload"></i>
        <?php echo elgg_echo('called:students:add_from_excel');?>
        <?php echo elgg_view("input/file", array(
            'name' => 'upload-users',
            'class' => 'upload-users',
            'id' => 'upload-users',
        ));
        ?>
    </a>
    <?php echo elgg_view('output/url', array(
        'title' => elgg_echo('called:students:add_from_site'),
        'text' => '<i class="fa fa-plus"></i> '. elgg_echo('called:students:add_from_site'),
        'href' => "javascript:;",
        'onclick' => "$('.site-users').toggle();",
        'class' => 'btn btn-xs btn-primary',
    ));
    ?>
    <ul class="margin-top-10 site-users" style="display: none;width: 45%;overflow-y: auto;max-height: 200px">
        <?php
        foreach(ClipitUser::get_all() as $user):
            if(!in_array($user->id, $activity->student_array) && $user->role == 'student'):
                ?>
                <li data-user="<?php echo $user->id;?>" style="padding: 2px;" class="cursor-pointer list-item-5" value="<?php echo $user->id;?>">
                    <?php echo elgg_view('output/img', array(
                        'src' => get_avatar($user, 'small'),
                        'class' => 'avatar-tiny'
                    ));
                    ?>
                    <?php echo $user->name;?>
                </li>
            <?php
            endif;
        endforeach;
        ?>
    </ul>
    <div>
        <a class="upload-messages"></a>
    </div>
    <div class="margin-top-10">
        <a href="<?php echo elgg_get_site_url();?>mod/z04_clipit_activity/vendors/templates/clipit_users.xlsx" target="_blank">
            <i class="fa fa-file-excel-o green"></i>
            <strong><?php echo elgg_echo('called:students:excel_template');?></strong>
        </a>
    </div>
</div>