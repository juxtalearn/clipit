<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   29/09/2015
 * Last update:     29/09/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$user = elgg_extract('entity', $vars);
$value = isset($_COOKIE['ccr']) ? '1': '-1';
if ($user) {
    $title = elgg_echo('user:ccr:label');
    $input_name = 'ccr';
    $input = elgg_view("input/radio", array(
        "name" => $input_name,
        "value" => $value,
        'options' => array(
            ' '.elgg_echo('input:yes') => '1',
            ' '.elgg_echo('input:no') => '-1',
        ),
    ));
    $content = elgg_view("input/form_group", array(
        'label' => elgg_echo('ccr:set').':',
        'name'  => $input_name,
        'input' => $input
    ));
    echo elgg_view_module('info', $title, $content);

}