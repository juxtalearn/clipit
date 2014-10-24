<?php
$quiz = get_entity(get_input('id_quiz')); 
$id_quiz = get_input("id_quiz");
$view = get_input("mode");

$title = $quiz->name;

if ($view == "list"){
    $params = array(
        'content'   => elgg_view("quizzes/list_preview", array('entity' => $quiz, 'id' => $id_quiz)),
        'filter'    => '',
        'title'     => $title,
    );
} elseif ($view == "paged"){
    $params = array(
        'content'   => elgg_view("quizzes/paged_preview", array('entity' => $quiz, 'id' => $id_quiz)),
        'filter'    => '',
        'title'     => $title,
    );    
}

$body = elgg_view_layout('content', $params);
echo elgg_view_page($params['title'], $body);
?>
