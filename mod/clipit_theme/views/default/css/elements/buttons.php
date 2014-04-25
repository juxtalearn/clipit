<?php
/**
 * CSS buttons
 *
 * @package Elgg.Core
 * @subpackage UI
 */
?>
/* **************************
	BUTTONS
************************** */

/* Base */
/*.elgg-button {
	font-size: 14px;
	/*font-weight: bold;*/
    border: 0;
	width: auto;
	padding: 5px 10px;
    text-transform: uppercase;
    color: #fff;
	text-decoration: none;
	background: #faba00;
    margin: 5px 0px 5px 5px;
}*/

/*.elgg-button:hover {
    color: #000;
	background: #e5e5e5;
}*/

.elgg-button.elgg-state-disabled {
	background: #e5e5e5;
	cursor: default;
}


/* Submit: This button should convey, "you're about to take some definitive action" */
.elgg-button-submit {
    background: #97BF0D;
	text-decoration: none;
    float:right;
}

.elgg-button-submit:hover {
	text-decoration: none;
}



/* Cancel: This button should convey a negative but easily reversible action (e.g., turning off a plugin) */
.elgg-button-cancel {
    background-color: #F15A24;
	/*
    color: #333;
	background: #ddd url(<?php echo elgg_get_site_url(); ?>_graphics/button_graduation.png) repeat-x left 10px;
	border: 1px solid #999;
    */
}
.elgg-button-cancel:hover {
	/*
    color: #444;
	background-color: #999;
	background-position: left 10px;
	text-decoration: none;
    */
}

/* Action: This button should convey a normal, inconsequential action, such as clicking a link */
.elgg-button-action {
}

.elgg-button-action:hover,
.elgg-button-action:focus {
	text-decoration: none;
}

/* Delete: This button should convey "be careful before you click me" */
.elgg-button-delete {
	background-color: #F15A24;
    /*
    color: #bbb;
	text-decoration: none;
	border: 1px solid #333;
	background: #555 url(<?php echo elgg_get_site_url(); ?>_graphics/button_graduation.png) repeat-x left 10px;
	text-shadow: 1px 1px 0px black;
    */
}
.elgg-button-delete:hover {
	/*
    color: #999;
	background-color: #333;
	background-position: left 10px;
	text-decoration: none;
    */
}

.elgg-button-dropdown {
	padding:3px 6px;
	text-decoration:none;
	display:none;
	font-weight:bold;
	position:relative;
	margin-left:0;
	color: white;
	border:1px solid #71B9F7;
	
	-webkit-border-radius:4px;
	-moz-border-radius:4px;
	border-radius:4px;
	
	-webkit-box-shadow: 0 0 0;
	-moz-box-shadow: 0 0 0;
	box-shadow: 0 0 0;
	
	/*background-image:url(<?php echo elgg_get_site_url(); ?>_graphics/elgg_sprites.png);
	background-position:-150px -51px;
	background-repeat:no-repeat;*/
}

.elgg-button-dropdown:after {
	content: " \25BC ";
	font-size:smaller;
}

.elgg-button-dropdown:hover {
	background-color:#71B9F7;
	text-decoration:none;
}

.elgg-button-dropdown.elgg-state-active {
	background: #ccc;
	outline: none;
	color: #333;
	border:1px solid #ccc;
	
	-webkit-border-radius:4px 4px 0 0;
	-moz-border-radius:4px 4px 0 0;
	border-radius:4px 4px 0 0;
}
