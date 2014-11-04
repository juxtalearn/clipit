<?php
session_start();
// FOR PHP < 5.4
if (!defined('PHP_SESSION_DISABLED')) {
    define('PHP_SESSION_DISABLED', 0);
}
if (!defined('PHP_SESSION_NONE')) {
    define('PHP_SESSION_NONE', 1);
}
if (!defined('PHP_SESSION_ACTIVE')) {
    define('PHP_SESSION_ACTIVE', 2);
}
if (!function_exists('session_status')) {
    function session_status(){
        if(!function_exists('session_id')) return PHP_SESSION_DISABLED;
        if (session_id() === "") return PHP_SESSION_NONE ;
        return PHP_SESSION_ACTIVE;
    }
}
?>

<html>
<body>
<div align="center">

<?php
if(!isset($_SESSION["status"])){
    $_SESSION["status"] = "wait";
    ?>
    <h1>ClipIt Install Script</h1>
    <h2>fill in the form below<br/>(recommended values already added)</h2>
    <form action="install_clipit.php" method="post">
        <table>
            <tr>
                <td>
                    <b>MySQL Host</b>
                </td>
                <td>
                    <input size=30 type="text" name="mysql_host" value="localhost">
                </td>
            </tr>
            <tr>
                <td>
                    <b>MySQL Schema</b>
                </td>
                <td>
                    <input size=30 type="text" name="mysql_schema" value="clipit">
                </td>
            </tr>
            <tr>
                <td>
                    <b>MySQL User</b>
                </td>
                <td>
                    <input size=30 type="text" name="mysql_user">
                </td>
            </tr>
            <tr>
                <td>
                    <b>MySQL Password</b>
                </td>
                <td>
                    <input size=30 type="text" name="mysql_password">
                </td>
            </tr>
        </table>
        <p><input type="submit"></p>
    </form>

<?php }else if($_SESSION["status"] == "wait") {
    $_SESSION = $_POST;
    $_SESSION["status"] = "install";
    header("Refresh:0; url=install_clipit.php", true, 303);
    ?>
    <h1>ClipIt Install Script</h1>
    <h2>ClipIt is being downloaded</h2>
    <p>This process will take a few minutes, please don't close this page</p>
    <p><img src="data:image/gif;base64,
    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
    rtw1cxELsPJ+vsLDmBAAOw==" alt="waiting" /></p>

<?php } else if($_SESSION["status"] == "install") {
    unset($_SESSION["status"]);
    $git_url = "https://github.com/juxtalearn/clipit.git";
    $clipit_tag ="2.2";
    $mysql_host = $_SESSION["mysql_host"];
    $mysql_schema = $_SESSION["mysql_schema"];
    $mysql_user = $_SESSION["mysql_user"];
    $mysql_pass = $_SESSION["mysql_password"];
    ?>

    <h1>ClipIt Install Script</h1>
    <h2>Install Summary</h2>

    <p>cloning github repository...</p>
    <?php
    echo exec("git clone -b $clipit_tag --recursive $git_url git_tmp");
    echo exec("mv -f git_tmp/* .");
    echo exec("mv -f git_tmp/.* .");
    echo exec("rmdir git_tmp");
    ?>

    <p>configuring data folder and permissions...</p>
    <?php
    echo exec("mkdir data");
    echo exec("chmod -R 777 .");
    ?>

    <p>creating database...</p>
    <?php
    echo exec("mysql -h$mysql_host -u$mysql_user -p$mysql_pass -e'create database $mysql_schema;'");
    ?>

    <p>creating settings.php file...</p>
    <?php
    $file_name = fopen("engine/settings.php", "w") or die("Unable to open file!");
    $file_content = "<?php\n";
    $file_content .= "global \$CONFIG;\n";
    $file_content .= "if (!isset(\$CONFIG)) { \$CONFIG = new stdClass; }\n";
    $file_content .= "\$CONFIG->dbhost = '$mysql_host';\n";
    $file_content .= "\$CONFIG->dbuser = '$mysql_user';\n";
    $file_content .= "\$CONFIG->dbpass = '$mysql_pass';\n";
    $file_content .= "\$CONFIG->dbname = '$mysql_schema';\n";
    $file_content .= "\$CONFIG->dbprefix = 'clipit_';\n";
    $file_content .= "\$CONFIG->broken_mta = FALSE;\n";
    $file_content .= "\$CONFIG->db_disable_query_cache = FALSE;\n";
    $file_content .= "\$CONFIG->min_password_length = 6;\n";
    fwrite($file_name, $file_content);
    fclose($file_name);
    ?>

    <p><b>ClipIt has been downloaded correctly!</b></p>
    <form method='GET' action="install.php">
    <input type="hidden" name="step" value="database">
    <input type="submit" value="Continue to initial setup...">
    </form>
    </div></body></html>
<?php } ?>
</div>
</body>
</html>