<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   16/06/14
 * Last update:     16/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$quizzes = elgg_extract("quizzes", $vars);
$href = elgg_extract("href", $vars);
?>
<style>
.panel.list-item{
    border: 0;
    border-bottom: 1px solid #bae6f6 !important;
    box-shadow: none;
    border-radius: 0;
}
.panel.list-item .panel-heading{
    background: none;
    border: 0;
}
</style>
<ul class="panel-group" id="accordion_quiz" style="margin-bottom: 10px;">
<?php
foreach($quizzes as $quiz_id):
    $quiz = array_pop(ClipitQuiz::get_by_id(array($quiz_id)));
?>
    <li class="panel panel-default list-item">
        <div class="panel-heading">
            <div class="pull-right">
                <?php echo elgg_view('output/url', array(
                    'href' => "#collapse_{$quiz->id}",
                    'text' => "Make",
                    'is_trusted' => true,
                    'data-toggle' => "collapse",
                    'data-parent' => "#accordion_quiz",
                    'class' => 'btn btn-default btn-xs'
                ));
                ?>
                <?php echo elgg_view('output/url', array(
                    'href' => "#collapse_{$quiz->id}_result",
                    'text' => "Result",
                    'is_trusted' => true,
                    'data-toggle' => "collapse",
                    'data-parent' => "#accordion_quiz",
                    'class' => 'btn btn-default btn-xs btn-border-blue'
                ));
                ?>
            </div>
            <?php echo elgg_view('output/url', array(
                'href' => "#collapse_{$quiz->id}",
                'title' => $quiz->name,
                'text' => $quiz->name,
                'is_trusted' => true,
                'data-toggle' => "collapse",
                'data-parent' => "#accordion_quiz",
            ));
            ?>
        </div>
        <div id="collapse_<?php echo $quiz->id;?>" class="panel-collapse collapse">
            <div class="panel-body">
                <div class="form-group frame-container" frameborder="0">
                    <iframe src="<?php echo $quiz->embed_url;?>"></iframe>
                </div>
            </div>
        </div>
        <div id="collapse_<?php echo $quiz->id;?>_result" class="panel-collapse collapse">
            <div class="panel-body">
                <div class="form-group frame-container" frameborder="0">
                    <iframe src="<?php echo $quiz->scores_url;?>"></iframe>
                </div>
            </div>
        </div>
    </li>
<?php endforeach; ?>
</ul>
