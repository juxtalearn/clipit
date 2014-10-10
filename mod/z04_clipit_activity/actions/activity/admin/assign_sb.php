<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   01/10/2014
 * Last update:     01/10/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$tags = array();
$tags = get_input("tag");
$entity_id = get_input("entity-id");

ClipitGroup::set_tags($entity_id, $tags);

forward(REFERER);