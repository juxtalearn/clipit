<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   8/09/14
 * Last update:     8/09/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
function discussion_get_page_content_list($params = array()){
    $content = elgg_view('discussion/list', $params);
    if(!$params['messages']){
        $content .= elgg_view('output/empty', array('value' => elgg_echo('discussions:none')));
    }
    return $content;
}
function discussion_get_page_content_view($params = array()){

}