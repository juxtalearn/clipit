<?php
/**
 * Created by PhpStorm.
 * User: Pablo Llinás
 * Date: 29/05/2015
 * Time: 13:15
 */

// Pull latest version from GitHub

chdir(elgg_get_root_path());
exec("git stash save");
exec("git stash drop");
exec("git fetch --tags");
exec("git checkout `git for-each-ref --sort=committerdate --format='%(refname:short)' refs/tags | tail -1`");
exec("git submodule init");
exec("git submodule update");
// Run updates
include(elgg_get_plugins_path()."z40_clipit_admin/updates/run_updates.php");
