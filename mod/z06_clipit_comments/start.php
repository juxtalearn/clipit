<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
elgg_register_event_handler('init', 'system', 'clipit_comments_init');

function clipit_comments_init() {
    elgg_register_action("comments/create", elgg_get_plugins_path() . "z06_clipit_comments/actions/comments/create.php");
}