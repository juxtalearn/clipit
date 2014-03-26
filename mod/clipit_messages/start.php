<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   10/03/14
 * Last update:     10/03/14
 *
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, JuxtaLearn Project
 * @version         $Version$
 * @link            http://juxtalearn.org
 * @license         GNU Affero General Public License v3
 *                  (http://www.gnu.org/licenses/agpl-3.0.txt)
 *                  This program is free software: you can redistribute it and/or modify
 *                  it under the terms of the GNU Affero General Public License as
 *                  published by the Free Software Foundation, version 3.
 *                  This program is distributed in the hope that it will be useful,
 *                  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *                  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *                  GNU Affero General Public License for more details.
 *                  You should have received a copy of the GNU Affero General Public License
 *                  along with this program. If not, see
 *                  http://www.gnu.org/licenses/agpl-3.0.txt.
 */

elgg_register_event_handler('init', 'system', 'clipit_messages_init');

function clipit_messages_init() {
    // Register libraries
    elgg_register_library('clipit:messages', elgg_get_plugins_path() . 'clipit_messages/lib/messages.php');
    // Register page handlers
    elgg_register_page_handler('messages', 'messages_page_handler');
    elgg_register_event_handler('pagesetup', 'system', 'messages_setup_sidebar_menus');
    // message actions
    elgg_register_action("messages/compose", elgg_get_plugins_path() . "clipit_messages/actions/messages/create.php");
    elgg_register_action("messages/list", elgg_get_plugins_path() . "clipit_messages/actions/messages/list.php");
    // reply msg actions
    elgg_register_action("messages/reply/create", elgg_get_plugins_path() . "clipit_messages/actions/messages/reply/create.php");
    elgg_register_action("messages/reply/remove", elgg_get_plugins_path() . "clipit_messages/actions/messages/reply/remove.php");
    elgg_register_action("messages/reply/edit", elgg_get_plugins_path() . "clipit_messages/actions/messages/reply/edit.php");

    // Ajax views
    elgg_register_ajax_view("messages/search_to");
    elgg_register_ajax_view('modal/messages/send');
    elgg_register_ajax_view('modal/messages/edit');
    elgg_register_ajax_view('modal/messages/reply/edit');

}
/**
 * Messages page handler
 *
 * URLs take the form of
 *  Messages site:    messages/inbox
 *  List topics in forum:  discussion/owner/<guid>
 *  View discussion topic: discussion/view/<guid>
 *  Add discussion topic:  discussion/add/<guid>
 *  Edit discussion topic: discussion/edit/<guid>
 *
 * @param array $page Array of url segments for routing
 * @return bool
 */
function messages_page_handler($page) {
    $current_user = elgg_get_logged_in_user_guid();
    elgg_set_context("messages_page");
    if (!$current_user) {
        register_error(elgg_echo('noaccess'));
        $_SESSION['last_forward_from'] = current_page_url();
        forward('');
    }
    // messages/ -> messages/inbox
    if(count($page)==0){
        forward('messages/inbox');
    }
    if(isset($page[0])){
        elgg_load_library("clipit:messages");
        $user_id = elgg_get_logged_in_user_guid();
        elgg_push_breadcrumb(elgg_echo("messages"), "/messages/inbox");
        elgg_extend_view("page/elements/owner_block", "page/components/button_compose_message");
        $file_dir = elgg_get_plugins_path() . 'clipit_messages/pages/messages';
        switch ($page[0]) {
            case 'search':
                include "$file_dir/search.php";
                break;
            case 'inbox':
                include "$file_dir/inbox.php";
                break;
            case 'sent_email':
                include "$file_dir/sent.php";
                break;
            case 'trash':
                include "$file_dir/trash.php";
                break;
            case 'view':
                include "$file_dir/view.php";
                break;
            default:
                return false;
        }

    }
    return true;
}


function messages_setup_sidebar_menus(){
    $user_id = elgg_get_logged_in_user_guid();
    if (elgg_in_context('messages_page')) {
        $params = array(
            'name' => 'a_inbox',
            'text' => elgg_echo('messages:inbox'),
            'href' => "messages/inbox",
        );
        $unread_count = ClipitMessage::get_unread_count($user_id);
        if($unread_count > 0){
            $params['badge'] = $unread_count;
        }
        elgg_register_menu_item('page', $params);
        $params = array(
            'name' => 'sent_email',
            'text' => elgg_echo('messages:sent_email'),
            'href' => "messages/sent_email",
        );
        elgg_register_menu_item('page', $params);
        $params = array(
            'name' => 'trash',
            'text' => elgg_echo('messages:trash'),
            'href' => "messages/trash",
        );
        elgg_register_menu_item('page', $params);
    }

}
