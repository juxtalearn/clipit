<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   04/12/2014
 * Last update:     04/12/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
if (isset($vars['class'])) {
    $vars['class'] = "countries form-control {$vars['class']}";
} else {
    $vars['class'] = "countries form-control";
}
$countries = get_countries_list();
$value = $vars['value'];
$defaults = array(
    'value' =>  $value ? $value : '',
    'disabled' => false,
    'name' => 'country',
    'options_values' => $countries,
    'required' => $vars['required'] ? $vars['required']: false,
);

$vars = array_merge($defaults, $vars);

echo elgg_view('input/dropdown', $vars);