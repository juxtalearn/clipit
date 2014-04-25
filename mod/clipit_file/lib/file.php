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
function format_file_size($bytes) {
    $bytes = (int)$bytes;
    if ($bytes >= 1000000000) {
        return round(($bytes / 1000000000), 2) . ' GB';
    }
    if ($bytes >= 1000000) {
        return round(($bytes / 1000000), 2) . ' MB';
    }
    return round(($bytes / 1000), 2) . ' KB';
}