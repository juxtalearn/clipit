<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   11/07/14
 * Last update:     11/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
?>
<style>
    #users_group_test{
        position: relative;
    }
    .bootstrap-duallistbox-container select > option{
        border-bottom: 1px #eee solid;
        padding: 3px 10px;
    }
    .bootstrap-duallistbox-container select > option:hover{
        background: #000;
    }
    #users_group_test option::after {
        font-family: FontAwesome;
        color: #bae6f6;
        position: absolute;
        content: "\f061";
        right: 5px;
    }
    <!-- -->
    .ms-container{
        overflow: hidden;
    }
    .items-padding li{
        margin-bottom: 5px;
        padding: 5px;
        padding-bottom: 5px;
        padding-left: 25px;
        border-bottom: 1px solid #bae6f6;
    }
    .group-list.active{
        background: #d6f0fa;
    }
    .group-list{
        position: relative;
    }

    .ui-sortable-helper, .group-list li:hover{
        background-color: #32b4e5;

        position: relative;
        color: #fff;
        cursor: default;
        height: auto !important;
    }
    .ui-sortable-helper:after, .group-list li:hover:after{
        position: absolute;
        left: 5px;
        content: "\f047";
        font-family: FontAwesome;
        color: #bae6f6;
    }
    .ui-sortable-placeholder{
        position: relative;
        background: #d6f0fa;
        border: 1px solid #bae6f6;
        visibility: visible !important;
    }
</style>
<script>
$(function(){
    $("select[name='group_users[]']").multiSelect({
        keepOrder: false,
        selectableHeader: "<h4 style='margin-top: 70px;'><?php echo elgg_echo("students");?></h4>",
        selectionHeader:
                        '<label>Group name</label>'+
                        '<input type="text" name="select_group_name" class="form-control margin-bottom-10">'+
                        '<h4><?php echo elgg_echo("group:students");?></h4>',
        afterInit: function(){
            set_default_group_name();
        }


    });
    // first load
    $("#load_called_users").click(function(){
        var data = $('#called_users').val();
        $('#users_group').find("option").remove();
        $.each(data, function( index, user_id ) {
            var user_name = $('#called_users option[value='+ user_id +']:selected').text();
            $('#users_group').append('<option value="'+user_id+'">'+user_name+'</option>');
        });
        $("select[name='group_users[]']").multiSelect('refresh');
    });
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
            content += '<input type="hidden" name="group_name[]" value="'+group_name.val()+'"/>';
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
        content += '<input type="hidden" name="groups[]" value="'+data+'">';
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
        var users_id = data_list.find("input[name='groups[]']").val();
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

        var data = group_list.find("input[name='groups[]']").val().split(",");
        $.each(data, function( index, user_id ) {
            var user_name = $('li[data-user='+user_id+']').text();
            select.append('<option value="'+user_id+'" selected>'+user_name+'</option>');
        });
        select.multiSelect('refresh');
        $("input[name='select_group_name']").val(group_list.find("input[name='group_name[]']").val());
    });
    // Remove group button
    $(document).on("click", ".remove-button", function(){
        var data_list = $(this).closest(".group-list");
        var data = data_list.find('input[name="groups[]"]').val().split(",");
        $.each(data, function( index, user_id ) {
            var user_name = $('li[data-user='+user_id+']').text();
            $("select[name='group_users[]']").append('<option value="'+user_id+'">'+user_name+'</option>');
        });
        $("#users_group").multiSelect('refresh');
        data_list.remove();
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
                    current_list.find("input[name='groups[]']").val(user_ids);
                    var user_ids = [];
                    // Sender users values
                    $.each(sender_list.find("li"), function( index, item ) {
                        user_ids.push($(this).data("user"));
                    });
                    sender_list.find("input[name='groups[]']").val(user_ids);
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
        data_list.find("input[name='groups[]']").val(data);
        data_list.find("input[name='group_name[]']").val(group_name);
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
<div style="display: none;" id="step_4" class="row step">
    <div class="col-md-12">
        <h3 class="title-block"><?php echo elgg_echo('groups:create');?></h3>
        <div class="col-md-8 group-container">
            <select id="users_group" name="group_users[]" data-group="0" multiple="multiple"></select>
            <button id="create" type="button" class="btn btn-primary pull-right margin-top-20">
                <?php echo elgg_echo('create');?>
            </button>
            <button id="update" type="button" style="display: none;" class="btn btn-primary pull-right margin-top-20">
                <?php echo elgg_echo('update');?>
            </button>
            <button id="cancel" type="button" style="display: none;" class="margin-right-10 btn btn-primary btn-border-blue pull-right margin-top-20">
                <?php echo elgg_echo('cancel');?>
            </button>
        </div>
    </div>
    <div class="col-md-12">
        <h3 class="title-block"><?php echo elgg_echo('groups');?></h3>
        <div id="groups"></div>
    </div>
    <div class="col-md-12 text-right margin-top-20">
        <?php echo elgg_view('input/button', array(
            'value' => elgg_echo('back'),
            'data-step' => 3,
            'id' => 'delete-groups',
            'class' => "btn btn-primary btn-border-blue pull-left button_step",
        ));
        ?>
    </div>
</div>