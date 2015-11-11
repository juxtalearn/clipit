<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   27/11/2014
 * Last update:     27/11/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
elgg_register_menu_item('tricky_topic:menu', array(
    'name' => 'tricky_topics',
    'text' => '<i class="pull-right fa fa-caret-down"></i>'.elgg_echo('tricky_topics'),
    'href' => "tricky_topics",
));
elgg_register_menu_item('tricky_topic:menu', array(
    'name' => 'stumbling_blocks',
    'text' => elgg_echo('tags'),
    'href' => "tricky_topics/stumbling_blocks",
    'item_class' => 'margin-left-20_important'
));
elgg_register_menu_item('tricky_topic:menu', array(
    'name' => 'examples',
    'text' => elgg_echo('examples'),
    'href' => "tricky_topics/examples",
));
echo elgg_view_menu('tricky_topic:menu', array(
    'sort_by' => 'register',
));
