<?php
/**
 * Walled garden CSS 
 */

$url = elgg_get_site_url();
?>
.elgg-body-walledgarden {
    position: relative;
    top: 100px;
    margin-left: auto;
    margin-right: auto;
	width: 540px;
}
.elgg-module, .elgg-body{
    overflow: visible;
}
.elgg-module-walledgarden {
<!--	position: absolute;-->
<!--	top: 0;-->
<!--	left: 0;-->
}
.elgg-module-walledgarden > .elgg-head {
<!--	height: 17px;-->
}
.elgg-module-walledgarden > .elgg-body {
	/*padding: 0 10px;*/
}
.elgg-module-walledgarden > .elgg-foot {
	height: 17px;
}
.elgg-walledgarden-double > .elgg-head {
	/*background: url(<?php echo $url; ?>_graphics/walled_garden/two_column_top.png) no-repeat left top;*/
}
.elgg-walledgarden-double > .elgg-body {
	/*background: url(<?php echo $url; ?>_graphics/walled_garden/two_column_middle.png) repeat-y left top;*/
}
.elgg-walledgarden-double > .elgg-foot {
	/*background: url(<?php echo $url; ?>_graphics/walled_garden/two_column_bottom.png) no-repeat left top;*/
}
.elgg-walledgarden-single > .elgg-head {
	background: url(<?php echo $url; ?>_graphics/walled_garden/one_column_top.png) no-repeat left top;
}
.elgg-walledgarden-single > .elgg-body {
	background: url(<?php echo $url; ?>_graphics/walled_garden/one_column_middle.png) repeat-y left top;
}
.elgg-walledgarden-single > .elgg-foot {
	background: url(<?php echo $url; ?>_graphics/walled_garden/one_column_bottom.png) no-repeat left top;
}

.elgg-col > .elgg-inner {
	margin: 0 0 0 5px;
}
.elgg-col:first-child > .elgg-inner {
	margin: 0 5px 0 0;
}
.elgg-col > .elgg-inner {
	padding: 0 10px;
}

.elgg-walledgarden-single > .elgg-body {
	padding: 0 18px;
}

.elgg-module-walledgarden-login {
	margin: 0;
}
.elgg-body-walledgarden h3 {
	font-size: 2em;
	line-height: 1.1em;
    margin-top: 10px;
}

.elgg-heading-walledgarden {
	margin-top: 60px;
	line-height: 1.1em;
}

h1, h2, h3, h4, h5, h6 {
	color: #666;
}

a {
	color: #999;
}