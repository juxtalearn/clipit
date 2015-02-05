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
$quizzes = elgg_extract('entities', $vars);
$count = elgg_extract('count', $vars);
?>
<div class="margin-bottom-20">
    <div class="pull-right">
        <?php echo elgg_view("page/components/print_button");?>
    </div>
    <?php echo elgg_view('output/url', array(
        'href'  => "quizzes/create",
        'class' => 'btn btn-primary margin-bottom-10',
        'title' => elgg_echo('new'),
        'text'  => elgg_echo('new'),
    ));
    ?>
</div>
<script>
$(function(){
    $(document).on("click", ".show-questions", function(){
        var tr = $(this).closest("tr")
            id = $(this).attr("id"),
            tr_quiz = $("[data-quiz="+id+"]");
        if(tr_quiz.length > 0){
            tr_quiz.toggle();
            return false;
        }
        elgg.get('ajax/view/questions/summary',{
            data: {
                quiz: id
            },
            success: function(content){
                var container = $("<tr/>")
                    .attr("data-quiz", id)
                    .html( $('<td/>').attr("colspan", 5).html(content).css("padding", "10px") );
                tr.after(container);
            }
        });
    });
});
</script>
<table class="table table-striped">
    <thead>
    <tr>
        <th><?php echo elgg_echo('title');?></th>
        <th><?php echo elgg_echo('tricky_topic');?></th>
        <th><?php echo elgg_echo('author');?>-<?php echo elgg_echo('date');?></th>
        <th style="width: 100px;"><?php echo elgg_echo('options');?></th>
        <th class="text-right"><?php echo elgg_echo('quiz:questions');?></th>
    </tr>
    </thead>
    <?php
    foreach($quizzes as $quiz):
        $user = array_pop(ClipitUser::get_by_id(array($quiz->owner_id)));
        $questions = ClipitQuiz::get_quiz_questions($quiz->id);
        $tricky_topic = array_pop(ClipitTrickyTopic::get_by_id(array($quiz->tricky_topic)));
    ?>
        <tr>
            <td>
                <strong>
                    <?php echo elgg_view('output/url', array(
                        'href'  => "quizzes/view/{$quiz->id}",
                        'title' => $quiz->name,
                        'text'  => $quiz->name,
                    ));
                    ?>
                </strong>
            </td>
            <td>
                <?php if($tricky_topic):?>
                <?php echo elgg_view('output/url', array(
                    'href'  => "tricky_topics/view/{$tricky_topic->id}",
                    'title' => $tricky_topic->name,
                    'text'  => $tricky_topic->name,
                ));
                ?>
                <?php endif;?>
            </td>
            <td>
                <small>
                    <div>
                        <i class="fa-user fa blue"></i>
                        <?php echo elgg_view('output/url', array(
                            'href'  => "profile/{$user->login}",
                            'title' => $user->name,
                            'text'  => $user->name,
                        ));
                        ?>
                    </div>
                    <?php echo elgg_view('output/friendlytime', array('time' => $quiz->time_created));?>
                </small>
            </td>
            <td>
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
            </td>
            <td class="text-right">
                <?php echo elgg_view('output/url', array(
                    'href'  => 'javascript:;',
                    'class' => 'show-questions btn btn-xs btn-border-blue',
                    'id' => $quiz->id,
                    'text'  => '<strong>'.count($questions).'</strong> <i class="margin-left-5 fa fa-comments"></i>',
                ));
                ?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?php echo clipit_get_pagination(array('count' => $count, 'limit' => 10)); ?>