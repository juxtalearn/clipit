<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   27/11/2014
 * Last update:     27/11/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$quiz = elgg_extract('entity', $vars);
$user = array_pop(ClipitUser::get_by_id(array($quiz->owner_id)));
$tricky_topic = array_pop(ClipitTrickyTopic::get_by_id(array($quiz->tricky_topic)));
?>
<script>
$(function() {
    var table = $('#quiz-questions');
    elgg.get('ajax/view/questions/summary', {
        data: {
            'quiz': <?php echo $quiz->id;?>
        },
        success: function (content) {
            table.html(content);
        }
    });
});
</script>
<div class="row">
    <div class="col-md-8">
        <div>
            <small class="show"><?php echo elgg_echo('author');?></small>
            <i class="fa-user fa blue"></i>
            <?php echo elgg_view('output/url', array(
                'href'  => "profile/{$user->login}",
                'title' => $user->name,
                'text'  => $user->name,
            ));
            ?>
        </div>
        <small class="show margin-top-10"><?php echo elgg_echo('tricky_topic');?></small>
        <?php echo elgg_view('output/url', array(
            'href'  => "tricky_topics/view/{$tricky_topic->id}",
            'title' => $tricky_topic->name,
            'text'  => $tricky_topic->name,
        ));
        ?>
        <?php if($quiz->description):?>
        <small class="show margin-top-10"><?php echo elgg_echo('description');?></small>
        <div style="max-height: 150px;overflow-y: auto;">
            <?php echo $quiz->description;?>
        </div>
        <?php endif;?>
    </div>
    <div class="col-md-4">
        <div class="margin-bottom-10">
            <?php if($user->id == elgg_get_logged_in_user_guid()):?>
                <?php echo elgg_view('output/url', array(
                    'href'  => "quizzes/edit/{$quiz->id}",
                    'class' => 'btn btn-xs btn-primary',
                    'title' => elgg_echo('edit'),
                    'text'  => '<i class="fa fa-edit"></i>',
                ));
                ?>
                <?php echo elgg_view('output/url', array(
                    'href'  => "action/quiz/remove?id={$quiz->id}",
                    'class' => 'btn btn-xs btn-danger remove-object',
                    'is_action' => true,
                    'title' => elgg_echo('delete'),
                    'text'  => '<i class="fa fa-trash-o"></i>',
                ));
                ?>
            <?php endif;?>
            <?php echo elgg_view('output/url', array(
                'href'  => "quizzes/create/{$quiz->id}",
                'class' => 'btn btn-xs btn-primary btn-border-blue',
                'title' => elgg_echo('duplicate'),
                'text'  => '<i class="fa fa-copy"></i>',
            ));
            ?>
            <span class="margin-left-10">
                <?php echo elgg_view("page/components/print_button");?>
            </span>
        </div>
        <small class="show margin-bottom-10">
            <?php echo elgg_view('output/friendlytime', array('time' => $quiz->time_created));?>
        </small>
        <div class="margin-bottom-10">
            <small class="show">Tipo de vista</small>
            <?php echo elgg_echo('quiz:view_page:'.$quiz->view_mode);?>
        </div>
        <div class="margin-bottom-10">
            <small class="show">Tiempo máximo para hacer el test</small>
            <?php if($quiz->max_time > 0):?>
                <?php if(floor($quiz->max_time / 86000) > 0):?>
                    <?php echo floor($quiz->max_time / 86000);?>
                    <small class="margin-right-10"><?php echo elgg_echo('time:days');?></small>
                <?php endif;?>
                <?php if(floor(($quiz->max_time / 3600) % 24) > 0):?>
                    <?php echo floor(($quiz->max_time / 3600) % 24);?>
                    <small class="margin-right-10"><?php echo elgg_echo('time:hours');?></small>
                <?php endif;?>
                <?php if(floor(($quiz->max_time / 60) % 60) > 0):?>
                    <?php echo floor(($quiz->max_time / 60) % 60);?>
                    <small class="margin-right-10"><?php echo elgg_echo('time:minutes');?></small>
                <?php endif;?>
            <?php else:?>
                <?php echo elgg_echo('quiz:max_time:none');?>
            <?php endif;?>
        </div>
    </div>
</div>

<div>
    <?php echo elgg_view('page/components/title_block', array('title' => elgg_echo('quiz:questions')));?>
    <table class="table" id="quiz-questions">
        <tr>
            <td><i class="fa fa-spinner fa-spin fa-2x blue"></i></td>
        </tr>
    </table>
</div>