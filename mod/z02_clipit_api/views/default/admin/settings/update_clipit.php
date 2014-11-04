<?php
$clipit_path = elgg_get_root_path();
chdir($clipit_path);
echo "<h3>Performing git stash... ";
echo exec("git stash save \"auto stash\"");
echo " ... done</h2>";
echo "<h3>Performing git pull... ";
echo exec("git pull --recurse-submodules");
echo " ... done</h3>";