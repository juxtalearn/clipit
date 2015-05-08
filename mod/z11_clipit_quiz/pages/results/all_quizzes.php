<?php
// Página que muestra todos lo quizzes a realizar por el alumno
$title = "Todos los Quizzes";
elgg_push_breadcrumb($title);
$content = null;

$quizzes = ClipitQuiz::get_all();
foreach($quizzes as $quiz){
    
    $author = array_pop(ClipitUser::get_by_id(array($quiz->owner_id)));
    $view_quiz_url = elgg_get_site_url()."results/index_quiz?id_quiz={$quiz->id}";
    
    $content .= '<div id="quiz" class="content">';
    $content .= '<div id="quiz-title"><h4><a href="'.$view_quiz_url.'" is_action="false" text="'.$quiz->name.'">'.$quiz->name.'</a></h4></div>';
    $content .= '<div id="quiz-info">'.$quiz->description.'';   //Informacion del quiz
    $time_created = elgg_view("output/friendlytime", array('time' => $quiz->time_created));
    $content .= '<small class="show">Creado por ';
    $content .= '<span title="Profesor: '.$quiz->author_name.'" class="admin-owner" rel="nofollow"><i class="fa fa-fw fa-user"></i>'.$quiz->author_name.'</span>';
    $content .= ' '.$time_created.'</small></div>';    //Fin informacion del quiz
    $content .= '</div>';       //Cerrar quiz
    
}//FIN for

$params = array(
    'content'   => $content,
    'filter'    => '',
    'title'     => $title,
);

$body = elgg_view_layout('content', $params);
echo elgg_view_page($body['title'], $body);

?>