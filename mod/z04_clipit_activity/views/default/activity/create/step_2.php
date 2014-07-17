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
?>
<style>
.ui-datepicker.ui-widget-content{
    padding: 10px;
    background: #fff;
    border-radius: 4px;
    border: 1px solid #32b4e5;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    display: none;
}
.ui-datepicker th {
    padding: .7em .3em;
    text-align: center;
    font-weight: bold;
    border: 0;
    color: #32b4e5;
}
.ui-datepicker td {
    border: 0;
    padding: 1px;
}
.ui-datepicker td a{
    background: #d6f0fa;
}
.ui-datepicker td span, .ui-datepicker td a {
    display: block;
    padding: 5px 10px;
    text-align: right;
    text-decoration: none;
}
.ui-datepicker td span{
    color: #999;
    background: #fafafa;
    opacity: 0.7;
}
.ui-datepicker td a:hover{
    text-decoration: none;
}
.ui-datepicker td a.ui-state-active{
    background: #32b4e5;
    color: #fff;
    font-weight: bold;
}
.ui-datepicker .ui-datepicker-header {
    position: relative;
    padding: .2em 0;
    border-bottom: 1px solid #d6f0fa;
}
.ui-datepicker-title{
    margin: 0 2.3em;
    text-align: center;
    text-transform: uppercase;
    font-weight: bold;
    color: #32b4e5;
}
.ui-datepicker .ui-datepicker-prev, .ui-datepicker .ui-datepicker-next {
    position: absolute;
    top: 2px;
    height: 1.8em;
    text-transform: uppercase;
    font-weight: bold;
    color: #32b4e5;
    text-decoration: none;
    cursor: pointer;
    text-align: right;
    font-size: 20px;
    display: inline-block;
    font-family: FontAwesome;
    font-style: normal;
    font-weight: normal;
    line-height: 1;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}
.ui-datepicker .ui-datepicker-prev {
    left: 2px;
}
.ui-datepicker .ui-datepicker-prev:before {
    content: "\f0d9";
}
.ui-datepicker .ui-datepicker-next {
    right: 2px;
}
.ui-datepicker .ui-datepicker-next:before {
    content: "\f0da";
}
.ui-datepicker .ui-icon{
    text-align: left;
    display: block;
    text-indent: -99999px;
    overflow: hidden;
    background-repeat: no-repeat;
}
.ui-datepicker .ui-state-disabled {
    cursor: default !important;
}
</style>
<script>
$(function(){

    $(document).on("click", "#add_task",function(){
       var content = $(".task-list");
        $.get( "ajax/view/activity/create/task_list", function( data ) {
            content.append(data);
        });
    });

    $(document).on("click", ".feedback-check",function(){
        var parent = $(this).closest("li");
        var feedback_content = parent.find(".feedback_form");
        if($(this).find("input").is(':checked')){
            var task_end = parent.find(".input-task-end").val();
            if(task_end.length > 0){
                feedback_content.find(".input-task-start").val(task_end);
            }
            feedback_content
                .show()
                .find(".input-task-title")
                .focus();
        } else {
            feedback_content.hide();
        }
    });

    $(document).on("change", ".task-types",function(){
        var task_types = ['video_upload', 'storyboard_upload'];
        var content = $(this).closest("li").find(".feedback-module");
        var content_form = $(this).closest("li").find('.feedback_form');
        if($.inArray($(this).val(), task_types) != -1){
            switch($(this).val()){
                case "video_upload":
                    content_form.find('.task-types').val('video_feedback');
                    break;
                case "storyboard_upload":
                    content_form.find('.task-types').val('storyboard_feedback');
                    break;
            }
            content.show();
        } else {
            content.hide();
            content_form.hide();
            content.find("input[type=checkbox]").prop('checked', false);
        }
    });
});
</script>
<div style="display: none;" id="step_2" class="row step">
    <div class="col-md-12">
        <h3 class="title-block"><?php echo elgg_echo('activity:tasks');?></h3>
    </div>
    <ul class="task-list">
        <?php echo elgg_view('activity/create/task_list');?>
    </ul>
    <div class="col-md-12 margin-top-5 margin-bottom-5">
        <strong>
        <?php echo elgg_view('output/url', array(
            'href'  => "javascript:;",
            'id' => 'add_task',
            'title' => elgg_echo('task:add'),
            'text'  => '<i class="fa fa-plus"></i> '.elgg_echo('task:add'),
        ));
        ?>
        </strong>
    </div>
    <div class="col-md-12 text-right margin-top-20">
        <?php echo elgg_view('input/button', array(
            'value' => elgg_echo('back'),
            'data-step' => 1,
            'id' => 'back_step',
            'class' => "btn btn-primary btn-border-blue pull-left button_step",
        ));
        ?>
        <?php echo elgg_view('input/button', array(
            'value' => elgg_echo('next'),
            'data-step' => 3,
            'id' => 'next_step',
            'class' => "btn btn-primary button_step",
        ));
        ?>
    </div>
</div>