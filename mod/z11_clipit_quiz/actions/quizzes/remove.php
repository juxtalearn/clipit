<?php
session_start();
$id_quiz = get_input("id_quiz");
system_message($id_quiz);

$id_array[] = $id_quiz;
ClipitQuiz::delete_by_id($id_array);
system_message("Quiz eliminado correctamente");
forward(REFERER);

/*
function view_quiz(int $id)
{
    $q = ClipitQuiz::get_by_id($id);
    $user = array_pop(ClipitUser::get_by_id(array($quiz->owner_id)));
    $title = $q->name;
    $topic = $q->tricky_topic;
    $description = $q->description;
    
    echo "
    <div>
        <label>Identificador</label><br>$id
    </div>
    <div>
         <label>Titulo</label><br>$title
    </div>
    <div>
         <label>Tricky topic</label><br>$topic
    </div>
    <div>
         <label>Descripcion>/label><br>$description
    </div>
        ";
}

switch($option){
    case "view":
        view_quiz($id_quiz);
        break;
    case "remove":
        $id_array[0] = $id_quiz;
        ClipitQuiz::delete_by_id($id_array);
        system_message("Quiz eliminado correctamente");
        break;
     default:
        register_error("Error");
        break;
}
*/

?>
