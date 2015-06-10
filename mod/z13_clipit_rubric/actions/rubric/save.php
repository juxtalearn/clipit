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
$rubrics = get_input('rubric');
foreach($rubrics as $rubric){
    $data = array(
        'name' => $rubric['name'],
        'level_array' => $rubric['item']
    );
    if($rubric['id']){
        if($rubric['remove'] == 1){
            ClipitRubricItem::delete_by_id(array($rubric['id']));
        } else {
            ClipitRubricItem::set_properties($rubric['id'], $data);
        }
    } else {
        ClipitRubricItem::create($data);
    }
}
forward('rubrics/edit/'.elgg_get_logged_in_user_guid());