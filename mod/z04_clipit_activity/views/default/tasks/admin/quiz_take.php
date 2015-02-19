<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   24/07/14
 * Last update:     24/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$activity = elgg_extract('activity', $vars);
$task = elgg_extract('task', $vars);
$quiz = elgg_extract('quiz', $vars);
$entities_ids = array_keys($entities);
$users = elgg_extract('entities', $vars);
$users = ClipitUser::get_by_id($users);
$groups = ClipitActivity::get_groups($activity->id);
elgg_load_js('jquery:chartjs');
?>
<script>
    $(function(){
        $(document).on("click", ".save-annotation", function(){
            var container = $(this).parent(".annotate"),
                form = $(this).closest("form");
            tinymce.triggerSave();
            elgg.action(form.attr("action"), {
                data: form.serialize(),
                success: function(){
                    container.slideToggle();
                }
            });
        });
//

        $(".show-questions").on("click", function() {
            var that = $(this),
                user_id = that.closest('li').data('entity'),
                content = that.closest('li').find('.questions');
            if(content.is(':empty')) {
                content.html('<i class="fa fa-spinner fa-spin fa-2x blue"></i>');
                elgg.get("ajax/view/quizzes/admin/results", {
                    data: {
                        quiz: <?php echo $quiz->id;?>,
                        type: 'results',
                        user: user_id
                    },
                    success: function (data) {
                        content.html(data);
                    }
                });
            }
        });
        $(".show-chart").on("click", function() {
            var that = $(this),
                user_id = that.closest('li').data('entity'),
                content = that.closest('li').find('.chart');
            if(content.is(':empty')) {
                content.html('<i class="fa fa-spinner fa-spin fa-2x blue"></i>');
                elgg.get("ajax/view/quizzes/admin/results", {
                    data: {
                        quiz: <?php echo $quiz->id;?>,
                        type: 'chart',
                        user: user_id
                    },
                    success: function (data) {
                        content.html(data);
                    }
                });
            }
        });
        $(".show-data").on("click", function() {
            var that = $(this),
                id = that.attr('href'),
                entity_id = that.closest('li').data('entity'),
                content = $(id);
            if(content.is(':empty')) {
                content.html('<i class="fa fa-spinner fa-spin fa-2x blue"></i>');
                elgg.get("ajax/view/quizzes/admin/results", {
                    data: {
                        quiz: <?php echo $quiz->id;?>,
                        type: 'result_'+ that.data('entity-type'),
                        entity: entity_id,
                        entity_type: that.data('type')
                    },
                    success: function (data) {
                        content.html(data);
                    }
                });
            }
        });
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var id = $(this).attr('href'),
                container = $(id).find('li');
            if(container.find('.status').is(':hidden')) {
                elgg.get("ajax/view/quizzes/admin/results", {
                    dataType: "json",
                    data: {
                        quiz: <?php echo $quiz->id;?>,
                        count: true,
                        type: id.replace('#', '')
                    },
                    success: function (output) {
                        $.each(output, function (i, data) {
                            if(data.not_finished) {
                                container.eq(i).find(".msg-not-finished").text(data.not_finished);
                            } else {
                                container.eq(i).find(".counts").show();
                                container.eq(i).find(".a-error").text(data.error);
                                container.eq(i).find(".a-correct").text(data.correct);
                                container.eq(i).find(".a-pending").text(data.pending);
                            }
                        });
                    }
                });
            }
        });
        // Start first tab
        $('a[data-toggle="tab"]:first').tab('show');

    });
