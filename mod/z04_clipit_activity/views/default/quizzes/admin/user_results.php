<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   20/11/2014
 * Last update:     20/11/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$user = elgg_extract('user', $vars);
$quiz_id = elgg_extract('quiz_id', $vars);
?>
<li class="list-item-5">
    <div class="pull-right">
        <?php
        if($vars['type'] == 'pending') {
            echo '<small>';
            $quiz_start = ClipitQuiz::get_quiz_start($quiz_id, $user->id);
            $max_time = array_pop(ClipitQuiz::get_properties($quiz_id, array('max_time')));
            if ($quiz_start) {
                echo elgg_view('output/friendlytime', array('time' => $quiz_start + $max_time));
                echo ' <i class="fa fa-clock-o"></i> ';
            } else {
                echo elgg_echo('quiz:not_started');
            }
            echo '</small>';
        } else {
            if($vars['subtype'] === 'not_answered'){
                echo '<small class="margin-right-10">'.elgg_echo('quiz:question:not_answered').'</small>';
            } else {
                echo elgg_view('output/url', array(
                    'title' => elgg_echo('view'),
                    'text' => elgg_echo('view'),
                    'class' => 'view-answer btn btn-xs btn-primary',
                    'id' => $user->id,
                    'href' => "javascript:;",
                ));
            }
        }
        ?>
    </div>
    <strong>
        <?php echo elgg_view('output/img', array(
            'src' => get_avatar($user, 'small'),
            'class' => 'avatar-tiny margin-right-5',
            'alt' => 'avatar-tiny',
        ));?>
        <?php echo elgg_view("messages/compose_icon", array('entity' => $user));?>
        <?php echo elgg_view('output/url', array(
            'text' => $user->name,
            'href' => "profile/".$user->login,
        ));
        ?>
    </strong>
    <div class="answer" style="display:none;padding: 10px;padding-right: 0;"></div>
</li>