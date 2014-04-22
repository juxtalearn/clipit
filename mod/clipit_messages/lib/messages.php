<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
function messages_search_page($page){
    $title = elgg_echo("messages:search");
    $search = get_input("s");
    $search_type = $page[1];
    switch($search_type){
        case "inbox":
            $query = array();
            messages_handle_inbox_page($query);
            break;
        case "sent_email":
            $query = array();
            messages_handle_sent_page($query);
            break;
        default:
            return false;
    }
    elgg_push_breadcrumb(elgg_echo('messages:search', array($search)));
}