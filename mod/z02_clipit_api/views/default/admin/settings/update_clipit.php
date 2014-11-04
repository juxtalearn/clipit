<?php
chdir(elgg_get_root_path());
echo "<h3>Performing local git stash... ";
echo exec("git stash save \"auto stash\"");
echo "<h3>Performing main git pull... ";
echo exec("git pull");
echo "<h3>Performing submodule update... ";
echo exec("git submodule init");
echo exec("git submodule update");
