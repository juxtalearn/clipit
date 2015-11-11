<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   23/07/14
 * Last update:     23/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$header ='<a class="fa fa-minus collapse" aria-hidden="true" aria-label="Ocultar/Mostrar contenido" href="javascript:;"></a>';
$header .= "<span class=\"widget-viewall\">{$vars['all_link']}</span>";
$header .= '<h3>' . $vars['title'] . '</h3>';
$class = "module-".$vars['name'];

echo elgg_view_module('info', '', $vars['content'], array(
    'header' => $header,
    'class' => $class." elgg-module-widget",
));