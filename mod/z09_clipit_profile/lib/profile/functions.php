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
function get_avatar($user_entity, $size = 'medium'){
    if($avatar_file = $user_entity->avatar_file){
        return "file/thumbnail/{$size}/{$user_entity->avatar_file}";
    } else {
        return "mod/z03_clipit_site/graphics/icons/user/default{$size}.gif";
    }
}
function get_avatar_url($user_entity, $size = 'medium'){
    return elgg_get_site_url().get_avatar($user_entity, $size);
}