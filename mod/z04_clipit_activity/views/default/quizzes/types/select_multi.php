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
$options = $question->option_array;

$random = elgg_extract('random', $vars);
// Random answers
if($random) {
    uksort($options, function () {
        return rand() > rand();
    });
}

foreach($options as $key => $option):
    $checked = '';
    if ($result->answer[$key]) {
        $checked = 'checked';
    }
    $total_results_text = '';
    $total_results_count = 0;
    if($total_results){
        foreach($total_results as $total_result){
            if($total_result->answer[$key]) {
                $total_results_count++;
            }
        }
        if($total_results_count > 0) {
            $total_results_text = '<span class="margin-left-5 text-muted">(' . $total_results_count . ' ' . elgg_echo('students') . ')</span>';
        }
    }
?>
<label style="font-weight: normal">
    <?php if($finished):?>
        <input type="checkbox" disabled <?php echo $checked;?>/>
        <?php if($question->validation_array[$key] && $finished_task):?>
            <strong><?php echo $option;?></strong>
        <?php else:?>
            <?php echo $option;?>
        <?php endif;?>
        <?php echo $total_results_text;?>
    <?php else:?>
        <input type="checkbox" value="<?php echo $key+1;?>" <?php echo $checked;?> name="question[<?php echo $question->id;?>][]" />
        <?php echo $option;?>
    <?php endif;?>
</label>
<?php
endforeach;
