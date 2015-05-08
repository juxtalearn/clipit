<?php
$quiz = get_entity(get_input('id_quiz'));
$id_quiz = get_input("id_quiz");

$id_array[] = $id_quiz;
$questions = ClipitQuiz::get_quiz_questions($id_quiz);

$title = $quiz->name;
elgg_push_breadcrumb($title);   //Inlcuir migas de pan

$params = array(
    'content'   => elgg_view("quizzes/view", array('entity' => $quiz, 'id' => $id_quiz,
                                'quest_array' => $questions)),
    'filter'    => '',
    'title'     => $title,
);
$body = elgg_view_layout('content', $params);
echo elgg_view_page($params['title'], $body);

?>
