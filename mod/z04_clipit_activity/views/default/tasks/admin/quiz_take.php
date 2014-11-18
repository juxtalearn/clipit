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
?>
<style>
    .multimedia-preview .img-preview{
        width: 65px;
        max-height: 65px;
    }
    .multimedia-preview img {
        width: 100%;
    }
    .task-status{
        display: none;
    }
</style>
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
        $(document).on("click", "#panel-expand-all",function(){
            $(".expand").parent(".panel").find(".panel-collapse").collapse('show');
            $(".user-rating").click();
        });
        $(document).on("click", "#panel-collapse-all",function(){
            $(".expand").parent(".panel").find(".panel-collapse").collapse('hide');
        });
        $(document).on("click", ".user-rating",function(){
            var content = $(this).parent(".panel").find(".panel-body");
            var us_id = $(this).data("user");
            if(content.is(':empty')){
                content.html('<i class="fa fa-spinner fa-spin fa-2x blue"></i>');
                $.get( elgg.config.wwwroot+"ajax/view/quizzes/admin/results", {quiz: <?php echo $quiz->id;?>, user_id: us_id}, function( data ) {
                    content.html(data);
                });
            }
        });
        var hash = window.location.hash.replace('#', '');
        var collapse = $("[href='#user_"+hash+"']");
        if(collapse.length > 0){
            collapse.click();
        }

    });
</script>
<p>
    <?php echo elgg_view('output/url', array(
        'title' => elgg_echo('expand:all'),
        'text' => elgg_echo('expand:all'),
        'href' => "javascript:;",
        'id' => 'panel-expand-all',
    ));
    ?>
    <span class="text-muted">|</span>
    <?php echo elgg_view('output/url', array(
        'title' => elgg_echo('collapse:all'),
        'text' => elgg_echo('collapse:all'),
        'href' => "javascript:;",
        'id' => 'panel-collapse-all',
    ));
    ?>
</p>
<div class="panel-group" id="accordion_users">
<?php
foreach($users as $user):
    $status = ClipitTask::get_completed_status($task->id, $user->id);
    ?>
    <div class="panel panel-blue">
        <a name="<?php echo $user->id;?>"></a>
        <div class="panel-heading cursor-pointer expand user-rating" data-user="<?php echo $user->id;?>" style="padding: 10px;">
            <div class="pull-right blue">
                <span class="text-muted margin-right-5">
                <?php
                $quiz_start = ClipitQuiz::get_quiz_start($quiz->id, $user->id);
                if($quiz_start && !ClipitQuiz::has_finished_quiz($quiz->id, $user->id)){
                    echo date("H:s, d/m/Y", $quiz_start + $quiz->max_time);
                } elseif(ClipitQuiz::has_finished_quiz($quiz->id, $user->id)){
                    echo elgg_echo('quiz:finished');
                } else {
                    echo elgg_echo('quiz:not_started');
                }
                ?>
                </span>
                <?php echo elgg_view("messages/compose_icon", array('entity' => $user));?>
                <strong>
                    <?php echo elgg_view('tasks/icon_entity_status', array('status' => $status));?>
                </strong>
            </div>
            <h4 class="panel-title blue" data-toggle="collapse" data-parent="#accordion_users" href="#user_<?php echo $user->id;?>">
                <?php echo elgg_view('output/img', array(
                    'src' => get_avatar($user, 'small'),
                    'class' => 'avatar-tiny margin-right-5'
                ));?>
                <?php echo $user->name;?>
            </h4>
        </div>
        <div id="user_<?php echo $user->id;?>" class="panel-collapse collapse">
            <div class="panel-body"></div>
        </div>
    </div>
<?php endforeach;?>
</div>