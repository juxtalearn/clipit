<?php
$VERSION = "2.2.1";
$old_version = get_config("clipit_version");

if($VERSION === $old_version) return;

// list of update files for each version
$update_files = array(
    "2.2.0" => null,
    "2.2.1" => "update_2.2.1.php",
);

// advance until old version
while(key($update_files) != $old_version) next($update_files);
// skip old version update file
next($update_files);
// apply all updates from there onwards
while(key($update_files) != null){
    $value = current($update_files);
    if(!empty($value)){
        include_once((string)$value);
    }
};

set_config("clipit_version", $VERSION);

