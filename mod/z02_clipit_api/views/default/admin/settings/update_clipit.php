<?php
// Pull latest version from GitHub
chdir(elgg_get_root_path());
echo "<h3>Performing local git stash... ";
echo exec("git stash save \"auto stash\"");
echo "Fetching latest tag info... ";
echo exec("git fetch --tags");
echo "Checking-out latest tag";
echo exec("git checkout `git tag | tail -1`");
echo "Performing submodule update... ";
echo exec("git submodule init");
echo exec("git submodule update");

// Run updates
include_once(elgg_get_plugins_path()."z02_clipit_api/updates/run_updates.php");
