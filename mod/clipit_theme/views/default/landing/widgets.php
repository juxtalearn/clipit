<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 6/02/14
 * Time: 12:31
 * To change this template use File | Settings | File Templates.
 */
$role = $vars['role'];
echo elgg_view("landing/".$role."/grid", $vars);
