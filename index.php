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
    function session_status() {
        if (!function_exists('session_id')) {
            return PHP_SESSION_DISABLED;
        }
        if (session_id() === "") {
            return PHP_SESSION_NONE;
        }
        return PHP_SESSION_ACTIVE;
    }
}
?>

<html>
<body>
<div align="center">

    <?php
    if (!isset($_SESSION["status"])){
        $_SESSION["status"] = "wait";
        ?>
        <h1>ClipIt Install Script</h1>
        <h2>Please fill in the form below:</h2>
        <h3>(typical values filled in)</h3>
        <form action="index.php" method="post" id="clipit_params">
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
                        <input size=30 type="text" name="mysql_user" value="root">
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

    <?php
    }else {
    if ($_SESSION["status"] == "wait") {
        $_SESSION = $_POST;
        $_SESSION["status"] = "install";
        header("Refresh:0; url=index.php", true, 303);
        ?>
        <h1>ClipIt Install Script</h1>
        <h2>ClipIt is being downloaded</h2>
        <p>Meanwhile you can take a look at the ClipIt Introduction Video<br/>(it opens in a new tab)</p>
        <p><a target="_blank" href="http://www.youtube.com/watch?v=8lTAdtT1nFc"><img src="http://img.youtube.com/vi/8lTAdtT1nFc/0.jpg"/></a></p>
        <p>The install process will take a few minutes, <b>please don't close this page</b></p>

    <?php
    } else {
    if ($_SESSION["status"] == "install") {
    unset($_SESSION["status"]);
    $git_url = "https://github.com/juxtalearn/clipit.git";
    $mysql_host = $_SESSION["mysql_host"];
    $mysql_schema = $_SESSION["mysql_schema"];
    $mysql_user = $_SESSION["mysql_user"];
    $mysql_pass = $_SESSION["mysql_password"];
    ?>

    <h1>ClipIt Install Script</h1>

    <h2>Install Summary</h2>

    <p>cloning github repository...</p>
    <?php
    $base_path = getcwd();
    exec("mkdir git_tmp");
    chdir("$base_path/git_tmp");
    exec("cd git_tmp");
    exec("git init");
    exec("git remote add origin $git_url");
    exec("git fetch --tags");
    exec("git checkout `git for-each-ref --sort=committerdate --format='%(refname:short)' refs/tags | tail -1`");
    exec("mkdir .git/logs");
    exec("mkdir .git/logs/refs");
    exec("touch .git/logs/refs/stash");
    exec(chdir($base_path));
    exec("mv -f git_tmp/* .");
    exec("mv -f git_tmp/.* .");
    exec("rm -rf git_tmp");
    ?>

    <p>configuring data folder and permissions...</p>
    <?php
    exec("chmod -R 777 .");
    ?>

    <p>creating database...</p>
    <?php
    exec("mysql -h$mysql_host -u$mysql_user -p$mysql_pass -e'create database $mysql_schema;'");
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
    // PHP MEMCACHE
    $file_content .= "\$CONFIG->memcache = true;\n";
    $file_content .= "\$CONFIG->memcache_servers = array (\n";
    $file_content .= "    array('127.0.0.1', 11211)\n";
    $file_content .= ");\n";
    fwrite($file_name, $file_content);
    fclose($file_name);
    ?>

    <p><b>ClipIt has been downloaded correctly!</b></p>

    <form method='GET' action="install.php">
        <input type="hidden" name="step" value="database">
        <input type="submit" value="Continue to initial setup...">
    </form>
</div>
</body>
</html>
<?php }
}
} ?>
</div></body></html>
