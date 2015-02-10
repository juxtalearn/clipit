<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   09/10/2014
 * Last update:     09/10/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$metric_id = get_input("metric");
$metric = array_pop(ClipitLA::get_by_id(array($metric_id)));
if($metric->metric_received){
    echo elgg_view('output/iframe', array(
        'value'  => elgg_normalize_url(elgg_format_url("metric/{$metric->file_id}")),
    ));
}
?>