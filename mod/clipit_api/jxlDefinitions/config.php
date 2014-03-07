<?php
/**
 * Created by JetBrains PhpStorm.
 * User: malzahn
 * Date: 21.02.14
 * Time: 07:55
 * To change this template use File | Settings | File Templates.
 */
define('SERVER', "192.168.1.21");
define('PORT',443);
define('USESSL',true);

if (USESSL)
    $url = "https://". SERVER . ":" . PORT ."/" . ENDPOINT;
else $url = "http://". SERVER . ":" . PORT ."/" . ENDPOINT;