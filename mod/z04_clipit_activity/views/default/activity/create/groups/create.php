<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   11/07/14
 * Last update:     11/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$users = get_input('users_list');
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
    // first load
    $("select[name='group_users[]']").multiSelect({
        keepOrder: false,
        selectableHeader: "<h4 style='margin-top: 70px;'><?php echo elgg_echo("students");?></h4>",
        selectionHeader:
                        '<label>Group name</label>'+
                        '<input type="text" aria-label="select_group_name" name="select_group_name" class="form-control margin-bottom-10">'+
                        '<h4><?php echo elgg_echo("group:students");?></h4>',
        afterInit: function(){
            set_default_group_name();
        }
    });
});
</script>

<div class="col-md-12">
    <h3 class="title-block"><?php echo elgg_echo('groups:create');?></h3>
    <div class="col-md-8 group-container">
        <select id="users_group" name="group_users[]" data-group="0" multiple="multiple">
            <?php foreach($users as $user_id):
                $user = array_pop(ClipitUser::get_by_id(array($user_id)));
            ?>
                <option value="<?php echo $user_id;?>"><?php echo $user->name;?></option>
            <?php endforeach;?>
        </select>
        <button id="create" type="button" class="btn btn-primary pull-right margin-top-20">
            <?php echo elgg_echo('create');?>
        </button>
        <button id="update" type="button" style="display: none;" class="btn btn-primary pull-right margin-top-20">
            <?php echo elgg_echo('save');?>
        </button>
        <button id="cancel" type="button" style="display: none;" class="margin-right-10 btn btn-primary btn-border-blue pull-right margin-top-20">
            <?php echo elgg_echo('cancel');?>
        </button>
    </div>
</div>
<div class="col-md-12">
    <h3 class="title-block"><?php echo elgg_echo('activity:groups');?></h3>
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
    <?php echo elgg_view('input/submit', array(
        'value' => elgg_echo('finish'),
        'type' => 'submit',
        'id' => 'finish_setup',
        'class' => "btn btn-primary",
    ));
    ?>
</div>