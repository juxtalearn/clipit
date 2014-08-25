<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   25/07/14
 * Last update:     25/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$activity = elgg_extract('entity', $vars);
$users = ClipitUser::get_by_id($activity->student_array);
$groups = ClipitGroup::get_by_id($activity->group_array , $order_by_name = true);
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
    .items-padding{
        height: 220px;
        overflow-y: auto;
    }
    .items-padding li{
        margin-bottom: 5px;
        padding: 5px;
        padding-bottom: 5px;
        padding-left: 25px;
        border-bottom: 1px solid #bae6f6;
        overflow: hidden;
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
    .ms-selectable .ms-list{
        height: 250px;
    }
    .ms-selection .ms-list{
        height: 245px;
    }
    .site-users li:hover{
        background-color: #32b4e5;
        color: #fff;
    }
</style>
<script src="http://loudev.com/js/jquery.multi-select.js" type="text/javascript"></script>
<script src="http://rawgit.com/riklomas/quicksearch/master/jquery.quicksearch.js"></script>
<script>
$(function(){
    var sortable_groups = function(){
    $( ".group-list ul" ).sortable({
        connectWith: ".group-list ul",
        dropOnEmpty: true,
        receive: function(event, ui) {
            var current_list = $(ui.item).closest(".group-list");
            var sender_list = $(ui.sender).closest(".group-list");
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
            if(sender_list.find("li").length == 0){
                sender_list.find(".delete-group").click();
            }
            elgg.action('activity/admin/groups_setup', {
                data: $(".groups-form").serialize()
            });
        }
    }).disableSelection();
    };
    sortable_groups();
    // Multiselect
    $("#called_users").multiSelect({
        keepOrder: false,
        selectableHeader: '<h4 class="margin-bottom-20"><?php echo elgg_echo("activity:students");?></h4>'+
            "<input type='text' class='search-input form-control margin-bottom-10' autocomplete='off' placeholder='Filter...'>",
        selectionHeader:
            '<label>Group name</label>'+
                '<input type="text" name="group_name" id="group_name" class="form-control margin-bottom-10">'+
                '<h4><?php echo elgg_echo("group:students");?></h4>',
        afterInit: function(ms){
            set_default_group_name();
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
    $(document).on("click", ".delete-user", function(){
        var user = $(this).parent("li");
        var list = user.closest(".group-list");
        $("#called_users option[value='"+user.data("user")+"']").prop("disabled", false);
        $('#called_users').multiSelect('refresh');
        user.remove();
        refresh_users_list(list);
        elgg.action('activity/admin/groups_setup', {
            data: $(".groups-form").serialize()
        });
    });
    $(document).on("click", ".delete-group", function(){
        var list = $(this).parent(".group-list");
        $.each(list.find("li"), function( index, item ) {
            $("#called_users option[value='"+$(this).data("user")+"']").prop("disabled", false);
            $(this).remove();
        });
        refresh_users_list(list);
        list.hide();
        list.find(".input-remove-group").val(1);
        $('#called_users').multiSelect('refresh');
        elgg.action('activity/admin/groups_setup', {
             data: $(".groups-form").serialize()
        });
    });
    $(document).on("click", ".site-users li", function(){
        var user = $(this);
        $('#called_users').multiSelect('addOption',
            { value: user.data("user"), text: user.text(), index: 0}
        );
        $('#called_users').multiSelect('refresh');
        user.remove();
    });
    // Create group
    $(document).on("click", "#create", function(e){
        e.preventDefault();
        var that = $(this);
        that.button(elgg.echo("loading"));
        var data_users = $("#called_users").val();
        elgg.action('activity/admin/groups_create', {
            data: {
                activity_id: <?php echo $activity->id;?>,
                group: {
                    name: $("#group_name").val(),
                    users: data_users
                }
            },
            success: function(content){
                $("#groups").prepend(content.text);
                $('#called_users option:selected').prop("disabled", true);
                $('#called_users').multiSelect('deselect_all');
                that.button('reset');
                $('#called_users').multiSelect('refresh');
                sortable_groups();
            }
        });
    });
});
function refresh_users_list(list){
    var user_ids = [];
    // users values
    $.each(list.find("li"), function( index, item ) {
        user_ids.push($(this).data("user"));
    });
    list.find(".input-users").val(user_ids);
}
function set_default_group_name(){
    if($("input[name='group_name']").length == 0){
        return false;
    }
    var group_name = $("input[name='group_name']");
    group_name.val(get_default_group_name);
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
    var get_num = $(".group-list:not(:hidden)").length;
    return "<?php echo elgg_echo("group");?> "+ (get_num+1);
}
</script>
<a name="create-group"></a>
<?php echo elgg_view_form('activity/admin/groups_create',
    array(
        'body' => elgg_view('activity/admin/groups/create',
            array('users' => $users, 'activity' => $activity)
        ))
);
?>
<hr>
<h3 class="title-block margin-top-0"><?php echo elgg_echo('activity:groups');?></h3>
<?php echo elgg_view_form('activity/admin/groups_setup',
    array(
        'class' => 'groups-form',
        'body' => elgg_view('activity/admin/groups/list',
            array('groups' => $groups, 'activity' => $activity)
        ))
    );
?>