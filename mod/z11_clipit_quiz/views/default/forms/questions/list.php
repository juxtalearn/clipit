<?php
// Obtengo el ID del quiz
$id_quiz = get_input('id_quiz');
$filter = get_input('f');

// Obtengo todos los quizzes
$quizzes = ClipitQuiz::get_all();

/* Borro el quiz actual de la lista de quizzes para no mostrar sus preguntas,
 * ya que no tendria sentido elegir una pregunta que ya tengo en mi quiz
 */
unset($quizzes['$id_quiz']);

echo '<div id="questions-list" class="container">';

// Obtengo todas las preguntas de cada quiz y las muestro
foreach ($quizzes as $quiz) :
    $questions = ClipitQuiz::get_quiz_questions($quiz->id);
    if (count($questions) > 0){
        echo '<div id="info-quiz">';
        echo '<h3><a data-toggle="collapse" href="#qq'.$quiz->id.'" aria-expanded="false" aria-controls="qq'.$quiz->id.'">'.$quiz->name.' <i class="fa fa-caret-down"></i></a></h3>';
        echo '<p>'.$quiz->description.'</p>';
        echo '</div>';  //Cerrar quiz
        echo '<div class="collapse" id="qq'.$quiz->id.'" style="margin-left: 30px;">';
        
        foreach($questions as $question):
            $quest = array_pop(ClipitQuizQuestion::get_by_id(array($question)));
                echo '<h4><input type="checkbox" name="check-quest[]" value="'.$quest->id.'" class="select-simple"> '.$quest->name.'</h4>';
                echo '<div id="info-question" style="margin-left: 20px;">';
                echo '<p>'.$quest->description.'</p>';
                echo '<p><strong>Tipo de pregunta:</strong> '.$quest->option_type.'</p>';
                echo '<p><strong>Dificultad:</strong> '.$quest->difficulty.'</p>';
                echo '</div>';  //Cerrar question
        endforeach;  //Questions
        
        echo '</div>';  //Cerrar #qq
    }//IF
endforeach; //Quizzes

echo '</div>'; //Cerrar #questions-list

echo '<div class="col-md-12" style="margin-top: 15px;">';
    echo '<div class="col-xs-4 col-md-2">';
        echo elgg_view('input/submit', array(
                'value' => "Añadir",
                "class" => "btn btn-primary",
        ));
    echo '</div>';
    echo elgg_view('input/hidden', array(
                    'name' => 'id_quiz',
                    'value' => $id_quiz,
            ));
echo '</div>';  //Cerrar botones