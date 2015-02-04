<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   04/02/2015
 * Last update:     04/02/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$tags = get_input('tags', array());
if(!empty($tags)) {
    $tags = array_filter(
        array('tags' => explode(",", $tags))
    );
}
$page = get_input('page');
$search = get_input('search');
$query_search = array_filter(array_merge($search, $tags));

$ouput = '';
if(!empty($query_search)){
    $output = '?s='.json_encode($query_search);
}
forward($page.$output);