<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   23/04/14
 * Last update:     23/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
// Log out
$result = ClipitUser::logout();

// Set the system_message as appropriate
if ($result) {
    system_message(elgg_echo('logoutok'));
    forward();
} else {
    register_error(elgg_echo('logouterror'));
}