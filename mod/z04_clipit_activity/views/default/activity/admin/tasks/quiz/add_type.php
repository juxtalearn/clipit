<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   03/11/2014
 * Last update:     03/11/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$type = get_input('type');
$id = get_input('id');
$num = get_input('num');
$tt = get_input('tricky_topic');

if($type == 'question'){
    $question = get_input('question');
    echo elgg_view('activity/admin/tasks/quiz/question', array('num' => $num, 'question' => $question, 'tricky-topic' => $tt));
} else {
    echo elgg_view('activity/admin/tasks/quiz/types/'.$type, array('id' => $id, 'num' => $num));
}
?>
