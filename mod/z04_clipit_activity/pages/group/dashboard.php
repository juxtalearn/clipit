<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   8/09/14
 * Last update:     8/09/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$title = elgg_echo("group:home");
elgg_pop_breadcrumb($group->name);
elgg_push_breadcrumb($group->name);
$content = elgg_view('group/dashboard', array('entity' => $group));

$params = array(
    'content'   => $content,
    'filter'    => '',
    'title'     => $title,
);