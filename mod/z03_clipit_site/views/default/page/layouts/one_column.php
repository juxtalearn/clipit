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
$body_class = $vars['body_class'];
if (!isset($body_class)) {
    $body_class = 'col-md-12';
}

// navigation defaults to breadcrumbs
$nav = elgg_extract('nav', $vars, elgg_view('navigation/breadcrumbs'));
// Filter menu
$filter = elgg_extract('filter', $vars);
?>
<div class="<?php echo $class; ?>">
	<div class="elgg-body elgg-main <?php echo $body_class;?>">
    <?php if (isset($vars['title'])):?>
        <div class='elgg-head-layout' <?php echo $title_style;?>>
            <?php echo $nav;?>
            <?php echo elgg_view_title($vars['title'] . $vars['sub_title']);?>
       </div>
    <?php endif;?>
        <?php echo $filter; ?>
        <div class="content">
            <?php echo $vars['content']; ?>
        </div>

	</div>
</div>