</script>
<div role="tabpanel">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation">
            <a href="#students" aria-controls="profile" role="tab" data-toggle="tab"><?php echo elgg_echo('students');?></a>
        </li>
        <?php if($groups):?>
        <li role="presentation">
            <a href="#groups" aria-controls="groups" role="tab" data-toggle="tab"><?php echo elgg_echo('groups');?></a>
        </li>
        <?php endif;?>
        <li role="presentation">
            <a href="#activity" aria-controls="activity" role="tab" data-toggle="tab"><?php echo elgg_echo('activity');?></a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane margin-top-10 active" id="students" style="padding: 10px;">
            <ul>
            <?php
            $students = ClipitUser::get_by_id($activity->student_array);
            foreach($students as $student):
            ?>
                <li class="list-item" data-entity="<?php echo $student->id;?>">
                    <div class="pull-right">
                        <div class="margin-right-10 inline-block status">
                            <small class="msg-not-finished"></small>
                            <div class="counts" style="display: none;">
                                <small class="margin-right-10">
                                    <i class="fa fa-times red"></i> <strong class="a-error">-</strong>
                                </small>
                                <small class="margin-right-10">
                                    <i class="fa fa-check green"></i> <strong class="a-correct">-</strong>
                                </small>
                                <small class="margin-right-10">
                                    <i class="fa fa-minus yellow"></i> <strong class="a-pending">-</strong>
                                </small>
                            </div>
                        </div>
                        <span class="pull-right">
                            <a href="#questions-<?php echo $student->id;?>"
                               class="show-data btn-primary btn btn-xs btn-icon fa-comments fa btn-border-blue"
                               data-type="student"
                               data-entity-type="questions"
                               data-toggle="collapse"
                                ></a>
                            <a href="#chart-<?php echo $student->id;?>"
                               class="show-data margin-left-10 btn-icon btn-border-blue btn btn-xs fa fa-bar-chart-o"
                               data-toggle="collapse"
                               data-type="student"
                               data-entity-type="chart"
                               aria-expanded="false"
                                ></a>
                        </span>
                    </div>
                    <?php echo elgg_view("page/elements/user_block", array("entity" => $student)); ?>
                    <div class="clearfix"></div>
                    <div>
                        <div class="collapse margin-top-10 chart" style="margin-left: 35px;" id="chart-<?php echo $student->id;?>"></div>
                        <div class="collapse margin-top-10 questions" id="questions-<?php echo $student->id;?>"></div>
                    </div>
                </li>
            <?php endforeach;?>
            </ul>
        </div>
        <?php if($groups):?>
        <div role="tabpanel" class="tab-pane margin-top-10" id="groups" style="padding: 10px;">
            <ul>
                <?php foreach(ClipitGroup::get_by_id($groups) as $group):?>
                <li class="list-item" data-entity="<?php echo $group->id;?>">
                    <div class="pull-right">
                        <div class="margin-right-10 inline-block status">
                            <small class="msg-not-finished"></small>
                            <div class="counts" style="display: none;">
                                <small class="margin-right-10">
                                    <i class="fa fa-times red"></i> <strong class="a-error">-</strong>
                                </small>
                                <small class="margin-right-10">
                                    <i class="fa fa-check green"></i> <strong class="a-correct">-</strong>
                                </small>
                                <small class="margin-right-10">
                                    <i class="fa fa-minus yellow"></i> <strong class="a-pending">-</strong>
                                </small>
                            </div>
                        </div>
                        <span class="pull-right">
                            <a href="#questions-<?php echo $group->id;?>"
                               class="show-data btn-primary btn btn-xs btn-icon fa-comments fa btn-border-blue"
                               data-type="group"
                               data-entity-type="questions"
                               data-toggle="collapse"
                                ></a>
                            <a href="#chart-<?php echo $group->id;?>"
                               class="show-data margin-left-10 btn-icon btn-border-blue btn btn-xs fa fa-bar-chart-o"
                               data-toggle="collapse"
                               data-type="group"
                               data-entity-type="chart"
                               aria-expanded="false"></a>
                        </span>
                    </div>
                    <?php
                        echo elgg_view("page/components/modal_remote", array('id'=> "group-{$group->id}" ));
                        echo elgg_view('output/url', array(
                            'href'  => "ajax/view/modal/group/view?id={$group->id}",
                            'text'  => '<i class="fa fa-users"></i> '.$group->name,
                            'title' => $group->name,
                            'data-toggle'   => 'modal',
                            'data-target'   => '#group-'.$group->id
                        ));
                    ?>
                    <small class="show">
                        <?php echo count($group->user_array);?> <?php echo elgg_echo('students');?>
                    </small>
                    <div class="clearfix"></div>
                    <div>
                        <div class="collapse margin-top-10 chart" style="margin-left: 35px;" id="chart-<?php echo $group->id;?>"></div>
                        <div class="collapse margin-top-10 questions" id="questions-<?php echo $group->id;?>"></div>
                    </div>
                </li>
                <?php endforeach;?>
            </ul>
        </div>
        <?php endif;?>
        <div role="tabpanel" class="tab-pane margin-top-10" id="activity" style="padding: 10px;">
            <ul>
                <li data-entity="<?php echo $activity->id;?>">
                <a href="#questions-<?php echo $activity->id;?>"
                   class="show-data btn-primary btn btn-xs btn-icon btn-border-blue"
                   data-type="activity"
                   data-entity-type="questions"
                   data-toggle="collapse"
                    ><i class="fa-comments fa"></i> <?php echo elgg_echo('quiz:questions');?></a>
                <a href="#chart-<?php echo $activity->id;?>"
                   class="show-data margin-left-10 btn-primary btn btn-xs btn-icon btn-border-blue"
                   data-toggle="collapse"
                   data-type="activity"
                   data-entity-type="chart"
                   aria-expanded="false"><i class="fa-bar-chart-o fa"></i> <?php echo elgg_echo('stats');?></a>
                <div>
                    <div class="collapse margin-top-10 chart" style="margin-left: 35px;" id="chart-<?php echo $activity->id;?>"></div>
                    <div class="collapse margin-top-10 questions" id="questions-<?php echo $activity->id;?>"></div>
                </div>
                </li>
            </ul>
        </div>
    </div>

</div>

<div>
<!--    --><?php //echo elgg_view('widgets/quizresult/content');?>
</div>
