<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   20/05/14
 * Last update:     20/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
elgg_register_event_handler('init', 'system', 'clipit_quiz_init');

function clipit_quiz_init() {
    // Register "/quizzes" page handler
    elgg_register_page_handler('quizzes', 'quiz_page_handler');
}

/**
 * @param $page
 */
function quiz_page_handler($page){

    $title = "Quiz creation";
    switch($page[0]){
        case '':
            $title = elgg_echo('quizzes');
            $content = elgg_view('quiz/view');
            break;
        default:
            return false;
            break;
    }
    $params = array(
        'content' => $content,
        'title' => $title,
        'filter' => "",
    );
    $body = elgg_view_layout('one_column', $params);

    echo elgg_view_page($title, $body);
}