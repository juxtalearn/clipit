<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   02/02/2015
 * Last update:     02/02/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$rubric = get_input('rubric');
$rubric_items = $rubric['item'];

$rubric_item_array = array();
foreach ($rubric_items as $rubric_item) {
    $data = array(
        'name' => $rubric_item['name'],
        'level_array' => $rubric_item['level']
    );

    if ($rubric_item['id']) {
        if ($rubric_item['remove'] == 1) {
            ClipitRubric::remove_rubric_items($rubric['id'], array($rubric_item['id']));
        } else {
            $rubric_item_array[] = $rubric_item['id'];
            ClipitRubricItem::set_properties($rubric_item['id'], $data);
        }
    } else {
        $rubric_item_array[] = ClipitRubricItem::create($data);
    }
}

if($rubric_id = $rubric['id']){ // edit rubric data
    ClipitRubric::set_properties($rubric_id, array('name' => $rubric['name']));
} else { // create a new rubric
    $rubric_id = ClipitRubric::create(array('name' => $rubric['name']));
}
ClipitRubric::add_rubric_items($rubric_id, $rubric_item_array);

forward('rubrics/view/'.$rubric_id);