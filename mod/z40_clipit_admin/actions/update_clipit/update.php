<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, URJC JuxtaLearn Team
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 * @subpackage      clipit_admin
 */

// Pull latest version from GitHub

chdir(elgg_get_root_path());
exec("git stash save");
exec("git stash drop");
exec("git fetch --tags");
$tag_branch = get_config("clipit_tag_branch");
if(!empty($tag_branch)){
    $latest_tag =
        exec("git for-each-ref --sort=committerdate --format='%(refname:short)' refs/tags | grep $tag_branch | tail -1");
} else{
    $latest_tag =
        exec("git for-each-ref --sort=committerdate --format='%(refname:short)' refs/tags | tail -1");
}
exec("git checkout $latest_tag");
exec("git submodule init");
exec("git submodule update");
// Run updates
include(elgg_get_plugins_path()."z40_clipit_admin/updates/run_updates.php");
