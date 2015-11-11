<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, URJC Clipit Team
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 * @subpackage      clipit_admin
 */

// Save posted options
$clipit_tag_branch = (string)get_input("clipit_tag_branch");
if(!empty($clipit_tag_branch)){
    set_config("clipit_tag_branch", $clipit_tag_branch);
}
set_config("allow_registration", (bool)get_input("allow_registration"));
set_config("timezone", (string)get_input("timezone"));
set_config("clipit_site_type", (string)get_input("clipit_site_type"));
set_config("clipit_global_url", (string)get_input("clipit_global_url"));
set_config("clipit_global_login", (string)get_input("clipit_global_login"));
set_config("clipit_global_password", (string)get_input("clipit_global_password"));
set_config("clipit_global_published", (bool)get_input("clipit_global_published"));
set_config("example_types", (bool)get_input("example_types"));
if((bool)get_input("clean_accounts")){
    // clean users with incorrect role
    $users = ClipitUser::get_all();
    $remove_array = array();
    foreach($users as $user){
        if(array_search($user->role,
                array(ClipitUser::ROLE_ADMIN,
                    ClipitUser::ROLE_STUDENT,
                    ClipitUser::ROLE_TEACHER)) === false){
            $remove_array[] = $user->id;
        }
    }

    ClipitUser::delete_by_id($remove_array);
}
system_message("Options correctly applied");
