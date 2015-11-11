<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   17/11/2014
 * Last update:     17/11/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$result_id = get_input('entity-id');
$annotation = get_input('annotation');

ClipitQuizResult::set_properties($result_id, array('description' => $annotation));