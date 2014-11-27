<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   27/11/2014
 * Last update:     27/11/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
?>
<?php echo elgg_view('output/url', array(
    'href'  => "javascript:;",
    'class' => 'btn btn-primary',
    'title' => elgg_echo('create'),
    'text'  => elgg_echo('create'),
));
?>
<?php
echo elgg_view('quiz/quiz');
?>