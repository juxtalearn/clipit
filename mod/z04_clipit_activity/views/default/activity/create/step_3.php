<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   8/07/14
 * Last update:     8/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
ClipitActivity::get_all()
?>
<link href="http://loudev.com/css/multi-select.css" media="screen" rel="stylesheet" type="text/css" />
<script src="http://loudev.com/js/jquery.multi-select.js" type="text/javascript"></script>
<script>
$(function(){
    $('#callbacks').multiSelect({
        selectableHeader: "<h4>Existing students</h4>",
        selectionHeader: "<h4>Students called to activity</h4>",
    });
    $(document).on("click", "#add_user",function(){
        var content = $(".add-user-list");
        content
            .append(<?php echo json_encode(elgg_view('activity/create/add_user'));?>)
            .find("input[name='user-name[]']")
            .focus();
    });
    //elgg_add_action_tokens_to_url("action/language/set?lang={$key}", true),
    $(document).on("click", "#add_users_button",function(){
        var url_action = $(this).attr("href");
        var data_inputs = $(".add-user-list :input").serialize();
        $.getJSON(url_action, data_inputs, function(data) {
            $.each(data, function(key, user) {
                $('#callbacks').multiSelect('addOption',
                    { value: user.id, text: user.name, index: 0, nested: 'optgroup_label' }
                );
            });
            // remove all elements created
            $(".add-user").remove();
        });
        return false;
    });
    /*$(document).on("change", "#upload-users",function(){
        console.log("loading");
        console.log($("#upload-users").val());

        $.ajax(elgg.config.wwwroot+"ajax/view/tricky_topic/list", {
            files: $("#upload-users"),
            dataType: 'json',
            iframe: true,
            processData: false,
            success: function(html){
                console.log(html);
            }
        }).complete(function(data) {
            console.log(data);
        });
//        $.ajax(
//            elgg.config.wwwroot+"ajax/view/tricky_topic/list", {
//            files: $(":file", this),
//            iframe: true
//        }).complete(function(data) {
//            console.log(data);
//        });
    });*/
//    $('form.p').on('click', 'input[type=submit]', function(evt) {
//        evt.preventDefault();
//        var form = $(this).closest("form");
//        $.ajax(elgg.config.wwwroot+"ajax/view/tricky_topic/list", {
//            data: form.find('textarea').serializeArray(),
//            dataType: 'json',
//            files: form.find(':file'),
//            iframe: true,
//            processData: false
//        }).complete(function(data) {
//            console.log(data);
//        });
//        return false;
//    });
});
</script>
<?php //echo elgg_view("multimedia/file/attach", array('entity' => $entity)); ?>
<?php
//elgg_load_js("file:attach");
echo elgg_view("multimedia/file/templates/attach", array('entity' => $entity));
?>
<script>
$(function () {
    'use strict';
    $("#upload-users_test").fileupload({
        maxFileSize: 500000000, // 500 MB
        //url: elgg.config.wwwroot+"ajax/view/tricky_topic/list",
        url: $("#add_users_button").attr("href"),
        acceptFileTypes: /(\.|\/)(xlsx|jpe?g|png)$/i,
        autoUpload: true,
        previewCrop: false
    }).on('fileuploadadd', function (e, data) {
        console.log("HOLA");
    });
});
</script>
<div class="upload-files <?php echo $col_class; ?>">
    <a style="position: relative;overflow: hidden">
        <strong>
            <i class="fa fa-paperclip"></i> <?php echo elgg_echo('multimedia:attach_files');?>
            <input type="file" multiple name="files" id="upload-users_test">
        </strong>
    </a>
    <div class="upload-files-list files" style="display:none;float: left; width: 100%;"></div>
</div>
<style>
    .ms-container{
        width: 100%;
    }
</style>
<div id="step_3" class="row step">
    <div class="col-md-12">
        <h3 class="title-block"><?php echo elgg_echo('activity:called_users');?></h3>
    </div>
    <a class="p">CLICK</a>
    <div class="col-md-9">
        <select id='callbacks' multiple='multiple'>
            <optgroup label='Site'>
                <?php
                foreach(ClipitUser::get_all() as $user):
                    if($user->role == 'student'):
                ?>
                    <option value="<?php echo $user->id;?>">
                        <?php echo $user->name;?>
                    </option>
                <?php
                    endif;
                endforeach;
                ?>
            </optgroup>
            <optgroup label='Enemies'>
                <option value='3'>Palpatine</option>
                <option value='4' disabled>Darth Vader</option>
            </optgroup>
        </select>
        <div class="margin-top-10 col-md-12" style="background: #fafafa; padding: 10px;">
            <div class="add-user-list">
<!--                --><?php //echo elgg_view("input/hidden", array(
//                    'name' => 'activity-id',
//                    'class' => 'form-control',
//                    //DEBUG
//                    'value' => 2491
//                ));
//                ?>
                <?php echo elgg_view('activity/create/add_user');?>
            </div>
            <div class="col-md-12 margin-top-5 margin-bottom-5">
                <?php echo elgg_view('output/url', array(
                    'title' => elgg_echo('create'),
                    'text' => elgg_echo('create'),
                    'href' => "action/activity/create/add_users",
                    'is_action' => true,
                    'id' => 'add_users_button',
                    'class' => "btn btn-primary pull-right",
                ));
                ?>
                <strong>
                    <?php echo elgg_view('output/url', array(
                        'href'  => "javascript:;",
                        'id' => 'add_user',
                        'title' => elgg_echo('user:add'),
                        'text'  => '<i class="fa fa-plus"></i> '.elgg_echo('user:add'),
                    ));
                    ?>
                </strong>
            </div>
        </div>
        <div class="form-group">
            <label for="upload-users"><?php echo elgg_echo("called:users:upload");?></label>
            <?php echo elgg_view("input/file", array(
                'name' => 'upload-users',
                'id' => 'upload-users',
                'style' => "width: 100%;",
                'multiple' => true
            ));
            ?>
        </div>
    </div>
    <div class="col-md-3">
        test
    </div>
    <div class="col-md-12 text-right margin-top-20">
        <?php echo elgg_view('input/button', array(
            'value' => elgg_echo('back'),
            'data-step' => 2,
            'class' => "btn btn-primary btn-border-blue pull-left button_step",
        ));
        ?>
    </div>
</div>