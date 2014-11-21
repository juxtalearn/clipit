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
    <?php if($result->answer):?>
        <div style="padding: 10px; background: #fafafa;">
            <?php echo nl2br($result->answer);?>
        </div>
    <?php endif;?>
<?php else:?>
    <?php echo elgg_view("input/plaintext", array(
        'name'  => 'question['.$question->id.']',
        'class' => 'form-control',
        'value' => $result->answer ? $result->answer : '',
        'rows' => 5
    ));
    ?>
<?php endif;?>