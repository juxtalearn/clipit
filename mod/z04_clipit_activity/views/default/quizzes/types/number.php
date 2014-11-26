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

if($finished):?>
    <?php if($result->correct && $finished_task):?>
        <strong><?php echo $result->answer;?></strong>
    <?php else:?>
        <?php echo $result->answer;?>
    <?php endif;?>
    <?php if(!$result->correct && $finished_task):?>
        <small class="show">Solución: <strong><?php echo $question->validation_array[0];?></strong></small>
    <?php endif;?>
<?php else:?>
    <input type="number" value="<?php echo $result->answer;?>" class="form-control" style="width: auto;" name="question[<?php echo $question->id;?>]"/>
<?php endif;?>