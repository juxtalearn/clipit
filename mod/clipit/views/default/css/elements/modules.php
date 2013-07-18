/* ***************************************
	Modules
*************************************** */
.elgg-module {
	overflow: hidden;
	margin-bottom: 20px;
}

/* Aside */
.elgg-module-aside .elgg-head {
	border:none;
    padding-bottom: 5px;
}

.elgg-module-aside input[type='text'] {
    width:195px;
}

/* Info */
.elgg-module-info > .elgg-head {
    background: #faba00;
	padding: 0px 10px 0px 10px;
	margin-bottom: 14px;
    color: #fff;
}

.elgg-module-info > .elgg-head * {
    text-transform: uppercase;
    font-size: 14px;
    font-weight: normal;
}

/* Popup */
.elgg-module-popup {
	background-color: white;
	border: 1px solid #faba00;
	
	z-index: 9999;
	margin-bottom: 0;
	padding: 5px;
	/*-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
    */
	box-shadow: 4px 4px 4px rgba(0, 0, 0, 0.5);
}
.elgg-module-popup > .elgg-head {
	margin-bottom: 5px;
}
.elgg-module-popup > .elgg-head * {
	color: #faba00;
}

/* Dropdown */
.elgg-module-dropdown {
	background-color:white;
	border:5px solid #CCC;
	
	-webkit-border-radius: 5px 0 5px 5px;
	-moz-border-radius: 5px 0 5px 5px;
	border-radius: 5px 0 5px 5px;
	
	display:none;
	
	width: 210px;
	padding: 12px;
	margin-right: 0px;
	z-index:100;
	
	-webkit-box-shadow: 0 3px 3px rgba(0, 0, 0, 0.45);
	-moz-box-shadow: 0 3px 3px rgba(0, 0, 0, 0.45);
	box-shadow: 0 3px 3px rgba(0, 0, 0, 0.45);
	
	position:absolute;
	right: 0px;
	top: 100%;
}

/* Featured */
.elgg-module-featured {
	border: 1px solid #faba00;
	background: #fff;
	/*
    -webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
    */
}
.elgg-module-featured > .elgg-head {
	padding: 5px;
	background-color: #faba00;
}
.elgg-module-featured > .elgg-head * {
	color: white;
}
.elgg-module-featured > .elgg-body {
	padding: 10px;
}

/* ***************************************
	Widgets
*************************************** */
.elgg-widgets {
	float: right;
	min-height: 30px;
}
.elgg-widget-add-control {
	text-align: right;
	margin-bottom: 10px;
    display:none;
}
.elgg-widgets-add-panel {
	padding: 10px;
	margin: 0 5px 15px;
	background: none;
	border: none;
}
<?php //@todo location-dependent style: make an extension of elgg-gallery ?>
.elgg-widgets-add-panel li {
	float: left;
	margin: 2px 10px;
	width: 200px;
	padding: 4px;
	background-color: #ccc;
	border: 2px solid #b0b0b0;
	font-weight: bold;
}
.elgg-widgets-add-panel li a {
	display: block;
}
.elgg-widgets-add-panel .elgg-state-available {
	color: #333;
	cursor: pointer;
}
.elgg-widgets-add-panel .elgg-state-available:hover {
	background-color: #bcbcbc;
}
.elgg-widgets-add-panel .elgg-state-unavailable {
	color: #888;
}

.elgg-module-widget {
	background: none;
	padding: 0;
	margin: 0 8px 16px;
	position: relative;
    box-shadow: 2px 3px 8px 2px rgba(150,150,150,0.8);
}
.elgg-module-widget:hover {
	/*background-color: #96BE0D;*/
}
.elgg-module-widget > .elgg-head {
    text-transform: uppercase;
	background-color: #faba00;
	height: 30px;
	overflow: hidden;
}
.elgg-module-widget > .elgg-head h3 {
    float: left;
    padding: 12px 10px 0px 10px;
    color: #fff;
    font-size:14px;
    line-height:8px;
    font-weight: normal;
}
.elgg-module-widget.elgg-state-draggable .elgg-widget-handle {
	cursor: move;
}
a.elgg-widget-collapse-button {
	color: #fff;
}
a.elgg-widget-collapse-button:hover,
a.elgg-widget-collapsed:hover {
	color: #fff;
	text-decoration: none;
}
a.elgg-widget-collapse-button:before {
	content: "\25BC";
}
a.elgg-widget-collapsed:before {
	content: "\25BA";
}
.elgg-module-widget > .elgg-body {
	background-color: rgba(255,255,255,0.8);
	width: 100%;
	overflow: hidden;
	border-top: 0;
}
.elgg-widget-edit {
	display: none;
	width: 96%;
	padding: 2%;
	border-bottom: 0;
	background-color: #f9f9f9;
}
.elgg-widget-content {
	padding: 10px;
}
.elgg-widget-placeholder {
	border: 2px dashed #faba00;
	margin-bottom: 12px;
}
