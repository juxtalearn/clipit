<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   7/07/14
 * Last update:     7/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
elgg_load_js("jquery:dynatable");
$tricky_topics = ClipitTrickyTopic::get_all();
$owner_tt = array();
foreach($tricky_topics as $tricky_topic){
    $tt[$tricky_topic->id] = $tricky_topic->name;
    if($tricky_topic->owner_id == elgg_get_logged_in_user_guid()){
        $owner_tt[$tricky_topic->id] = $tricky_topic->name;
    }
}
$tt = array_diff($tt, $owner_tt);
?>
<script>
$(function(){
    $("#tricky-topic").change(function(){
        var content = $("#tricky_topic_view");
        if($(this).val() == 0){
            content.hide();
            return false;
        }
        content.show().html('<i class="fa fa-spinner fa-spin blue"></i>');
        $.ajax({
            url: elgg.config.wwwroot+"ajax/view/tricky_topic/list",
            type: "POST",
            data: { tricky_topic : $(this).val()},
            success: function(html){
                content.html(html);
            }
        });
    });
    $("#add-tricky-topic").click(function(){
        $(this).parent("div").toggleClass("hide");
        $("#select-tricky-topic").toggle();
        $("#form-add-tricky-topic").toggle().find("input:first").focus();
    });
    $(document).on("click", "#add-tag", function(){
        $("#form-add-tags").append(<?php echo json_encode(elgg_view("tricky_topic/add"));?>);
        $(".input-tag:last").focus().autocomplete(tags_autocomplete);
    });
    var tags_autocomplete = {
        source: function (request, response) {
            elgg.getJSON(
                "ajax/view/tricky_topic/tags/search",{
                    data: {q: request.term},
                    success: function(data){
                        response(data);
                    }
                }
            );
        },
        select: function( event, ui ) {
            event.preventDefault();
            this.value = ui.item.label;
        },
        focus: function(event, ui) {
            event.preventDefault();
            this.value = ui.item.label;
        },
        minLength: 2
    };
    $(".input-tag").autocomplete(tags_autocomplete);
});
</script>
<style>
    ul.ui-menu.ui-autocomplete{
        background-color: #fff;
        cursor: default;
        font-size: 14px;
        -webkit-box-shadow: 0 6px 12px rgba(0,0,0,0.2);
        box-shadow: 0 6px 12px rgba(0,0,0,0.2);
        padding: 3px;
        max-width: 350px;
    }
    ul.ui-menu.ui-autocomplete li {
        border-bottom: 1px solid #eee;
    }
    ul.ui-menu.ui-autocomplete li:last-child {
        border-bottom: 0;
    }
    ul.ui-menu.ui-autocomplete li > a {
        display: block;
        padding: 3px;
        padding-left: 10px;
        font-weight: bold;
    }
    ul.ui-menu.ui-autocomplete li:hover > a, ul.ui-menu.ui-autocomplete li >a.ui-state-focus{
        color: #fff;
        text-decoration: none;
        background: #32b4e5;
    }
</style>
<script>
    var datepicker_setup = function(){
        var activity_form = $("#activity-create");
        $(".datepicker").datepicker({
            minDate: activity_form.find("input[name=activity-start]").val(),
            maxDate: activity_form.find("input[name=activity-end]").val(),
            onClose: function (text, inst) {
                $(activity_form
                    .find(".input-task-start, .input-task-end, input[name='activity-end']"))
                        .datepicker( "option", "minDate", activity_form.find("input[name=activity-start]").val() );
                $(activity_form
                    .find(".input-task-start, .input-task-end, input[name='activity-start']"))
                        .datepicker( "option", "maxDate", activity_form.find("input[name=activity-end]").val() );
            }
        });
    }
