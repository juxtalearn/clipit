<?php
session_start();
if($_POST["update_clipit"] == "YES") {
    // Pull latest version from GitHub
    chdir(elgg_get_root_path());
    echo "<h2>Updating ClipIt to latest release";
    echo "<h3>Performing local git stash and drop... ";
    echo exec("git stash save");
    echo exec("git stash drop");
    echo "<h3>Fetching latest tag info... ";
    echo exec("git fetch --tags");
    echo "<h3>Checking-out latest tag";
    echo exec("git checkout `git for-each-ref --sort=committerdate --format='%(refname:short)' refs/tags | tail -1`");
    echo "<h3>Performing submodule update... ";
    echo exec("git submodule init");
    echo exec("git submodule update");
    echo "<h3>Update complete to latest release";
    // Run updates
    include_once(elgg_get_plugins_path() . "z02_clipit_api/updates/run_updates.php");
}else{
    echo "<h2>This will check-out the latest ClipIt stable version and apply all necessary updates</h2>";
    echo "<h3>Current version: ".get_config("clipit_version")."</h3>";
    echo "<br><form action='update_clipit' method='post'>Are you sure you want to proceed? <input style='class=.elgg-button-action' name='update_clipit' value='YES' type='submit'></form>";
}