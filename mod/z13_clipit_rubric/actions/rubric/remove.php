<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   03/02/2015
 * Last update:     03/02/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$id = get_input('id');

if(ClipitQuiz::delete_by_id(array($id))){
    system_message(elgg_echo('quiz:removed'));
} else {
    register_error(elgg_echo("quiz:cantremove"));
}
forward("quizzes");