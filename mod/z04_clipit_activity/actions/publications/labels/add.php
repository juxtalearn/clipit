<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   2/06/14
 * Last update:     2/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$entity_id = get_input("entity-id");
$labels = get_input("labels");
$labels = explode(",", $labels);
$object = ClipitSite::lookup($entity_id);

if($object && !empty($labels)){
    $total_labels = array();
    foreach($labels as $label){
        if(trim($label) != '') {
            $total_labels[] = ClipitLabel::create(array(
                'name' => $label,
            ));
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