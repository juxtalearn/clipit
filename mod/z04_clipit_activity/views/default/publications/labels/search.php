<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   27/05/14
 * Last update:     27/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$query = stripslashes(get_input('q', get_input('term', '')));
foreach(ClipitLabel::get_from_search($query) as $label){
    $output[] = $label->name;
}
$output = array_slice($output, 0, 10);
echo json_encode($output);
die();