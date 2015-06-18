<?php
elgg_register_event_handler('init', 'system', 'quizzes_tool_init');

function quizzes_tool_init() {
    
    //Cargar librerias
    elgg_register_library('questions:functions', elgg_get_plugins_path() . "z11_clipit_quiz/lib/functions.php");
    elgg_load_library('questions:functions');
    
    //Adicionar items al menu de navegacion
    $item = new ElggMenuItem('quizzes', 'Quizzes', 'quizzes/all');
    elgg_register_menu_item('site', $item);
    $item2 = new ElggMenuItem('questions', 'Preguntas', 'questions/all');
    elgg_register_menu_item('site', $item2);
    
    $item3 = new ElggMenuItem('results', 'Estudiante', 'results/all_quizzes');
    elgg_register_menu_item('site', $item3);
    
    elgg_extend_view("navigation/menu/top", "navigation/menu/quizzes", 10);
    
    //Adicionar items al menu de navegacion del margen derecho
    elgg_register_menu_item('page', array(
           'name' => 'all_quizzes',
           'text' => 'Listado Quizzes',
           'href' => 'quizzes/all',
           'contexts' => array('quizzes','questions'),
         ));     
    elgg_register_menu_item('page', array(
           'name' => 'add_quizzes',
           'text' => 'Crear Quiz',
           'href' => 'quizzes/add',
           'contexts' => array('quizzes','questions'),
         ));
    
    elgg_register_menu_item('page', array(
        'name' => 'all_questions',
        'text' => 'Listado Preguntas',
        'href' => 'questions/all',
        'contexts' => array('quizzes','questions'),
    ));

    elgg_register_menu_item('page', array(
        'name' => 'add_questions',
        'text' => 'Crear Pregunta',
        'href' => 'questions/add',
        'contexts' => array('quizzes','questions'),
    ));
         
    //Registro de acciones
    elgg_register_action("quizzes/save", elgg_get_plugins_path() . "z11_clipit_quiz/actions/quizzes/save.php");
    elgg_register_action("quizzes/remove", elgg_get_plugins_path() . "z11_clipit_quiz/actions/quizzes/remove.php");
    elgg_register_action("quizzes/edit", elgg_get_plugins_path() . "z11_clipit_quiz/actions/quizzes/edit.php");
    elgg_register_action("quizzes/correct_answers", elgg_get_plugins_path() . "z11_clipit_quiz/actions/quizzes/correct_answers.php");
    
    elgg_register_action("questions/save", elgg_get_plugins_path() . "z11_clipit_quiz/actions/questions/save.php");
    elgg_register_action("questions/remove", elgg_get_plugins_path() . "z11_clipit_quiz/actions/questions/remove.php");
    elgg_register_action("questions/edit", elgg_get_plugins_path() . "z11_clipit_quiz/actions/questions/edit.php");
    elgg_register_action("questions/list", elgg_get_plugins_path() . "z11_clipit_quiz/actions/questions/list.php");
    
    elgg_register_action("results/list", elgg_get_plugins_path() . "z11_clipit_quiz/actions/results/list.php");
    elgg_register_action("results/paged", elgg_get_plugins_path() . "z11_clipit_quiz/actions/results/paged.php");
    
    
    //Registro de manejadores de paginas
    elgg_register_page_handler('quizzes', 'quizzes_page_handler');
    
    elgg_register_page_handler('questions', 'questions_page_handler'); 
    
    elgg_register_page_handler('results', 'results_page_handler');
}

function quizzes_page_handler($segments) {
    switch ($segments[0]) {
        case 'add':
           include elgg_get_plugins_path() . 'z11_clipit_quiz/pages/quizzes/add.php';
           break;
        case 'all':
           include elgg_get_plugins_path() . 'z11_clipit_quiz/pages/quizzes/all.php';
           break;
       case 'view':
           include elgg_get_plugins_path() . 'z11_clipit_quiz/pages/quizzes/view.php';
           break;
       case 'preview':
           include elgg_get_plugins_path() . 'z11_clipit_quiz/pages/quizzes/preview.php';
           break;
       case 'edit':
           include elgg_get_plugins_path() . 'z11_clipit_quiz/pages/quizzes/edit.php';
           break;
       case 'owner':
           include elgg_get_plugins_path() . 'z11_clipit_quiz/pages/quizzes/edit.php';
           break;
       case 'correct_answers':
           include elgg_get_plugins_path() . 'z11_clipit_quiz/pages/quizzes/correct_answers.php';
           break;
        case 'students_list':
           include elgg_get_plugins_path() . 'z11_clipit_quiz/pages/quizzes/students_list.php';
           break;
    }
    return true;
}

function questions_page_handler($segments) {
    switch ($segments[0]) {
        case 'add':
           include elgg_get_plugins_path() . 'z11_clipit_quiz/pages/questions/add.php';
           break;
        case 'add2quiz':
           include elgg_get_plugins_path() . 'z11_clipit_quiz/pages/questions/add2quiz.php';
           break;
        case 'all':
           include elgg_get_plugins_path() . 'z11_clipit_quiz/pages/questions/all.php';
           break;
       case 'view':
           include elgg_get_plugins_path() . 'z11_clipit_quiz/pages/questions/view.php';
           break;
       case 'edit':
           include elgg_get_plugins_path() . 'z11_clipit_quiz/pages/questions/edit.php';
           break;
    }
    return true;
}

function results_page_handler($segments) {
    switch ($segments[0]) {
        case 'all_quizzes':
           include elgg_get_plugins_path() . 'z11_clipit_quiz/pages/results/all_quizzes.php';
           break;
        case 'index_quiz':
           include elgg_get_plugins_path() . 'z11_clipit_quiz/pages/results/index_quiz.php';
           break;
        case 'do_quiz':
           include elgg_get_plugins_path() . 'z11_clipit_quiz/pages/results/do_quiz.php';
           break;
        case 'results':
           include elgg_get_plugins_path() . 'z11_clipit_quiz/pages/results/results.php';
           break;
    }
    return true;
}

?>