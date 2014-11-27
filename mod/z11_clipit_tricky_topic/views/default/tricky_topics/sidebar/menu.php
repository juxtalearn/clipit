<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   27/11/2014
 * Last update:     27/11/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
elgg_register_menu_item('tricky_topic:menu', array(
    'name' => 'tricky_topics',
    'text' => elgg_echo('tricky_topics'),
    'href' => "tricky_topics",
));
elgg_register_menu_item('tricky_topic:menu', array(
    'name' => 'stumbling_blocks',
    'text' => elgg_echo('tags'),
    'href' => "tricky_topics/stumbling_blocks",
));

echo elgg_view_menu('tricky_topic:menu', array(
    'sort_by' => 'register',
));

