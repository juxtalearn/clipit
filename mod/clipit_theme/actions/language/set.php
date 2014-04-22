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
 * @package         ClipIt
 */
$new_lang_id = get_input("lang");
$installed = get_installed_translations();
$user_id = elgg_get_logged_in_user_guid();

if(!empty($new_lang_id) && array_key_exists($new_lang_id, $installed) && $user_id){
    ClipitUser::set_properties($user_id, array('language' => $new_lang_id));
}

forward(REFERER);
