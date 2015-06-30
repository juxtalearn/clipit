<?php
/**
 * Layout for main column with one sidebar
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['content'] Content HTML for the main column
 * @uses $vars['sidebar'] Optional content that is displayed in the sidebar
 * @uses $vars['title']   Optional title for main content area
 * @uses $vars['class']   Additional class to apply to layout
 * @uses $vars['nav']     HTML of the page nav (override) (default: breadcrumbs)
 */

$class = 'elgg-layout elgg-layout-one-sidebar clearfix';
if (isset($vars['class'])) {
	$class = "$class {$vars['class']}";
}
$title_style = "";
if(isset($vars['title_style'])){
    $title_style = "style='{$vars['title_style']}'";
}
// navigation defaults to breadcrumbs
$nav = elgg_extract('nav', $vars, elgg_view('navigation/breadcrumbs'));
// Filter menu
$filter = elgg_extract('filter', $vars);
$subtitle = "";
if($vars['sub-title']){
    $subtitle = "<h4>".$vars['sub-title']."</h4>";
}
?>

<div class="<?php echo $class; ?>">
	<div class="elgg-sidebar col-md-push-9">
        <div class="visible-xs visible-sm text-right">
            <i class="fa fa-times btn text-muted" id="close-sidebar"></i>
            <hr style="margin: 10px 0;">
        </div>
		<?php
			echo elgg_view('page/elements/sidebar', $vars);
		?>
	</div>

	<div class="elgg-main elgg-body col-md-pull-3 col-md-9">
        <?php
            if (isset($vars['title'])) {
                echo "<div class='elgg-head-layout' {$title_style}>
                        {$nav}
                        {$vars['special_header_content']}
                        {$subtitle}
                        ".elgg_view_title($vars['title'], array('class' => 'text-truncate', 'title' => $vars['title']))."
                       </div>";
            }
        ?>
        <?php echo $filter; ?>
        <div class="content">
		<?php
			// @todo deprecated so remove in Elgg 2.0
			if (isset($vars['area1'])) {
				echo $vars['area1'];
			}
			if (isset($vars['content'])) {
				echo $vars['content'];
			}
		?>
        </div>
	</div>
</div>
