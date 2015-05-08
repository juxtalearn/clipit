<?php
$quiz = get_entity(get_input('id_quiz')); 
$id_quiz = get_input("id_quiz");
$view_mode = get_input("mode");

$title = $quiz->name;
elgg_push_breadcrumb($title);

//Cargar la vista del quiz en una página
if ($view_mode == ClipitQuiz::VIEW_MODE_LIST){
    $params = array(
        'content'   => elgg_view("quizzes/list_preview", array('entity' => $quiz, 'id' => $id_quiz)),
        'filter'    => '',
        'title'     => $title,
    );
    
  //Cargar la vista del quiz en varias página
} elseif ($view_mode == ClipitQuiz::VIEW_MODE_PAGED){
    $params = array(
        'content'   => elgg_view("quizzes/paged_preview", array('entity' => $quiz, 'id' => $id_quiz)),
        'filter'    => '',
        'title'     => $title,
    );    
}

$body = elgg_view_layout('content', $params);
echo elgg_view_page($params['title'], $body);
?>
