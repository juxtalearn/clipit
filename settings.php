<?php

global $CONFIG;
if (!isset($CONFIG)) {
    $CONFIG = new stdClass;
}

$CONFIG->dbuser = 'root';

$CONFIG->dbpass = '';

$CONFIG->dbname = 'pebs_test';

$CONFIG->dbhost = 'localhost';

$CONFIG->dbprefix = 'clipit_';

$CONFIG->broken_mta = FALSE;

$CONFIG->db_disable_query_cache = FALSE;

$CONFIG->min_password_length = 6;
