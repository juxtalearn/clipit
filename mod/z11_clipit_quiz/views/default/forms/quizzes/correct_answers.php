<?php
$id_quiz = get_input('id_quiz');
$id_user = get_input('u');

//Obtener todas las preguntas del quiz
$quiz_questions = ClipitQuiz::get_quiz_questions($id_quiz);

//Quedarme solo con las que son de desarrollo
foreach ($quiz_questions as $id_question) {
    $question = array_pop(ClipitQuizQuestion::get_by_id(array($id_question)));
    if ($question->option_type === ClipitQuizQuestion::TYPE_STRING){
        $develop_questions[] = $id_question; //Array con las preguntas de desarrollo
    }
}

//Obtener las respuestas del usuario a esas preguntas de desarrollo
//Primero obtengo todos los resultados del usuario
$student_results = array_pop((ClipitQuizResult::get_by_owner(array($id_user))));
//Me quedo con los resultados a las preguntas de desarrollo 
foreach ($student_results as $result) {
    if (in_array($result->quiz_question, $develop_questions)){
        //Solo guardo las respuestas que no han sido corregidas
        if( strlen($result->description) === 0 ){
             $user_develop_results[] = $result;  //Array con las respuestas no corregidas del usuario a las preguntas de desarrollo del quiz           
        }  
    }
}
?>

<script>
    $(function(){
       $("a.step").click(function(){
          var step = $(this).data("step"); 
          $(".questions").hide();
          $(".questions#"+step).show();
          console.log(step);
       }); 
    });
</script>

