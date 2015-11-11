<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   12/05/14
 * Last update:     12/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$option = get_input("set-option");
$files_id = get_input("check-file");

if(empty($files_id)){
    register_error(elgg_echo("file:error:files_not_selected"));
}
switch($option){
    case "remove":
        set_input("id", $files_id);
        include(elgg_get_plugins_path() . 'z04_clipit_activity/actions/multimedia/files/remove.php');
        break;
    default:
        register_error(elgg_echo("file:error"));
        break;
}
forward(REFERER);
?>