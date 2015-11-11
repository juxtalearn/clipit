<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   9/09/14
 * Last update:     9/09/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$title = elgg_echo("activity:groups");
elgg_push_breadcrumb($title);
$params = array(
    'content'   => elgg_view('group/list', array('entity' => $activity)),
    'filter'    => '',
    'title'     => $title,
    'sub-title' => $activity->name,
    'title_style' => "background: #". $activity->color,
);