<div id="quiz-questions" class="row" style="clear: left; margin-bottom: 15px;">
    <div id="questions-list" class="col-xs-12 col-md-12">

    <?php
    /* Mostrar pregunta a pregunta todas las questions del quiz */
    $i = 1;
    foreach ($user_develop_results as $user_result) : //en $user_result tengo el objeto resultado a la pregunta
        $question = array_pop(ClipitQuizQuestion::get_by_id(array($user_result->quiz_question))); //Obtengo la pregunta
        $student = array_pop(ClipitUser::get_by_id(array($user_result->user)));
        
        if ($i>1){
            $display = "display:none;";
        }else{
            $display = "";}
        
        echo '<div id="'.$i.'" class="question" style="'.$display.'">';
            //Titulo de la pregunta
            echo '<div id="quest-title" class="col-xs-12 col-md-12">';
            echo '<h3>'.$question->name.'</h3>';
            echo '</div>';
            //Descripcion de la pregunta
            echo '<div id="quest-description" class="col-xs-12 col-md-12" style="margin-bottom: 10px;">';
            echo '<p>'.$question->description.'</p>';
            echo '</div>';
            //Respuesta
            echo '<div id="answer-block" class="col-xs-12 col-md-12">';
                echo '<p><strong>Respuesta del alumno '.$student->name.':</strong></p>';
            echo '<div id="student-answer" class="text-justify">'.$user_result->answer.'</div>';
            echo '</div>';
    ?>
        
    <script>
        //Script para hacer obligatorio el campo de anotacion
        function validar(id){
            //Comprobar que algun campo checkbox ha sido seleccionado
            camposRadio = document.getElementsByName('correct_'+id);
            opcion = false;
            x = 0;
            while (x<camposRadio.length && !opcion) {
              if (camposRadio[x].checked){
                    opcion = true;
              }
              x++;
            }
            if (!opcion){
                alert("Por favor corrija la respuesta");
                return false;
            }
            if($('#description_'+id).val() === "" || $('#description_'+id).val() === null){
                alert("Por favor realice una descripción de la corrección.");
                return false;
            }
        };
    </script>

    <?php
        echo '<div id="correct_answer" class="col-xs-12 col-md-12">';
            echo '<div class="radio" style="margin-left: 20px;">
                    <label>
                        <input type="radio" name="correct_'.$user_result->id.'" value="0">Correcta
                    </label>
                  </div>';
            echo '<div class="radio" style="margin-left: 20px;">
                    <label>
                        <input type="radio" name="correct_'.$user_result->id.'" value="-1">Inorrecta
                    </label>
                  </div><br>';
            echo '<label class="control-label"><span title="Obligatorio" class="glyphicon glyphicon-asterisk"></span> Anotación:</label>';
            echo elgg_view('input/longtext', array(
                        'name' => "description_{$user_result->id}",
                        'class'=> "form-control"
                    )); 
        echo '</div>';
    
        //Botones de navegación entre preguntas
        echo '<div id="buttons">';
            $x = $i;
            if (count($user_develop_results) == 1){ //Si solo hay una respuesta para corregir
                echo '<div class="col-xs-6 col-md-3" style="margin-top: 15px;">';
                echo elgg_view('input/submit', array(
                          'value' => "Corregir",
                          'id' => "corregir",
                          'class' => "btn btn-info",
                          'onclick' => "javascript:return validar({$user_result->id});",
                      ));
                echo '</div>';
                break;
            } else { //Si hay mas de una respuesta para corregir

                if( ($i < count($user_develop_results)) && ($i > 1) ){ //Si No es ni la primera ni la última respuesta
                    echo '<div class="col-xs-6 col-md-3" style="margin-top: 15px;">';
                    echo elgg_view('output/url', array(
                              "href" => "javascript:;", 
                              "class" => "step btn btn-primary",
                              "text" => '<i class="fa fa-fw fa-chevron-left fa-lg" aria-hidden="true"></i> Anterior',
                              "data-step" => $x-1));
                    echo '</div>';
                    echo '<div class="col-xs-6 col-md-3" style="margin-top: 15px;">';
                    echo elgg_view('output/url', array(
                              "href" => "javascript:;", 
                              "class" => "step btn btn-primary",
                              "text" => 'Siguiente <i class="fa fa-fw fa-chevron-right fa-lg" aria-hidden="true"></i>',
                              "data-step" => $x+1));
                    echo '</div>';
                } elseif ( ($i == 1) && (count($user_develop_results) > $i) ) { //Si es la primera respuesta
                    echo '<div class="col-xs-6 col-md-3" style="margin-top: 15px;">';
                    echo elgg_view('output/url', array(
                              "href" => "javascript:;", 
                              "class" => "step btn btn-primary",
                              "text" => 'Siguiente <i class="fa fa-fw fa-chevron-right fa-lg" aria-hidden="true"></i>',
                              "data-step" => $x+1));
                    echo '</div>';
                } else {                                                        //Si es la última respuesta
                    echo '<div class="col-xs-6 col-md-3" style="margin-top: 15px;">';
                    echo elgg_view('output/url', array(
                                  "href" => "javascript:;", 
                                  "class" => "step btn btn-primary",
                                  "text" => '<i class="fa fa-fw fa-chevron-left fa-lg" aria-hidden="true"></i> Anterior',
                                  "data-step" => $x-1,
                          ));
                    echo '</div>';
                    echo '<div class="col-xs-6 col-md-3" style="margin-top: 15px;">';
                    echo elgg_view('input/submit', array(
                              'value' => "Corregir",
                              'id' => "corregir",
                              'class' => "btn btn-info",
                              'onclick' => "javascript:return validar({$user_result->id});"
                          ));
                    echo '</div>';
                }
            } //Fin IF para mas de una respuesta
        echo '</div>';  //Cerrar botones
    echo '</div>';  //Cerrar class question
    
    $i ++;
    endforeach;

    echo elgg_view('input/hidden', array(
        'name' => 'u',
        'value' => $id_user,
        ));
    
    echo elgg_view('input/hidden', array(
        'name' => 'id_quiz',
        'value' => $id_quiz,
        ));
?>
    
    </div>  <!-- ./questions-list -->
</div>    <!-- ./quiz-questions -->