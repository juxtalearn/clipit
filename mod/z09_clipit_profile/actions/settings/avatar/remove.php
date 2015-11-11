<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   27/06/14
 * Last update:     27/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$user_id = elgg_get_logged_in_user_guid();

ClipitUser::set_avatar($user_id, '');