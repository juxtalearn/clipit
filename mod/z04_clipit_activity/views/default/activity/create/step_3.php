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
        var form = $(this).closest("form");
        form.submit();
        if(form.valid()){
            $(this).button(elgg.echo("loading"));
        }
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
                    { value: user.id, text: user.name, index: 0}
                );
                $('#called_users').multiSelect('select', [""+user.id+""]);
            });

            // remove all elements created
            $(".add-user").remove();
        });
        $('#called_users').multiSelect('refresh');
        return false;
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
                                <?php echo elgg_view('output/url', array(
                                    'href'  => "mod/z04_clipit_activity/vendors/templates/clipit_users.xlsx",
                                    'title' => elgg_echo('activity:download:excel_template'),
                                    'target' => '_blank',
                                    'text'  => '<i class="fa fa-file-excel-o green"></i>
                                                <strong>'.elgg_echo('activity:download:excel_template').'</strong>',
                                ));
                                ?>
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
