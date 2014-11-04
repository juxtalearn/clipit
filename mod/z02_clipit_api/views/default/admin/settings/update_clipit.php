<?php
$clipit_path = elgg_get_root_path();
chdir($clipit_path);
echo "<h3>Performing git stash... ";
echo exec("git stash save \"auto stash\"");
echo " ... done</h2>";
echo "<h3>Performing main git pull... ";
echo exec("git pull");
echo "<h3>Performing submodule update... ";
echo exec("git submodule update");
echo " ... done</h3>";