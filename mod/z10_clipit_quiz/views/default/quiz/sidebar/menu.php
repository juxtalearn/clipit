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
elgg_register_menu_item('quiz:menu', array(
    'name' => 'quizzes',
    'text' => elgg_echo('quizzes'),
    'href' => "quizzes",
));

echo elgg_view_menu('quiz:menu', array(
    'sort_by' => 'register',
));