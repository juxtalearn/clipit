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
        $path = "/var/www/repos/$_POST[project]"; 
        $a='';
        chdir($path);
        exec("git add .");  
        exec("git commit -m'message'");
        echo "<h3 align = center> Succesfully commited all the files.</h3>";
        break;
    case "export_users":
        print_r(ClipitUser::export_data());
        break;
    case "export_activities":
        print_r(ClipitActivity::export_data());
        break;

}