$(function(){
    datepicker_setup();
    $(document).on("click", ".button_step, .nav-steps a",function(){
        // Step 4 (Make groups) empty
        $("#nav-step-4").hide();
        $("#step_4").html('');
        var step = $(this).data("step");
        var current_step = parseInt($(".step:visible").attr("id").replace("step_", ""));
        // is validated
        if($(this).attr("id") == 'next_step' || step > current_step){
            if(!$(".elgg-form-activity-create").valid()){
                return false;
            }
        }
        $(".nav-steps li").removeClass("active");
        $("#nav-step-"+ step).parent("li").addClass("active");
        $(this).closest(".container").find(".step").hide();
        $("#step_"+ step).fadeIn();

    });
    $(window).bind('beforeunload', function(){
        return '<?php echo elgg_echo('exit:page:confirmation');?>';
    });
    $(document).on("click", '#finish_setup', function(e){
        $(window).unbind('beforeunload');
    });
});
</script>
<div id="step_1" class="row step">
    <div class="col-md-6">
        <div id="select-tricky-topic">
            <div class="form-group">
                <label for="activity-tricky-topic"><?php echo elgg_echo("activity:select:tricky_topic");?></label>

                <select required="required" id="tricky-topic" class="form-control" name="activity-tricky-topic" style="padding-top: 5px;padding-bottom: 5px;">
                    <option value="<?php echo $value;?>">
                        <?php echo elgg_echo('tricky_topic:select');?>
                    </option>
                    <?php if(count($owner_tt)>0):?>
                        <optgroup label="<?php echo elgg_echo('tricky_topic:created_by_me');?>">
                            <?php foreach($owner_tt as $value => $name):?>
                                <option value="<?php echo $value;?>">
                                    <?php echo $name;?>
                                </option>
                            <?php endforeach;?>
                        </optgroup>
                    <?php endif;?>
                    <?php if(count($tt)>0):?>
                    <optgroup label="<?php echo elgg_echo('tricky_topic:created_by_others');?>">
                        <?php foreach($tt as $value => $name):?>
                            <option value="<?php echo $value;?>">
                                <?php echo $name;?>
                            </option>
                        <?php endforeach;?>
                        </optgroup>
                    <?php endif;?>
                </select>
            </div>
            <div class="row margin-0 margin-bottom-10" id="tricky_topic_view" style="display: none;background: #fafafa;padding: 10px;"></div>
        </div>
        <div>
            <?php echo elgg_echo('or:create');?>
            <?php echo elgg_view('output/url', array(
                'href'  => "javascript:;",
                'title' => elgg_echo('tricky_topic'),
                'text'  => elgg_echo('tricky_topic'),
                'id'    => 'add-tricky-topic'
            ));
            ?>
        </div>
        <div class="row margin-0 margin-bottom-10" id="form-add-tricky-topic" style="display: none;background: #fafafa;padding: 10px;">
            <div class="form-group col-md-12 margin-top-10">
                <?php echo elgg_view("input/text", array(
                    'name' => 'new-tricky-topic',
                    'value' => $entity->name,
                    'class' => 'form-control',
                    'required' => true,
                    'placeholder' => elgg_echo('tricky_topic')
                ));
                ?>
                <hr class="margin-0 margin-top-10 margin-bottom-10">
                <small class="show margin-top-5"><?php echo elgg_echo("tags");?></small>
            </div>
            <div id="form-add-tags">
                <?php echo elgg_view("tricky_topic/add");?>
            </div>
            <div class="col-md-12">
                <?php echo elgg_view('output/url', array(
                    'href'  => "javascript:;",
                    'class' => 'btn btn-xs btn-border-blue btn-primary pull-right',
                    'title' => elgg_echo('cancel'),
                    'text'  => elgg_echo('cancel'),
                    'onclick' => '$(\'#add-tricky-topic\').click()',
                ));
                ?>
                <?php echo elgg_view('output/url', array(
                    'href'  => "javascript:;",
                    'class' => 'btn btn-xs btn-primary',
                    'title' => elgg_echo('add'),
                    'text'  => '<i class="fa fa-plus"></i>' . elgg_echo('add'),
                    'id'    => 'add-tag'
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="activity-title"><?php echo elgg_echo("activity:title");?></label>
            <?php echo elgg_view("input/text", array(
                'name' => 'activity-title',
                'class' => 'form-control',
                'required' => true
                ));
            ?>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label for="activity-start"><?php echo elgg_echo("activity:start");?></label>
                <?php echo elgg_view("input/text", array(
                    'name' => 'activity-start',
                    'class' => 'form-control datepicker',
                    'required' => true
                ));
                ?>
            </div>
            <div class="col-md-4">
                <label for="task-end"><?php echo elgg_echo("activity:end");?></label>
                <?php echo elgg_view("input/text", array(
                    'name' => 'activity-end',
                    'class' => 'form-control datepicker',
                    'required' => true
                ));
                ?>
            </div>
        </div>
        <div class="form-group margin-top-10">
            <label for="activity-description"><?php echo elgg_echo("description");?></label>
            <?php echo elgg_view("input/plaintext", array(
                'name'  => 'activity-description',
                'class' => 'form-control',
                'required' => true,
                'rows'  => 6,
                ));
            ?>
        </div>
    </div>

    <div class="col-md-12 text-right margin-top-20">
        <?php echo elgg_view('input/button', array(
                'value' => elgg_echo('next'),
                'data-step' => 2,
                'id' => 'next_step',
                'class' => "btn btn-primary button_step",
            ));
        ?>
    </div>
</div>