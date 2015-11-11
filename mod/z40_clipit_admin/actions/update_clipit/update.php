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

$old_version = get_config("clipit_version");
$new_version = ClipitUpdate::update_clipit();
system_message("<p>Current version: $old_version<br>New version: $new_version</p>");
system_message("<p>Running update scripts...");
ClipitUpdate::run_update_scripts();
system_message("<p>Flushing caches...");
ClipitUpdate::flush_caches();
