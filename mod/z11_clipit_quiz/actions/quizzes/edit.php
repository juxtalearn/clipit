<?php
$id = get_input('id_quiz');
$title = get_input('title');
$topic = get_input('topic'); //Coge el ID del TT
$description = get_input('description');
$view_mode = get_input('view_mode');
$access = get_input('access');
$author = get_input('author');
$owner_id = elgg_get_logged_in_user_guid();
//$tags = string_to_tag_array(get_input('tags'));

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
    
    //Editar quiz
    $prop_value_array['name'] = $title;
    $prop_value_array['tricky_topic'] = $topic;
    $prop_value_array['description'] = $description;
    $prop_value_array['owner_id'] = $owner_id;
    $prop_value_array['author_name'] = $author;
    $prop_value_array['public'] = $access_quiz;
    $prop_value_array['view_mode'] = $view_mode;
    ClipitQuiz::set_properties($id, $prop_value_array);

    system_message("Quiz modificado correctamente");
    
    $view_quiz_url = elgg_get_site_url()."quizzes/view?id_quiz={$id}";
    forward($view_quiz_url);

}
?>
