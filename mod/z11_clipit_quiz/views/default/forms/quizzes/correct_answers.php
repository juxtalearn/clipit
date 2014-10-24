<?php

$id_quiz = get_input('id_quiz');
$id_user = get_input('u');

//Obtener todas las preguntas del quiz
$quiz_questions = ClipitQuiz::get_quiz_questions($id_quiz);
//Quedarme solo con las que son de desarrollo
foreach ($quiz_questions as $id_question) {
    $question = array_pop(ClipitQuizQuestion::get_by_id($quiz_questions));
    if ($question->option_type == "Desarrollo"){
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
        if( strlen($result->description) > 0 ){
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

<?php
$i = 1;

foreach ($user_develop_results as $user_result) :
    $question = array_pop(ClipitQuizQuestion::get_by_id(array($user_result->quiz_question))); //Obtengo la pregunta
    //en $user_result tengo el objeto resultado a la pregunta
    $student = array_pop(ClipitUser::get_by_id(array($user_result->user)));
    var_dump($question);
    var_dump($user_result);
?>

<div class="questions" id="<?php echo $i;?>" style="<?php echo $i>1 ? "display:none": ""; ?>">
    <div class="info-block">
        <h3><?php echo $question->name; ?></h3><br>
        <p><?php echo $question->description; ?></p><br>
    </div>

    <div class="answer-block">
        <p><strong><?php echo "Respuesta del alumno " .$student->name. ":" ?></strong></p>
        <?php
            echo elgg_view('input/longtext', array(
                        'name' => 'resp',
                        'value' => $user_result->description));
        ?>
    </div>

    <div class='correct_answer'>

        <input type="radio" name="<?php echo "correct_{$user_result->id}"?>" value="0"> Correcta
        <input type="radio" name="<?php echo "correct_{$user_result->id}"?>" value="-1" style="margin-left: 40px;"> Incorrecta<br>
        <br>
        
    </div>

    
    <?php
          $x = $i;
          
          if (count($user_develop_results) == 1){ //Si solo hay una respuesta para corregir
              echo elgg_view('input/submit', array(
                        'value' => "Corregir",
                    ));
              break;
          } else { //Si hay mas de una respuesta para corregir
              
              if( ($i < count($user_develop_results)) && ($i > 1) ){ //Si No es ni la primera ni la última respuesta
                  echo elgg_view('output/url', array(
                            "href" => "javascript:;", 
                            "class" => "elgg-button step",
                            "text" => "Anterior",
                            "data-step" => $x-1));

                  echo elgg_view('output/url', array(
                            "href" => "javascript:;", 
                            "class" => "elgg-button step",
                            "text" => "Siguiente -->",
                            "data-step" => $x+1));
              } elseif ( ($i == 1) && (count($user_develop_results) > $i) ) { //Si es la primera respuesta
                  echo elgg_view('output/url', array(
                            "href" => "javascript:;", 
                            "class" => "elgg-button step",
                            "text" => "Siguiente -->",
                            "data-step" => $x+1));
              } else {                                                        //Si es la última respuesta
                  echo elgg_view('output/url', array(
                                "href" => "javascript:;", 
                                "class" => "elgg-button step",
                                "text" => "Anterior",
                                "data-step" => $x-1,
                        ));
                  echo elgg_view('input/submit', array(
                            'value' => "Corregir",
                        ));
              }
              
          } //Fin IF para mas de una respuesta
          
      ?>
    
    
</div>
<?php 
    $i ++;
    endforeach;
    
    //Codifico el array para pasarlo al formulario POST
    $a = serialize($user_develop_results); 
    $a = urlencode($a);

    echo elgg_view('input/hidden', array(
        'name' => 'array',
        'value' => $a,
        ));
    
    echo elgg_view('input/hidden', array(
        'name' => 'id_quiz',
        'value' => $id_quiz,
        ));
?>