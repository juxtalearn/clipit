<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 28/02/14
 * Time: 15:13
 * To change this template use File | Settings | File Templates.
 */
$params = array(
    'title' => elgg_echo('loading:content') . '...',
    'body' => '<i class="fa fa-spinner fa-spin blue-lighter fa-3x"></i>',
    'target' => $vars['id']
);
echo elgg_view("page/components/modal", $params);
?>