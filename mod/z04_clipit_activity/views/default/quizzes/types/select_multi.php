<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   21/11/2014
 * Last update:     21/11/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$result = elgg_extract('result', $vars);
$finished = elgg_extract('finished', $vars);
$finished_task = elgg_extract('finished_task', $vars);
$question = elgg_extract('question', $vars);

$i = 1;
foreach($question->option_array as $option):
$checked = '';
if(in_array(($i-1), $result->answer) && $result){
    $checked = 'checked';
}
?>
<label style="font-weight: normal">
    <?php if($finished):?>
        <input type="checkbox" disabled <?php echo in_array(($i-1), $result->answer) ? 'checked' : '';?>/>
        <?php if($question->validation_array[$i-1] && $finished_task):?>
            <strong><?php echo $option;?></strong>
        <?php else:?>
            <?php echo $option;?>
        <?php endif;?>
    <?php else:?>
        <input type="checkbox" value="<?php echo $i;?>" <?php echo $checked;?> name="question[<?php echo $question->id;?>][]" />
        <?php echo $option;?>
    <?php endif;?>
</label>
<?php
$i++;
endforeach;
