<?php
/**
 * Created by PhpStorm.
 * User: pebs74
 * Date: 20/01/2015
 * Time: 16:55
 */
$clipit_site_type = get_config("clipit_site_type");
if(empty($clipit_site_type)){
    set_config("clipit_site_type", "site");
}