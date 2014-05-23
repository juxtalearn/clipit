<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */

//$object = array_pop(ClipitFile::get_by_id(array($relationship->guid_two)));
$params = array(
    'icon' => 'upload',
    'message' => 'Upload the file',
    'item' => array(
        'url' => 'z04_clipit_activity/%d/file/view/%d',
        'description' => true,
        'icon' => "ICONO!!"
    )
);
register_clipit_feed($params, 'file');
