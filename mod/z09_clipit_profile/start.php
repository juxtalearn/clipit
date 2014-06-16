<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   20/05/14
 * Last update:     20/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
elgg_register_event_handler('init', 'system', 'clipit_profile_init');

function clipit_profile_init() {
    // Register "/profile" page handler
    elgg_register_page_handler('profile', 'profile_page_handler');
}

/**
 * @param $page
 */
function profile_page_handler($page){
    if($page[0] && $user = array_pop(ClipitUser::get_by_login(array($page[0])))){
        $title = $user->name;
        $params = array(
            'content' => elgg_view("profile/layout", array('entity' => $user)),
            'title' => $title,
            'filter' => "",
        );
        $body = elgg_view_layout('one_column', $params);

        echo elgg_view_page($title, $body);
    } else {
        return false;
    }
}