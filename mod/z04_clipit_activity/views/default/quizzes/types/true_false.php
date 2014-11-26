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
?>
<?php if($finished):?>
    <label class="inline-block margin-right-20" style="font-weight: normal">
        <input type="radio" disabled <?php echo $result->answer == 'true' ? 'checked' : '';?>/>
        <?php if($question->validation_array[0] == 'true' && $finished_task):?>
            <strong><?php echo elgg_echo('true');?></strong>
        <?php else:?>
            <?php echo elgg_echo('true');?>
        <?php endif;?>
    </label>
    <label class="inline-block margin-right-20" style="font-weight: normal">
        <input type="radio" disabled <?php echo $result->answer == 'false' ? 'checked' : '';?>/>
        <?php if($question->validation_array[0] == 'false' && $finished_task):?>
            <strong><?php echo elgg_echo('false');?></strong>
        <?php else:?>
            <?php echo elgg_echo('false');?>
        <?php endif;?>
    </label>
<?php else:?>
    <label class="inline-block margin-right-20" style="font-weight: normal">
        <input type="radio" <?php echo $result->answer == 'true' ? 'checked' : '';?> name="question[<?php echo $question->id;?>]" value="true"/>
        <?php echo elgg_echo('true');?>
    </label>
    <label class="inline-block" style="font-weight: normal">
        <input type="radio" <?php echo $result->answer == 'false' ? 'checked' : '';?> name="question[<?php echo $question->id;?>]" value="false"/>
        <?php echo elgg_echo('false');?>
    </label>
<?php endif;?>
</div>