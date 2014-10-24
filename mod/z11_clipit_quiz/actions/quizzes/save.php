<?php
$title = get_input('title');
$topic = get_input('topic'); //Coge el ID del TT
$description = get_input('description');
$view = get_input('view_mode');
$access = get_input('access');
$author = get_input('author');
$owner_id = elgg_get_logged_in_user_guid();
//$tags = string_to_tag_array(get_input('tags'));

//Establecer el tipo de vista del quiz
if ($view == 'list'){
    $view_mode = "list";
} else {
    $view_mode = "paged";
}

//Establecer el tipo de acceso
if ($access == 'public'){
    $access_quiz = true;
} else {
    $access_quiz = false;
}

if (!$author){ //Si no ha introducido el nombre del autor
    //Obtener el nombre del usuario que ha creado el quiz
    $user = array_pop(ClipitUser::get_by_id(array($owner_id)));
    $author = $user->name;
}

if (!$title) {
	register_error("Titulo no encontrado");
} else {
    
    // Crear objeto
    $quiz_id = ClipitQuiz::create(array(
            'name' => $title,
            'tricky_topic' => $topic,
            'description' => $description,
            'owner_id' => $owner_id,
            'author_name' => $author,
            'public' => $access_quiz,
            'view_mode' => $view_mode,
        ));
    system_message("Quiz creado correctamente");
  
    
    $view_quiz_url = elgg_get_site_url()."quizzes/view?id_quiz={$quiz_id}";
    forward($view_quiz_url);

}