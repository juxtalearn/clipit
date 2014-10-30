<?php

$install_folder = $_POST["install_folder"];
$data_folder = $install_folder."_data";
$git_url = "https://github.com/juxtalearn/clipit.git";
$git_tag = "stable";
$mysql_schema = $_POST["mysql_schema"];
$mysql_user = $_POST["mysql_user"];
$mysql_pass = $_POST["mysql_password"];

echo "<html><body><div align=\"center\">";
echo "<h1>ClipIt Install Script</h1>";
echo "<h2>Install Progress</h2>";

echo "<p>creating install folder...</p>";
echo exec("mkdir ".$install_folder." ".$data_folder);

echo "<p>cloning github repository...</p>";
echo exec("git clone --recursive ".$git_url." ".$install_folder);
echo exec("cd ".$install_folder." && git checkout ".$git_tag);

echo "<p>setting permissions...</p>";
echo exec("chmod -R 777 ".$install_folder." ".$data_folder);

echo "<p>creating database...</p>";
echo exec("mysql -u".$mysql_user." -p".$mysql_pass." -e'create database ".$mysql_schema.";'");

echo "<p><b>ClipIt has been installed correctly!</b></p>";
echo "<form action=\"".$install_folder."\"><input type=\"submit\" value=\"Open ClipIt now\">";
echo "</div></body></html>";