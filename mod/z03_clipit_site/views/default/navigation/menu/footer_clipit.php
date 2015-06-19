<?php
/**
 * Footer clipit navigation menu
 *
 */

$items = elgg_extract('menu', $vars);
$class = elgg_extract('class', $vars, false);
?>
<div class="<?php echo $class;?>">
    <div class="row">
    <?php
    foreach ($vars['menu'] as $section => $menu_items):
        if($section == 'clipit') $class = "col-sm-4 col-xs-6 col-md-6 col-md-offset-1 col-sm-offset-3";
        if($section == 'tutorials') $class = "col-sm-4 col-xs-6 col-md-5 col-sm-offset-1 col-md-offset-0";
        if($section == 'legal') $class = "col-sm-5 col-xs-5";
        if($section == 'help') $class = "col-sm-4 col-xs-4";
    ?>
        <?php echo elgg_view('navigation/menu/elements/section_footer', array(
            'items' => $menu_items,
            'class' => "$class",
            'section' => $section,
            'name' => $vars['name'],
            'target' => $vars['target'] !== true ? "_blank" : false,
            'show_section_headers' => $section
        ));
        ?>
    <?php endforeach;?>
    </div>
</div>
