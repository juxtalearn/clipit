<?php

$git_url = "https://github.com/juxtalearn/clipit.git";
$mysql_host = $_POST["mysql_host"];
$mysql_schema = $_POST["mysql_schema"];
$mysql_user = $_POST["mysql_user"];
$mysql_pass = $_POST["mysql_password"];

echo "<html><body><div align=\"center\">";
echo "<h1>ClipIt Install Script</h1>";
echo "<h2>Install Progress</h2>";

echo "<p>cloning github repository...</p>";
echo exec("git clone -b stable --recursive ".$git_url." git_tmp");
echo exec("mv git_tmp/* . && mv git/.* .");
echo exec("rmdir git_tmp");

echo "<p>configuring data folder and permissions...</p>";
echo exec("mkdir data");
echo exec("chmod -R 777 .");

echo "<p>creating database...</p>";
echo exec("mysql -h".$mysql_host." -u".$mysql_user." -p".$mysql_pass." -e'create database ".$mysql_schema.";'");

echo "<p>creating settings.php file...</p>";
$file_name = fopen("engine/settings.php", "w") or die("Unable to open file!");
$file_content = "<?php\n";
$file_content .= "global \$CONFIG;\n";
$file_content .= "if (!isset(\$CONFIG)) { \$CONFIG = new stdClass; }\n";
$file_content .= "\$CONFIG->dbhost = '".$mysql_host."';\n";
$file_content .= "\$CONFIG->dbuser = '".$mysql_user."';\n";
$file_content .= "\$CONFIG->dbpass = '".$mysql_pass."';\n";
$file_content .= "\$CONFIG->dbname = '".$mysql_schema."';\n";
$file_content .= "\$CONFIG->dbprefix = 'clipit_';\n";
$file_content .= "\$CONFIG->broken_mta = FALSE;\n";
$file_content .= "\$CONFIG->db_disable_query_cache = FALSE;\n";
$file_content .= "\$CONFIG->min_password_length = 6;\n";
fwrite($file_name, $file_content);
fclose($file_name);

echo "<p><b>ClipIt has been installed correctly!</b></p>";
echo "<form method='GET' action=\"install.php\">";
echo "<input type=\"hidden\" name=\"step\" value=\"database\">";
echo "<input type=\"submit\" value=\"Continue...\">";
echo "</form>";
echo "</div></body></html>";