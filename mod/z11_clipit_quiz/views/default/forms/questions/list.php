<?php
$id_quiz = get_input('id_quiz');
$filter = get_input('f');

switch ($filter){
    case "tt":
        ?>
            <ul class="elgg-menu elgg-menu-filter elgg-menu-hz elgg-menu-filter-default">
                <li class="elgg-menu-item-all"><a href="http://jxl1.escet.urjc.es/clipit_rocio/questions/add2quiz?id_quiz=<?php echo $id_quiz ?>&option=list&f=q">Quizzes</a></li>
                <li class="elgg-menu-item-mine elgg-state-selected"><a href="http://jxl1.escet.urjc.es/clipit_rocio/questions/add2quiz?id_quiz=<?php echo $id_quiz ?>&option=list&f=tt"">Tricky Topics</a></li>
                <li class="elgg-menu-item-friend"><a href="http://jxl1.escet.urjc.es/clipit_rocio/questions/add2quiz?id_quiz=<?php echo $id_quiz ?>&option=list&f=a"">Authors</a></li>
            </ul>
        <?php
        break;
    case "a":
        ?>
            <ul class="elgg-menu elgg-menu-filter elgg-menu-hz elgg-menu-filter-default">
                <li class="elgg-menu-item-all"><a href="http://jxl1.escet.urjc.es/clipit_rocio/questions/add2quiz?id_quiz=<?php echo $id_quiz ?>&option=list&f=q">Quizzes</a></li>
                <li class="elgg-menu-item-mine"><a href="http://jxl1.escet.urjc.es/clipit_rocio/questions/add2quiz?id_quiz=<?php echo $id_quiz ?>&option=list&f=tt"">Tricky Topics</a></li>
                <li class="elgg-menu-item-friend  elgg-state-selected"><a href="http://jxl1.escet.urjc.es/clipit_rocio/questions/add2quiz?id_quiz=<?php echo $id_quiz ?>&option=list&f=a"">Authors</a></li>
            </ul>
        <?php
        break;
    default:
        ?>
            <ul class="elgg-menu elgg-menu-filter elgg-menu-hz elgg-menu-filter-default">
                <li class="elgg-menu-item-all elgg-state-selected"><a href="http://jxl1.escet.urjc.es/clipit_rocio/questions/add2quiz?id_quiz=<?php echo $id_quiz ?>&option=list&f=q">Quizzes</a></li>
                <li class="elgg-menu-item-mine"><a href="http://jxl1.escet.urjc.es/clipit_rocio/questions/add2quiz?id_quiz=<?php echo $id_quiz ?>&option=list&f=tt"">Tricky Topics</a></li>
                <li class="elgg-menu-item-friend"><a href="http://jxl1.escet.urjc.es/clipit_rocio/questions/add2quiz?id_quiz=<?php echo $id_quiz ?>&option=list&f=a"">Authors</a></li>
            </ul>
        <?php
        break;
}

$quizzes = ClipitQuiz::get_all();
unset($quizzes['$id_quiz']); //Borro el quiz actual de la lista de quizzes para no mostrar sus preguntas

foreach ($quizzes as $quiz) :
    $questions = ClipitQuiz::get_quiz_questions($quiz->id);
    if (count($questions) > 0){
    ?>

<div class="quiz">
    <h3><?php echo $quiz->name; ?></h3>
    <p><?php echo $quiz->description; ?></p>
</div>

    <?php
    foreach($questions as $question):
        $quest = array_pop(ClipitQuizQuestion::get_by_id(array($question)));
        ?>
<div class="question" style="margin-left: 30px;">
        <h4>
        <input type="checkbox" name="check-quest[]" value="<?php echo $quest->id ?>" class="select-simple">
        <?php echo $quest->name; ?>
        </h4>
        <?php echo $quest->description; ?>
        <p><strong>Tipo de pregunta:</strong> <?php echo $quest->option_type; ?><br>
        <strong>Dificultad:</strong> <?php echo $quest->difficulty; ?> </p>
    </div>

<?php 
    endforeach;  //Questions
    }            //IF
endforeach; //Quizzes
?>

<div> <?php 
        echo elgg_view('input/hidden', array(
			'name' => 'id_quiz',
			'value' => $id_quiz,
		));
        echo elgg_view('input/submit', array(
			'value' => "Añadir",
		)); 
        ?>
</div><br>