<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   04/02/2015
 * Last update:     04/02/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$tags = get_input('tags');
if(!empty($tags)) {
    $tags = array_filter(
        array('tags' => explode(",", $tags))
    );
} else {
    $tags = array();
}
$page = get_input('page');
$search = get_input('search');
$query_search = array_filter(array_merge($search, $tags));

$output = $page;
if(!empty($query_search)){
    $output = set_search_input($page, $query_search);
}
forward($output);