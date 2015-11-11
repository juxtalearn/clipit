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
$finished = elgg_extract('finished', $vars);
$finished_task = elgg_extract('finished_task', $vars);
$question = elgg_extract('question', $vars);
$total_results = array_filter(elgg_extract('total_results', $vars));

if($finished):?>
    <?php if($finished_task):?>
        <?php if($total_results):
            $total_results_count = 0;
        ?>
            <div class="row">
            <?php
            foreach($total_results as $total_result):
                $user_result = array_pop(ClipitUser::get_by_id(array($total_result->owner_id)));
                if($total_result->answer == $question->validation_array[0]) {
                    $total_results_count++;
                    continue;
                }
            ?>
                <div class="col-md-3 margin-bottom-5">
                    <?php
                    echo elgg_view('output/url', array(
                        'href'  => 'profile/'.$user_result->login,
                        'target' => '_blank',
                        'text'  => elgg_view('output/img', array(
                            'src' => get_avatar($user_result, 'small'),
                            'title' => $user_result->name,
                            'class' => 'user-avatar avatar-tiny',
                            'alt' => 'avatar-tiny',
                        )),
                        'title' => $user_result->name,
                    ));
                    ?>
                    <small><?php echo elgg_echo('quiz:question:answered');?>:
                        <strong><?php echo elgg_echo($total_result->answer);?></strong>
                    </small>
                </div>
            <?php endforeach;?>
            </div>
            <hr>
        <?php else: ?>
            <span>
                <?php if($finished_task && $result):?>
                    <?php echo elgg_echo('quiz:question:answered');?>:
                <?php endif;?>
                <?php if($result->correct && $finished_task):?>
                    <strong><?php echo $result->answer;?></strong>
                <?php else:?>
                    <?php echo $result->answer;?>
                <?php endif;?>
            </span>
        <?php endif;?>
        <span class="show margin-top-10">
            <?php echo elgg_echo('quiz:answer:solution');?>:
            <strong><?php echo $question->validation_array[0];?></strong>
            <?php if($total_results_count > 0):?>
                <span class="margin-left-5 text-muted">(<?php echo $total_results_count . ' ' . elgg_echo('students');?>)</span>
            <?php endif;?>
        </span>
    <?php endif;?>
<?php else:?>
    <input
        type="text"
        value="<?php echo $result->answer;?>"
        class="form-control"
        style="width: auto;"
        data-rule-number="true"
        name="question[<?php echo $question->id;?>]"/>
<?php endif;?>