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
elgg_load_js("jquery:timepicker");
elgg_load_js("fullcalendar:moment");
?>
<script>
    <?php echo elgg_view('js/task_templates');?>
</script>

<div style="display: none;" id="step_2" class="row step">
    <div class="col-md-12">
        <div class="bg-info" style="background: #f4f4f4">
            <?php echo elgg_echo('task:template:title');?>:
            <select id="select-task-template" class="form-control margin-top-10" style="padding: 5px;width: auto;">
                <option value="" selected><?php echo elgg_echo('task:template:select');?></option>
            </select>
        </div>
    </div>
    <ul class="task-list"></ul>
    <div class="col-md-12 margin-top-5 margin-bottom-5">
        <strong>
        <?php echo elgg_view('output/url', array(
            'href'  => "javascript:;",
            'id' => 'add_task',
            'class' => 'btn btn-xs btn-primary',
            'title' => elgg_echo('task:add'),
            'text'  => '<i class="fa fa-plus"></i> '.elgg_echo('task:add'),
        ));
        ?>
        </strong>
    </div>
    <div class="col-md-12 text-right margin-top-20">
        <hr>
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
<script>
    clipit.task.getTemplates();
</script>