<?php
/**
 * Page Layout
 *
 * Contains CSS for the page shell and page layout
 *
 * Default layout: 990px wide, centered. Used in default page shell
 *
 * @package Elgg.Core
 * @subpackage UI
 */
?>

/* ***************************************
	PAGE LAYOUT
*************************************** */
/***** DEFAULT LAYOUT ******/
<?php // the width is on the page rather than topbar to handle small viewports ?>
.elgg-page-default {
	min-width: 980px;
}
.elgg-page-default .elgg-page-header > .elgg-inner {
	width: 990px;
	margin: 0px auto 10px;
	height: auto;
}
.elgg-page-default .elgg-page-body > .elgg-inner {
	width: 990px;
	margin: 0 auto;
}
.elgg-page-default .elgg-page-footer > .elgg-inner {
	width: 990px;
	margin: 0 auto;
	padding: 5px 0;
	/*border-top: 1px solid #DEDEDE;*/
}

/***** TOPBAR ******/
.elgg-page-topbar {
	background: #333333 url(<?php echo elgg_get_site_url(); ?>_graphics/toptoolbar_background.gif) repeat-x top left;
	border-bottom: 1px solid #000000;
	position: relative;
	height: 24px;
	z-index: 9000;
}
.elgg-page-topbar > .elgg-inner {
	padding: 0 10px;
}

/***** PAGE MESSAGES ******/
.elgg-system-messages {
	position: fixed;
    margin-top: 40px;
    right: 20px;
    max-width: 800px;
	z-index: 2000;
}
.elgg-system-messages li {
	margin-top: 10px;
}
.elgg-system-messages li p {
	margin: 0;
}

/***** PAGE HEADER ******/
.elgg-page-header {
	    background: none;
        margin-bottom: 10px;
}
.elgg-page-header > .elgg-inner {
	position: relative;
}

/***** PAGE BODY LAYOUT ******/
.elgg-layout {
	min-height: 0px;
}
.elgg-layout-one-sidebar {
    padding: 10px 0;
	background: rgba(255,255,255,0.9);
    box-shadow: 2px 3px 8px 2px rgba(150,150,150,0.8);
}
.elgg-layout-two-sidebar {
	background: transparent url(<?php echo elgg_get_site_url(); ?>_graphics/two_sidebar_background.gif) repeat-y right top;
}
.elgg-layout-error {
	margin-top: 20px;
}
.elgg-sidebar {
	position: relative;
	padding: 0 10px;
	float: right;
	width: 210px;
	margin: 0 0 0 10px;
}
.elgg-sidebar-alt {
	position: relative;
	padding: 20px 10px;
	float: left;
	width: 160px;
	margin: 0 10px 0 0;
}
.elgg-main {
    /*background: #fff;*/
	position: relative;
	min-height: 0px;
	padding: 0 10px;
}
.elgg-main > .elgg-head {
	//margin-bottom: 10px;
}

/***** PAGE FOOTER ******/
.elgg-page-footer {
	position: relative;
}
.elgg-page-footer {
	color: #999;
}
.elgg-page-footer a:hover {
	color: #666;
}
