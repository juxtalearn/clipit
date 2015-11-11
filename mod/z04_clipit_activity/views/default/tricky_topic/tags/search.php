<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   13/10/2014
 * Last update:     13/10/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$query = stripslashes(get_input('q', get_input('term', '')));
foreach(ClipitTag::get_from_search($query) as $tag){
    $output[] = array(
        'label' => $tag->name,
        'value' => $tag->id
    );
}
$output = array_slice($output, 0, 10);
echo json_encode($output);
