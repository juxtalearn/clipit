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
?>
<script src="http://loudev.com/js/jquery.multi-select.js" type="text/javascript"></script>
<script src="http://rawgit.com/riklomas/quicksearch/master/jquery.quicksearch.js"></script>
<script>
$(function(){
    // Finish activity setup
    $(document).on("click", "#finish_setup",function(){
        $(this).closest("form").submit();
    });

    $('#called_users').multiSelect({
        keepOrder: false,
        selectableOptgroup: true,
        selectableHeader: "<h4><?php echo elgg_echo("activity:site:students");?></h4>"+
                            "<input type='text' class='search-input form-control margin-bottom-10' autocomplete='off' placeholder='Filter...'>",
        selectionHeader: "<h4><?php echo elgg_echo("activity:students");?></h4>"+
                            "<input type='text' class='search-input form-control margin-bottom-10' autocomplete='off' placeholder='Filter...'>",
        afterInit: function(ms){
            var that = this,
                $selectableSearch = that.$selectableUl.prev(),
                $selectionSearch = that.$selectionUl.prev(),
                selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
                selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

            that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                .on('keydown', function(e){
                    if (e.which === 40){
                        that.$selectableUl.focus();
                        return false;
                    }
                });

            that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                .on('keydown', function(e){
                    if (e.which == 40){
                        that.$selectionUl.focus();
                        return false;
                    }
                });
        },
        afterSelect: function(){
            this.qs1.cache();
            this.qs2.cache();
        },
        afterDeselect: function(){
            this.qs1.cache();
            this.qs2.cache();
        }
    });
    $(".select-radio").click(function(){
        var input = $(this).find("input[type=radio]");
        input.prop("checked", true);
        $("#accordion_grouping").find(".panel-heading").removeClass('bg-blue-lighter').addClass('bg-white');
        $(this).parent(".panel-heading").toggleClass('bg-white bg-blue-lighter');
    });
    $(document).on("click", "#add_users_button", function(){
        var url_action = $(this).attr("href");
        var data_inputs = $(".add-user-list :input").serialize();
        $.getJSON(url_action, data_inputs, function(data) {
            $.each(data, function(key, user) {
                $('#called_users').multiSelect('addOption',
                    { value: user.id, text: user.name, index: 0, nested: 'Loaded' }
                );
                $('#called_users').multiSelect('select', [""+user.id+""]);
            });
            // remove all elements created
            $(".add-user").remove();
        });
        return false;
    });
    $(document).on("click", "#load_called_users",function(e){
        e.preventDefault();
        var current_step = $(this).closest(".step");
        $('#users_group').find("option").remove();
        current_step.hide();
        $("#nav-step-4").show().parent("li").addClass("active");
        $.ajax({
            url: elgg.config.wwwroot+"ajax/view/activity/create/groups/create",
            type: "POST",
            data: { users_list : $("#called_users").val()},
            success: function(html){
                $(".create_groups").html(html).show();
            }
        });
    });
});
</script>
<?php
echo elgg_view("multimedia/file/templates/attach");
?>
<script>
$(function () {
    'use strict';
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
            if(parent_id == 'insert-activity'){
                $('#called_users').multiSelect('select', [""+user.id+""]);
            }
            $('#called_users').multiSelect('refresh');
        });
    });
});
</script>
<script>
// MAKE GROUPS
$(function(){
    $(document).on("click", "#create", function(){
        var data = $("select[name='group_users[]']").val();
        var group_name = $("input[name='select_group_name']");
        if(!$("select[name='group_users[]']").val()){
            return false;
        }
        var new_group_id = new Date().getTime();
        var content = '<div class="col-md-3 group-list" data-group="'+new_group_id+'">';
        content +=  '<div class="bg-center-icon" style="display: none;">' +
            '<div class="bg"></div>' +
            '<div class="center-icon"><div>' +
            '<span class="fa-stack fa-lg">' +
            '<i class="fa fa-circle fa-stack-2x blue"></i><i class="fa fa-pencil fa-stack-1x fa-inverse"></i></span>' +
            '</div></div>' +
            '</div>';
        content += '<input type="hidden" class="input-name" name="group['+new_group_id+'][name]" value="'+group_name.val()+'"/>';
        content += '<h4 class="text-truncate">' +
            '<a href="javascript:;" class="fa fa-times red pull-right remove-button"></a>' +
            '<a href="javascript:;" class="update-button"><i class="fa fa-pencil pull-right"></i></a>' +
            '<span>'+group_name.val()+'</span></h4>' +
            '<ul class="items-padding">';
        group_name.val('');
        $.each(data, function( index, user_id ) {
            var user_name = $('select[name="group_users[]"] option[value='+ user_id +']:selected').text();
            content += '<li data-user="'+user_id+'">'+user_name+'</li>';
            $("select[name='group_users[]']").find('option[value='+user_id+']').remove();
        });
        $("select[name='group_users[]']").multiSelect('refresh');
        content += '</ul>';
        content += '<input type="hidden" class="input-users" name="group['+new_group_id+'][users]" value="'+data+'">';
        content += '</div>';
        $("#groups").append(content);
        set_users_sortable();
        set_default_group_name();
    });
    $(document).on("click", "#update, #cancel", function(){
        $("#create").show(); // show create button
        $("#update, #cancel").hide();
        $(".group-list")
            .removeClass('active')
            .find('.bg-center-icon')
            .hide();
        var select = $("select[name='group_users[]']");
        var group_id = select.data("group");
        var data_list = $("#groups .group-list[data-group="+group_id+"]");
        if($(this).attr("id") == 'update'){
            var data = select.val();
            if(group_id > 0){
                var list = data_list.find("ul");
                set_users_list(list, data);
            }
        }
        var users_id = data_list.find(".input-users").val();
        users_id = users_id.split(',');
        $.map( users_id, function( user_id, i ) {
            $("#users_group").find('option[value='+user_id+']').remove();
        });
        $("input[name=select_group_name]").val('');
        select.data("group", 0);
        $('#users_group').multiSelect('deselect_all');
        //select.find("option:selected").remove();
        set_users_sortable();
        select.multiSelect('refresh');
        set_default_group_name();
    });
    // Update group button
    $(document).on("click", ".update-button", function(){
        $("#update, #cancel").show(); // show update button
        $("#create").hide();
        $('#users_group').multiSelect('deselect_all');
        var group_list = $(this).closest(".group-list");
        group_list.addClass('active');
        group_list.find(".bg-center-icon").show();
        var group_id = group_list.data("group");
        var select = $("select[name='group_users[]']");
        select.data("group", group_id);

        var data = group_list.find(".input-users").val().split(",");
        $.each(data, function( index, user_id ) {
            var user_name = $('li[data-user='+user_id+']').text();
            select.append('<option value="'+user_id+'" selected>'+user_name+'</option>');
        });
        select.multiSelect('refresh');
        $("input[name='select_group_name']").val(group_list.find(".input-name").val());
    });
    // Remove group button
    $(document).on("click", ".remove-button", function(){
        var data_list = $(this).closest(".group-list");
        var data = data_list.find('.input-users').val().split(",");
        $.each(data, function( index, user_id ) {
            var user_name = $('li[data-user='+user_id+']').text();
            $("select[name='group_users[]']").append('<option value="'+user_id+'">'+user_name+'</option>');
        });
        $("#users_group").multiSelect('refresh');
        data_list.remove();
        set_default_group_name();
    });
    $(document).on("click", "delete-groups", function(){
        $(".group-list").remove();
    });

    // Sortable
    function set_users_sortable(){
        $( ".group-list ul" ).sortable({
            connectWith: ".group-list ul",
            dropOnEmpty: true,
            receive: function(event, ui) {
                var current_list = $(ui.item).closest(".group-list");
                var sender_list = $(ui.sender).closest(".group-list");
                if(sender_list.find("li").length == 0){
                    $(ui.sender).sortable('cancel');
                } else {
                    var user_ids = [];
                    // Current users values
                    $.each(current_list.find("li"), function( index, item ) {
                        user_ids.push($(this).data("user"));
                    });
                    current_list.find(".input-users").val(user_ids);
                    var user_ids = [];
                    // Sender users values
                    $.each(sender_list.find("li"), function( index, item ) {
                        user_ids.push($(this).data("user"));
                    });
                    sender_list.find(".input-users").val(user_ids);
                }
            }
        }).disableSelection();
    }

    function set_users_list(list, data){
        var content = "";
        $.each(data, function( index, user_id ) {
            var user_name = $('select[name="group_users[]"]').find('option[value='+ user_id +']:selected').text();
            content += '<li data-user="'+user_id+'">'+user_name+'</li>';
        });
        list.html(content);
        var data_list = list.closest("div.group-list");
        var group_name = $("input[name='select_group_name']").val();
        data_list.find(".input-users").val(data);
        data_list.find(".input-name").val(group_name);
        data_list.find("h4 span").text(group_name);
    }

});

