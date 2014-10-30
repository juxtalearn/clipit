<?php

session_start();

//Obtener el ID del quiz de la URL 
$id_quiz = get_input("id_quiz");

//Eliminar quiz
ClipitQuiz::delete_by_id(array($id_quiz));

system_message("Quiz eliminado correctamente");

forward(REFERER);

?>
