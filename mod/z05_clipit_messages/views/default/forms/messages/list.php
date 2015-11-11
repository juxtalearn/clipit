<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
echo elgg_view('messages/list',
    array(
        'entity' => $vars['entity'],
        'sent' => $vars['sent'],
        'trash' => $vars['trash'],
        'inbox' => $vars['inbox'],
    )
);