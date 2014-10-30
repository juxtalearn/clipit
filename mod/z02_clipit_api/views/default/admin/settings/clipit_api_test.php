<?php
/**
 * Created by PhpStorm.
 * User: pebs74
 * Date: 10/07/2014
 * Time: 15:14
 */
if(isset($_GET["action"])) {
    $action = $_GET["action"];
} else {
    print_r("No \"action\" specified");
    return;
}
switch($action) {
    case "git_pull":
        $clipit_path = elgg_get_root_path();
        chdir($clipit_path);
        echo exec("git stash save \"auto stash\"")."\r\n";
        echo exec("git pull --recurse-submodules")."\r\n";
        echo "<h3 align = center> Succesfully pulled all the files.</h3>";
        break;
    case "export_users":
        print_r(ClipitUser::export_data());
        break;
    case "export_activities":
        print_r(ClipitActivity::export_data());
        break;
}

