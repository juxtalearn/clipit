<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   10/11/2014
 * Last update:     10/11/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$id = uniqid('question_');
$num = elgg_extract('num', $vars);
$tricky_topic = elgg_extract('tricky-topic', $vars);
$question = elgg_extract('question', $vars);
$input_prefix = elgg_extract('input_prefix', $vars);
$tt_tags = ClipitTrickyTopic::get_tags($tricky_topic);
?>
<li class="row margin-bottom-10 question" data-id="<?php echo $id;?>">
    <div class="col-xs-1 text-right">
        <h3 class="text-muted margin-0 margin-top-5 question-num">
            <?php echo $num;?>.
        </h3>
    </div>
    <div class="col-xs-11">
        <div style="padding: 10px; background: #fafafa;">
            <div class="pull-right">
                <?php if($question->video): ?>
                    <i class="fa fa-youtube-play blue btn-xs" style="font-size: 14px;"></i>
                <?php endif;?>
                <?php if($question->image): ?>
                    <i class="fa fa-image blue btn-xs" style="font-size: 14px;"></i>
                <?php endif;?>
                <?php echo elgg_view('output/url', array(
                    'href'  => "javascript:;",
                    'class' => 'btn btn-primary btn-xs margin-left-10',
                    'text'  => elgg_echo('edit'),
                    'onclick' =>'$(this).closest(\'.question\').find(\'.question-edit\').toggle();',
                ));
                ?>
                <?php echo elgg_view('output/url', array(
                    'href'  => "javascript:;",
                    'class' => 'btn btn-danger btn-xs',
                    'text'  => elgg_echo('delete'),
                    'aria-label' => elgg_echo('delete'),
                    'onclick' => '$(this).closest(\'.question\').remove();',
                ));
                ?>
                <i title="<?php echo elgg_echo('duplicate');?>" class="fa fa-files-o text-muted margin-left-20 cursor-pointer clone-question"></i>
                <i class="fa fa-arrows-v text-muted margin-left-10 reorder-question"></i>
            </div>
            <span><strong><?php echo $question->name;?></strong></span>
            <div id="question_<?php echo $question->id;?>" class="question-edit" style="display: none">
                <?php echo elgg_view('activity/admin/tasks/quiz/question', array(
                    'num' => false,
                    'tricky-topic' => $tricky_topic,
                    'question' => $question,
                    'input_prefix' => $input_prefix
                ));?>
            </div>
        </div>
    </div>
</li>