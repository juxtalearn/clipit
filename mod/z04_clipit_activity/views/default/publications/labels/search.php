<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   27/05/14
 * Last update:     27/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$query = stripslashes(get_input('q', get_input('term', '')));
foreach(ClipitLabel::get_from_search($query) as $label){
    $output[] = $label->name;
}
echo json_encode($output);
die();