function set_default_group_name(){
    if($("input[name='select_group_name']").length == 0){
        return false;
    }
    var group_name = $("input[name='select_group_name']");
    //if(group_name.val().length == 0){
    //var get_num = group_name.val().replace( /^\D+/g, '');
    group_name.val(get_default_group_name);
    //}
    group_name.bind("focus",function(){
        if(this.value==(get_default_group_name()))
            this.value='';
    });
    group_name.bind("blur",function(){
        if(this.value=='')
            this.value=get_default_group_name()
    });
}
function get_default_group_name(){
    var get_num = $(".group-list").length;
    return "<?php echo elgg_echo("group");?> "+ (get_num+1);
}
</script>
<div id="step_3" class="row step" style="display: none;">
    <div class="col-md-8">
        <div>
            <select id="called_users" name="called_users[]" multiple="multiple">
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
            </select>
        </div>
        <div class="margin-top-20">
            <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse_add">
                            <h4 class="panel-title">
                                <i class="fa fa-angle-down pull-right"></i>
                                <i class="fa fa-plus"></i>
                                <?php echo elgg_echo("called:students:add");?>
                            </h4>
                        </a>
                    </div>
                    <div id="collapse_add" class="panel-collapse collapse">
                        <div class="panel-body">
                            <div class="margin-top-10">
                                <div class="add-user-list">
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
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse_upload">
                            <h4 class="panel-title">
                                <i class="fa fa-angle-down pull-right"></i>
                                <i class="fa fa-file-excel-o"></i>
                                <?php echo elgg_echo("called:students:add:from_excel");?>
                            </h4>
                        </a>
                    </div>
                    <div id="collapse_upload" class="panel-collapse collapse">
                        <div class="panel-body">
                            <div class="form-group">
                                <a class="btn btn-primary pull-right fileinput-button" id="insert-activity">
                                    <?php echo elgg_echo('called:students:insert_to_activity');?>
                                    <?php echo elgg_view("input/file", array(
                                        'name' => 'upload-users',
                                        'class' => 'upload-users',
                                        'id' => 'upload-users',
                                    ));
                                    ?>
                                </a>
                                <a class="btn btn-primary fileinput-button" id="insert-site">
                                    <?php echo elgg_echo('called:students:insert_to_site');?>
                                    <?php echo elgg_view("input/file", array(
                                        'name' => 'upload-users',
                                        'class' => 'upload-users',
                                        'id' => 'upload-users',
                                    ));
                                    ?>
                                </a>
                                <div>
                                    <a class="upload-messages"></a>
                                </div>
                                <hr>
                                <a href="<?php echo elgg_get_site_url();?>mod/z04_clipit_activity/vendors/templates/clipit_users.xlsx" target="_blank">
                                    <i class="fa fa-file-excel-o green"></i>
                                    <strong>Download Excel template</strong>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <?php echo elgg_view('activity/create/groups/grouping_mode');?>
    </div>
    <div class="col-md-12 text-right margin-top-20">
        <?php echo elgg_view('input/button', array(
            'value' => elgg_echo('back'),
            'data-step' => 2,
            'id' => 'back_step',
            'class' => "btn btn-primary btn-border-blue pull-left button_step",
        ));
        ?>
        <?php echo elgg_view('output/url', array(
            'href'  => "javascript:;",
            'id'    => 'finish_setup',
            'title' => elgg_echo('finish'),
            'text' => elgg_echo('finish'),
            'class' => "btn btn-primary",
        ));
        ?>
    </div>
</div>
<div style="display: none;" id="step_4" class="row step create_groups"></div>