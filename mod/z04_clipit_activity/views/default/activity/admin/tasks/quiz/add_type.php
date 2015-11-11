<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   03/11/2014
 * Last update:     03/11/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$type = get_input('type');
$id = get_input('id');
$num = get_input('num');
$tt = get_input('tricky_topic');
$input_prefix = get_input('input_prefix');

switch($type){
    case 'question':
        $question = get_input('question');
        echo elgg_view('activity/admin/tasks/quiz/question', array(
            'parent' => true,
            'num' => $num,
            'question' => $question,
            'tricky-topic' => $tt,
            'input_prefix' => $input_prefix
        ));
        break;
    case 'question_list_clone':
        $question_clones = ClipitQuizQuestion::get_clones($id, true);
        echo elgg_view('activity/admin/tasks/quiz/question/list_clone', array(
            'questions' => $question_clones,
            'id' => $id
        ));
        break;
    case 'question_list_from_tags':
        echo elgg_view('activity/admin/tasks/quiz/question/list_from_tags', array(
            'tricky-topic' => $tt,
            'input_prefix' => $input_prefix
        ));
        break;
    default:
        echo elgg_view('activity/admin/tasks/quiz/types/'.$type, array('id' => $id, 'num' => $num, 'input_prefix' => $input_prefix));
        break;
}