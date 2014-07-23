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
$quiz_id = elgg_extract("quiz", $vars);
$href = elgg_extract("href", $vars);
$quiz = array_pop(ClipitQuiz::get_by_id(array($quiz_id)));
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
<h4><?php echo $quiz->name;?></h4>
<p>
    <?php echo $quiz->description;?>
</p>
<div class="form-group frame-container" frameborder="0">
    <iframe src="<?php echo $quiz->embed_url;?>?embed=1"></iframe>
</div>

