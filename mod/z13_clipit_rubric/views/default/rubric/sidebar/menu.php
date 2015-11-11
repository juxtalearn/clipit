<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   04/02/2015
 * Last update:     04/02/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
elgg_register_menu_item('rubric:menu', array(
    'name' => 'rubric',
    'text' => elgg_echo('rubrics'),
    'href' => "rubrics",
));

echo elgg_view_menu('rubric:menu', array(
    'sort_by' => 'register',
));
