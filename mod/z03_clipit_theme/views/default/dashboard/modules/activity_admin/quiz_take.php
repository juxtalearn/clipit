<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   24/07/14
 * Last update:     24/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$task = elgg_extract('task', $vars);
$quiz = array_pop(ClipitQuiz::get_by_id(array($task->quiz)));
?>
<?php echo $quiz->name;?>
<div class="form-group frame-container" frameborder="0">
    <iframe src="<?php echo $quiz->embed_url;?>?embed=1"></iframe>
</div>

