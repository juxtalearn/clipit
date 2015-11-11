<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   29/01/2015
 * Last update:     29/01/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$stumbling_block = get_input('stumbling_block');
$examples = ClipitExample::get_by_tag(array($stumbling_block));
$output = array();
foreach($examples as $example){
    $output[] = array(
        'example' => $example->id,
        'content' => elgg_view('questions/example_summary', array('entity' => $example))
    );
}

echo json_encode($output);
die;