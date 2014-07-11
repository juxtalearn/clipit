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
    case "import_users":
        print_r(ClipitUser::import_data("/tmp/clipit_users.xlsx"));
        break;
    case "export_users":
        print_r(ClipitUser::export_data());
        break;
}

