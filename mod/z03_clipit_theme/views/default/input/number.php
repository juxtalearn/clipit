<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   07/11/2014
 * Last update:     07/11/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
if (isset($vars['class'])) {
    $vars['class'] = "elgg-input-number {$vars['class']}";
} else {
    $vars['class'] = "elgg-input-number";
}

$defaults = array(
    'value' => '',
    'disabled' => false,
);

$vars = array_merge($defaults, $vars);

?>
<input type="number" <?php echo elgg_format_attributes($vars); ?> />