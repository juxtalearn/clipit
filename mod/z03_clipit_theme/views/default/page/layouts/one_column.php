<?php
/**
 * Elgg one-column layout
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['content'] Content string
 * @uses $vars['class']   Additional class to apply to layout
 */

$class = 'elgg-layout elgg-layout-one-column clearfix row';
if (isset($vars['class'])) {
	$class = "$class {$vars['class']}";
}

// navigation defaults to breadcrumbs
$nav = elgg_extract('nav', $vars, elgg_view('navigation/breadcrumbs'));
// Filter menu
$filter = elgg_extract('filter', $vars);
?>
<div class="<?php echo $class; ?>">
	<div class="elgg-body elgg-main col-md-12">
    <?php if (isset($vars['title'])):?>
        <div class='elgg-head-layout' <?php echo $title_style;?>>
            <?php echo $nav;?>
            <?php echo elgg_view_title($vars['title']);?>
        <?php if ($sub_title = $vars['sub_title']):?>
            <small class="<?php echo $sub_title['title'];?>"><?php echo $sub_title['title'];?></small>
        <?php endif;?>
       </div>
    <?php endif;?>
        <?php echo $filter; ?>
        <div class="content">
            <?php echo $vars['content']; ?>
        </div>

	</div>
</div>