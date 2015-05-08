<?php

$owner_id = elgg_get_logged_in_user_guid();
$title = "Todas las preguntas"; //Título de la página
elgg_push_breadcrumb($title);   //Inlcuir migas de pan
$content = null;

/* Obtener todas las preguntas existentes y mostrarlas */
$questions = ClipitQuizQuestion::get_all();
foreach($questions as $quest){
    
    //Usuario que ha creado la pregunta
    $user = array_pop(ClipitUser::get_by_id(array($quest->owner_id)));
    //Enlaces para vew, editar y eliminar una pregunta
    $view_quest_url = elgg_get_site_url()."questions/view?id_quest={$quest->id}";
    $edit_quest_url = elgg_get_site_url()."questions/edit?id_quest={$quest->id}";
    $remove_quest_url = elgg_get_site_url()."action/questions/remove?id_quest={$quest->id}";
    
    $content .= '<div id="question" class="content">';
    $content .= '<div id="question-title"><h4><a href="'.$view_quest_url.'" is_action="false" text="'.$quest->name.'">'.$quest->name.'</a></h4></div>';
    $content .= '<div id="question-info">'.$quest->description.'';   //Informacion de la pregunta
    $time_created = elgg_view("output/friendlytime", array('time' => $quest->time_created));
    $content .= '<small class="show">Creado por ';
    $content .= '<span title="Profesor: '.$user->name.'" class="admin-owner" rel="nofollow"><i class="fa fa-fw fa-user"></i>'.$user->name.'</span>';
    $content .= ' '.$time_created.'</small></div>';    //Fin informacion de la pregunta
    
    //Para los quizzes creados por el usuario logeado, se permite editar y eliminar
    if ($owner_id === $quest->owner_id) {
        $content .= '<div id="buttons" class="row" style="margin-top: 5px;">';
        $content .= '<div id="edit-button" class="col-xs-12 col-md-2">';
        $content .= '<a type="button" class="btn btn-primary btn-sm" href="'.$edit_quest_url.'" is_action="false" title="Editar">
                        <i class="fa fa-fw fa-pencil fa-lg" aria-hidden="true"></i> Editar
                    </a>';
        $content .= '</div>';
        $content .= '<div id="delete-button" class="col-xs-12 col-md-2">';
        $content .= (elgg_view("output/url", 
                     array(
                         "type" => "button",
                         "href" => $remove_quest_url, 
                         "is_action" => true,
                         "class" => "btn btn-primary btn-sm",
                         "title" => "Eliminar",
                         "text" => '<i class="fa fa-fw fa-trash-o fa-lg" aria-hidden="true"></i> Eliminar',
                         "onclick" => 'javascript:return confirmar("¿Está seguro de que desea eliminar la pregunta?");',
                         ))
                 . "</div></div>");
    } else {
        $content .= "<br>";
    }//fin IF
    $content .= '</div>';       //Cerrar question
}//FIn for

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