<?php
$id = get_input('id_quest');
$owner_id = elgg_get_logged_in_user_guid();
$tags = string_to_tag_array(get_input('tags'));
$title = get_input('title');
$enunciado = get_input('enunciado');
$difficulty = (int) get_input('dif');
$type_answer = get_input('ta');
$option_array = array();
$val_array = array();
$empty = get_input('empty_ans');

//Si editan una pregunta vacía, cojo el tipo que quiere crear y "lo redirecciono" a los casos que ya tengo
switch ($empty) {
    case 'd': $type_answer = "Desarrollo";
        break;
    case 'vof': $type_answer = "Verdadero o falso";
        break;  
    case 'm1': $type_answer = "One choice";
        break;     
    case 'm': $type_answer = "Multiple choice";
        break;
    default:
        break;
}

switch ($type_answer) {
    case "Desarrollo":
        respuesta_desarrollo($option_array, $val_array);
        break;
    
    case "Verdadero o falso":
        respuestas_verdadero_falso($option_array, $val_array);
        break;
        
    case "One choice":
        //respuestas_once_choice($option_array, $val_array);
        r_o_c($option_array, $val_array);
        break;
        
    case "Multiple choice":
        //respuestas_multi_choice($option_array, $val_array);
        r_m_c($option_array, $val_array);
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
    $prop_value_array['tag_array'] = $tags;
    $prop_value_array['option_type'] = $type_answer;
    $prop_value_array['option_array'] = $option_array;
    $prop_value_array['validation_array'] = $val_array;

    ClipitQuizQuestion::set_properties($id, $prop_value_array);

    system_message("Pregunta modificada correctamente");
    
    $view_quest_url = elgg_get_site_url()."questions/view?id_quest={$id}";
    forward($view_quest_url);
}
?>

