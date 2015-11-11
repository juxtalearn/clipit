<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   21/11/2014
 * Last update:     21/11/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$result = elgg_extract('result', $vars);
$total_results = elgg_extract('total_results', $vars);
$finished = elgg_extract('finished', $vars);
$finished_task = elgg_extract('finished_task', $vars);
$question = elgg_extract('question', $vars);

$total_results_text_true = '';
$total_results_count_true = 0;
$total_results_text_false = '';
$total_results_count_false = 0;
if($total_results){
    foreach($total_results as $total_result){
        if($total_result->answer[0]) {
            $total_results_count_true++;
        }elseif($total_result->answer[1]) {
            $total_results_count_false++;
        }
    }
    if($total_results_count_true > 0) {
        $total_results_text_true = '<span class="margin-left-5 text-muted">(' . $total_results_count_true . ' ' . elgg_echo('students') . ')</span>';
    }
    if($total_results_count_false > 0) {
        $total_results_text_false = '<span class="margin-left-5 text-muted">(' . $total_results_count_false . ' ' . elgg_echo('students') . ')</span>';
    }
}
?>
<?php if($finished):?>
    <label style="font-weight: normal">
        <input type="radio" disabled <?php echo $result->answer[0] ? 'checked' : '';?>/>
        <?php if($question->validation_array[0] && $finished_task):?>
            <strong><?php echo elgg_echo('true');?></strong>
        <?php else:?>
            <?php echo elgg_echo('true');?>
        <?php endif;?>
        <?php echo $total_results_text_true;?>
    </label>
    <label style="font-weight: normal">
        <input type="radio" disabled <?php echo $result->answer[1] ? 'checked' : '';?>/>
        <?php if($question->validation_array[1] && $finished_task):?>
            <strong><?php echo elgg_echo('false');?></strong>
        <?php else:?>
            <?php echo elgg_echo('false');?>
        <?php endif;?>
        <?php echo $total_results_text_false;?>
    </label>
<?php else:?>
    <label style="font-weight: normal">
        <input type="radio" <?php echo $result->answer[0] ? 'checked' : '';?> name="question[<?php echo $question->id;?>]" value="true"/>
        <?php echo elgg_echo('true');?>
    </label>
    <label style="font-weight: normal">
        <input type="radio" <?php echo $result->answer[1]? 'checked' : '';?> name="question[<?php echo $question->id;?>]" value="false"/>
        <?php echo elgg_echo('false');?>
    </label>
<?php endif;?>
