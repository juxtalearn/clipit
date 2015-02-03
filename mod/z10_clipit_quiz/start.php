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
    $plugin_dir = elgg_get_plugins_path() . "z10_clipit_quiz";
    // Quiz
    elgg_register_action("quiz/save", "{$plugin_dir}/actions/quiz/save.php");
    elgg_register_action("quiz/remove", "{$plugin_dir}/actions/quiz/remove.php");
    // Questions
    elgg_register_ajax_view('questions/summary');
    elgg_register_ajax_view('questions/examples');
}

/**
 * @param $page
 */
function quiz_page_handler($page){
    $filter = '';
    switch($page[0]){
        case '':
            $title = elgg_echo('quizzes');
            $selected_tab = get_input('filter', 'all');
            $filter = elgg_view('quiz/filter', array('selected' => $selected_tab, 'href' => $page[0]));
            $sidebar = elgg_view_module('aside', elgg_echo('filter'),
                elgg_view_form(
                    'quizzes',
                    array(
                        'disable_security' => true,
                        'action' => 'quizzes',
                        'method' => 'GET',
                        'id' => 'add_labels',
                        'style' => 'background: #fff;padding: 15px;',
                        'body' => elgg_view('forms/quiz/filter')
                    )
                ));
            $entities = ClipitQuiz::get_all();
            $count = count($entities);
            $entities = array_slice($entities, clipit_get_offset(), clipit_get_limit(10));
            $content = elgg_view('quiz/list', array('entities' => $entities, 'count' => $count));
            break;
        case 'edit':
            // Edit Quiz
            if(!$id = $page[1]){
                return false;
            }
            $quiz = array_pop(ClipitQuiz::get_by_id(array($id)));
            $filter = '';
            elgg_push_breadcrumb(elgg_echo('quizzes'), "quizzes");
            elgg_push_breadcrumb($quiz->name, "quizzes/view/{$quiz->id}");
            $title = elgg_echo('edit');
            elgg_push_breadcrumb($title);
            $content = elgg_view_form('quiz/save',
                array('data-validate' => 'true'),
                array('entity' => $quiz, 'submit_value' => elgg_echo('save')
                ));
            break;
        case 'questions':
            elgg_push_breadcrumb(elgg_echo('quizzes'), "quizzes");
            switch($page[1]){
                case 'view':
                    $id = $page[2];
                    if(!$id){
                        return false;
                    }
                    elgg_push_breadcrumb(elgg_echo('quiz:questions'), "quizzes/questions");
                    if ($question = array_pop(ClipitQuizQuestion::get_by_id(array($id)))) {
                        $title = $question->name;
                        elgg_push_breadcrumb($title);
                        $content = elgg_view('quiz/questions/view', array('entity' => $question));
                    } else{
                        return false;
                    }
                    break;
            }
            break;
        case 'create':
            $title = elgg_echo('quiz:create');
            elgg_push_breadcrumb(elgg_echo('quizzes'), "quizzes");
            elgg_push_breadcrumb($title);
            $content = elgg_view_form('quiz/save',
                array('data-validate' => 'true'),
                array('submit_value' => elgg_echo('create'))
            );
            if($id = $page[1]){
                $quiz_id = ClipitQuiz::create_clone($id);
                $quiz = array_pop(ClipitQuiz::get_by_id(array($quiz_id)));
                elgg_pop_breadcrumb($title);
                elgg_push_breadcrumb($quiz->name, "quizzes/view/{$quiz->id}");
                $title = elgg_echo('duplicate');
                elgg_push_breadcrumb($title);
                $content = elgg_view_form('quiz/save',
                    array('data-validate' => 'true'),
                    array(
                        'entity' => $quiz,
                        'submit_value' => elgg_echo('create')
                    ));
            }
            break;
        default:
            return false;
            break;
    }
    $params = array(
        'content' => $content,
        'title' => $title,
        'filter' => $filter,
        'sidebar' => $sidebar,
    );
    $body = elgg_view_layout('one_sidebar', $params);

    echo elgg_view_page($title, $body);
}