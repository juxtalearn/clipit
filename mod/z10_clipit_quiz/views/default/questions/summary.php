<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   02/12/2014
 * Last update:     02/12/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */

$quiz = get_input('quiz');
$question_ids = ClipitQuiz::get_quiz_questions($quiz);
$questions = ClipitQuizQuestion::get_by_id($question_ids);
?>
<?php if($questions):?>
<table class="table">
    <thead>
    <tr>
        <th><?php echo elgg_echo('title');?></th>
        <th><?php echo elgg_echo('difficulty');?></th>
    </tr>
    </thead>
    <tbody>
    <?php
    $i = 1;
    foreach($questions as $question):
    ?>
    <tr>
        <td>
            <strong class="margin-right-10 pull-left"><?php echo $i;?></strong>
            <div class="content-block">
                <strong>
                <?php echo elgg_view('output/url', array(
                    'href'  => "tricky_topics/examples/view/{$question->id}",
                    'title' => $question->name,
                    'text'  => $question->name,
                ));
                ?>
                </strong>
                <?php if($question->description):?>
                    <small class="show">
                        <?php echo $question->description;?>
                    </small>
                <?php endif;?>
                <?php echo elgg_view('tricky_topic/tags/view', array('tags' => $question->tag_array, 'limit' => 5)); ?>
            </div>
        </td>
        <td><?php echo difficulty_bar($question->difficulty);?></td>
    </tr>
    <?php
    $i++;
    endforeach;
    ?>
    </tbody>
</table>
<?php else: ?>
    <?php echo elgg_view('output/empty', array('value' => elgg_echo('examples:none')));;?>
<?php endif;?>