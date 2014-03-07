<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 6/02/14
 * Time: 13:54
 * To change this template use File | Settings | File Templates.
 */
$group = elgg_get_page_owner_entity();

$header ='<a class="fa fa-chevron-down collapse" href="javascript:;"></a>';
$header .= "<span class=\"widget-viewall\">{$vars['all_link']}</span>";
$header .= '<h3>' . $vars['title'] . '</h3>';
$class = "module-".$vars['name'];

echo elgg_view_module('info', '', $vars['content'], array(
    'header' => $header,
    'class' => $class." elgg-module-widget",
));