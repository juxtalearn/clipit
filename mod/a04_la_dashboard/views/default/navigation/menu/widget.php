<?php
//
// Archivo para que los widgets no puedan ser configurables


// we want css classes to use dashes
$vars['name'] = preg_replace('/[^a-z0-9\-]/i', '-', $vars['name']);
$headers = elgg_extract('show_section_headers', $vars, false);
$item_class = elgg_extract('item_class', $vars, '');

$class = "elgg-menu elgg-menu-{$vars['name']}";
if (isset($vars['class'])) {
    $class .= " {$vars['class']}";
}


foreach ($vars['menu'] as $section => $menu_items) {
    echo elgg_view('navigation/menu/elements/section', array(
        'items' => $menu_items,
        'class' => "$class elgg-menu-{$vars['name']}-$section",
        'section' => $section,
        'name' => $vars['name'],
        'show_section_headers' => $headers,
        'item_class' => $item_class,
    ));
}
elgg_load_js("lightbox");
elgg_load_css("lightbox");
elgg_load_js('la.widgets');

?>

