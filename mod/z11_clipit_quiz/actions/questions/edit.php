<?php

/*
 * Obtengo los datos recogidos del formulario
 */

$id = get_input('id_quest');
$owner_id = elgg_get_logged_in_user_guid();
//$tags = string_to_tag_array(get_input('tags'));
$title = get_input('title');
$enunciado = get_input('enunciado');
$difficulty = (int) get_input('dif');
$question_type = get_input('ta');
$option_array = array();
$val_array = array();
$type_empty = get_input('empty_ans');

//Si editan una pregunta vacía, cojo el tipo que quiere crear y "lo redirecciono" a los casos que ya tengo
switch ($type_empty) {
    case ClipitQuizQuestion::TYPE_STRING: $question_type = $type_empty;
        break;
    case ClipitQuizQuestion::TYPE_TRUE_FALSE: $question_type = $type_empty;
        break;  
    case ClipitQuizQuestion::TYPE_SELECT_ONE: $question_type = $type_empty;
        break;     
    case ClipitQuizQuestion::TYPE_SELECT_MULTI: $question_type = $type_empty;
        break;
    default:
        break;
}


switch ($question_type) {
    case ClipitQuizQuestion::TYPE_STRING:
        save_long_quest($option_array, $val_array);
        break;
    
    case ClipitQuizQuestion::TYPE_TRUE_FALSE:
        save_true_false($option_array, $val_array);
        break;
        
    case ClipitQuizQuestion::TYPE_SELECT_ONE:
        save_select_one($option_array, $val_array);
        break;
        
    case ClipitQuizQuestion::TYPE_SELECT_MULTI:
        save_select_multi($option_array, $val_array);
        break;
    
    default:
        break;
}

if (!$title) {
	register_error("Titulo no encontrado");
} else {
    
    //Editar question
    $prop_value_array['owner_id'] = $owner_id;
    $prop_value_array['name'] = $title;
    $prop_value_array['description'] = $enunciado;
    $prop_value_array['difficulty'] = $difficulty;
    //$prop_value_array['tag_array'] = $tags;
    $prop_value_array['option_type'] = $question_type;
    $prop_value_array['option_array'] = $option_array;
    $prop_value_array['validation_array'] = $val_array;

    ClipitQuizQuestion::set_properties($id, $prop_value_array);

    system_message("Pregunta modificada correctamente");
    
    $view_quest_url = elgg_get_site_url()."questions/view?id_quest={$id}";
    forward($view_quest_url);
}
?>

