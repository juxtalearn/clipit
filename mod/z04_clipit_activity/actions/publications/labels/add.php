<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   2/06/14
 * Last update:     2/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity_id = get_input("entity-id");
$labels = get_input("labels");
$labels = explode(",", $labels);
$object = ClipitSite::lookup($entity_id);
if($object && !empty($labels)){
    echo $object['subtype'];
    $total_labels = array();
    foreach($labels as $label){
        if(trim($label) != '') {
            if ($label_exist = array_pop(ClipitLabel::get_from_search($label, true, true))) {
                $total_labels[] = $label_exist->id;
            } else {
                $total_labels[] = ClipitLabel::create(array(
                    'name' => $label,
                ));
            }
        } else {
            register_error(elgg_echo("labels:cantadd:empty"));
        }
    }
    $entity_class = $object['subtype'];
    $entity_class::add_labels($entity_id, $total_labels);

    system_message(elgg_echo('labels:added'));
} else {
    register_error(elgg_echo("labels:cantadd"));
}


forward(REFERRER);