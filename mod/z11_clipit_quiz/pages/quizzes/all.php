<?php
$user_logged = elgg_get_logged_in_user_guid();
$title = "Todos los Quizzes";
elgg_push_breadcrumb($title);   //Inlcuir migas de pan
$content = null;

$quizzes = ClipitQuiz::get_all();
foreach($quizzes as $quiz){
    
    $author = array_pop(ClipitUser::get_by_id(array($quiz->owner_id)));
    $view_quiz_url = elgg_get_site_url()."quizzes/view?id_quiz={$quiz->id}";
    $edit_quiz_url = elgg_get_site_url()."quizzes/edit?id_quiz={$quiz->id}";
    $remove_quiz_url = elgg_get_site_url()."action/quizzes/remove?id_quiz={$quiz->id}";
    
    $content .= '<div id="quiz" class="content">';
    $content .= '<div id="quiz-title"><h4><a href="'.$view_quiz_url.'" is_action="false" text="'.$quiz->name.'">'.$quiz->name.'</a></h4></div>';
    $content .= '<div id="quiz-info">'.$quiz->description.'';   //Informacion del quiz
    $time_created = elgg_view("output/friendlytime", array('time' => $quiz->time_created));
    $content .= '<small class="show">Creado por ';
    $content .= '<span title="Profesor: '.$quiz->author_name.'" class="admin-owner" rel="nofollow"><i class="fa fa-fw fa-user"></i>'.$quiz->author_name.'</span>';
    $content .= ' '.$time_created.'</small></div>';    //Fin informacion del quiz
   
   //Para los quizzes creados por el usuario logeado, se permite editar y eliminar
   if ($user_logged == $author->id) {
       $content .= '<div id="buttons" class="row" style="margin-top: 5px;">';
       $content .= '<div id="edit-button" class="col-xs-12 col-md-2">';
       $content .= '<a type="button" class="btn btn-primary btn-sm" href="'.$edit_quiz_url.'" is_action="false" title="Editar">
                        <i class="fa fa-fw fa-pencil fa-lg" aria-hidden="true"></i> Editar
                    </a>';
       $content .= '</div>';
       $content .= '<div id="delete-button" class="col-xs-12 col-md-2">';
       $content .= (elgg_view("output/url", 
                    array(
                        "type" => "button",
                        "href" => $remove_quiz_url, 
                        "is_action" => true,
                        "class" => "btn btn-primary btn-sm",
                        "title" => "Eliminar",
                        "text" => '<i class="fa fa-fw fa-trash-o fa-lg" aria-hidden="true"></i> Eliminar',
                        "onclick" => 'javascript:return confirmar("¿Está seguro de que desea eliminar el quiz?");',
                        ))
                . "</div></div>");
   } else {
            $content .= "<br>";
   }//fin IF
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

<script language="JavaScript">
    function confirmar (mensaje) {
        return confirm(mensaje);
    } 
</script>