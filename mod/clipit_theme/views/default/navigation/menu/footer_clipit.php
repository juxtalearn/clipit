<?php
/**
 * Footer clipit navigation menu
 *
 */

$items = elgg_extract('menu', $vars);
$class = elgg_extract('class', $vars, false);
echo '<div class="'.$class.'">';
echo '<div class="row">';
foreach ($vars['menu'] as $section => $menu_items) {

    if($section == 'clipit') $class = "col-sm-3 col-xs-3";
    if($section == 'legal') $class = "col-sm-5 col-xs-5";
    if($section == 'help') $class = "col-sm-4 col-xs-4";

    echo elgg_view('navigation/menu/elements/section_footer', array(
        'items' => $menu_items,
        'class' => "$class",
        'section' => $section,
        'name' => $vars['name'],
        'show_section_headers' => $section
    ));
}

echo '</div>';
echo '</div>';
