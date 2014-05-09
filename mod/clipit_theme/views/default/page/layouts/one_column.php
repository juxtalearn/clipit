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
    <?php
            if (isset($vars['title'])) {
                echo "<div class='elgg-head-layout' {$title_style}>
                        {$nav}
                        ".elgg_view_title($vars['title'])."
                       </div>";
            }
        ?>
        <?php echo $filter; ?>
        <div class="content">
            <?php echo $vars['content']; ?>
        </div>

	</div>
</div>