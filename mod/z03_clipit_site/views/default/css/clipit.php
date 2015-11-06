<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   24/02/2015
 * Last update:     24/02/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
switch(get_config('clipit_site_type')){
    case ClipitSite::TYPE_SITE:
    case ClipitSite::TYPE_DEMO:
        $plugin_dir = elgg_get_plugins_path().'z03_clipit_site';
        break;
    case ClipitSite::TYPE_GLOBAL:
        $plugin_dir = elgg_get_plugins_path().'z03_clipit_global';
        break;
}

$plugin_url = elgg_get_site_url().'mod/z03_clipit_site';
$futurabold = 'futuralt-bold';
$futuralt = 'futuralt';
$futurabook = 'FuturaLT-Book';
$futuralight = 'FuturaLT-Light';
?>
    /* FontAwesome library load */
    @font-face {
    font-family: 'Futura';
    src: url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futuralt;?>.eot');
    src: url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futuralt;?>.eot') format('embedded-opentype'),
    url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futuralt;?>.woff') format('woff'),
    url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futuralt;?>.ttf') format('truetype'),
    url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futuralt;?>.svg#FuturaLTRegular') format('svg');
    }
    @font-face {
    font-family: 'FuturaBoldRegular';
    src: url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futurabold;?>.eot');
    src: url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futurabold;?>.eot') format('embedded-opentype'),
    url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futurabold;?>.woff') format('woff'),
    url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futurabold;?>.ttf') format('truetype'),
    url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futurabold;?>.svg#FuturaLTBold') format('svg');
    }
    <?php if(get_config('clipit_site_type') == ClipitSite::TYPE_GLOBAL):?>
    @font-face {
    font-family: 'FuturaBook';
    src: url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futurabook;?>.eot');
    src: url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futurabook;?>.eot') format('embedded-opentype'),
    url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futurabook;?>.woff') format('woff'),
    url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futurabook;?>.ttf') format('truetype'),
    url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futurabook;?>.svg#FuturaLTBold') format('svg');
    }
    @font-face {
    font-family: 'FuturaLight';
    src: url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futuralight;?>.eot');
    src: url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futuralight;?>.eot') format('embedded-opentype'),
    url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futuralight;?>.woff') format('woff'),
    url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futuralight;?>.ttf') format('truetype'),
    url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futuralight;?>.svg#FuturaLTBold') format('svg');
    }
    <?php endif;?>
<?php
require(elgg_get_plugins_path().'z03_clipit_site' . '/bootstrap/less/clipit/clipit_base.min.css');
if(get_config('clipit_site_type') == ClipitSite::TYPE_GLOBAL){
    require(elgg_get_plugins_path().'z03_clipit_site' . '/bootstrap/less/clipit/landing.min.css');
}
?>


/* LANDING */
.navbar-blue{
     background: #000000 !important;
}


.navbar-text.lang .lang-horizontal a {
    color: #CCCCCC;
    text-shadow: 1px 1px 0px #0084B4;
    font-size: 14px;
    font-family: FuturaBoldRegular,Impact,"Impact Bold",Helvetica,Arial,sans,sans-serif;
}

#footer {
    border-top: 2px solid #FFFFFF;
    height: auto;
    background-color: #000000;
    padding: 20px 0px;
    margin-top: 30px;
}

.btn-lg {
    padding: 10px 40px;
    background: #FFFFFF none repeat scroll 0% 0% !important;
    border: 0px none;
    background-color: #FFFFFF !important;
    font-family: FuturaBoldRegular,Impact,"Impact Bold",Helvetica,Arial,sans,sans-serif;
    border-radius: 60px;
    text-shadow: none;
    box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.43);
    text-transform: uppercase;
    color: #000000 !important;
    margin: 10px;
    opacity: 1;
}

.elgg-page-walledgarden .bg-blue {
    background-color: #32B4E5 !important;
}
.elgg-page-walledgarden .block h2 {
    font-family: FuturaBoldRegular,Impact,"Impact Bold",Helvetica,Arial,sans,sans-serif;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-size: 30px;
    color: #000000 !important;
}

.elgg-page-walledgarden .social-connect h2 {
    font-family: FuturaBoldRegular,Impact,"Impact Bold",Helvetica,Arial,sans,sans-serif;
    color: #FFFFFF;
    font-size: 45px;
    margin: 0px 0px 20px;
}

.jumbotron {
    background: #000000 !important;
}

#footer .site-map ul > li {
    margin: 10px 0px;
    letter-spacing: 1px;
    color: #FFFFFF !important;
}

.modal-title {
    margin: 0px;
    line-height: 1.42857;
    color: #000000 !important;
}

.elgg-page-walledgarden #modal-login .modal-body form .btn-primary {
    padding: 10px 20px;
    background: #000000 none repeat scroll 0% 0%;
    border: 0px none;
    font-family: FuturaBoldRegular,Impact,"Impact Bold",Helvetica,Arial,sans,sans-serif;
    text-transform: uppercase;
    text-shadow: none;
    box-shadow: none;
    color: #FFFFFF;
    border-radius: 60px;
}

.elgg-page-walledgarden #modal-login .modal-body form p.link a {
    color: #000000 !important;
}

body {
    background: #000 none repeat scroll 0% 0% !important;
}

.lang button{
    border: 1px solid #FFFFFF !important;
    background: #000000 !important;
}
.lang .active a{
    background: #CCCCCC !important;
}

.lang li a{
    color: #000000 !important;
}


/* MAIN */

li.separator{
    color: #000000 !important;
}

.navbar-default .navbar-nav li > a {
color: #000000;
}

.navbar-default .navbar-nav li > a:hover {
    background-color: #101010 !important;
    color: #FFFFFF !important;
}

.navbar-default .navbar-nav li > a:focus {
    color: #FFFFFF !important;
}

ul.top-account > li.open > a, ul.top-account > li.open > a > i {
    background: #404040 none repeat scroll 0% 0% !important;

}

ul.top-account > li.active > a {
    background: #101010 none repeat scroll 0% 0% !important;

}



.dropdown-menu > li.divider {
    background-color: #000000 !important;
}

.module-events .elgg-head h3 {
    color: #FFFFFF !important;
}

a {
    color: #000000;
}
a:hover, a:focus {
    color: #000000;
}

.elgg-module-widget .elgg-head h3 {
    color: #000000;
}

.blue-lighter {
    color: #000000;
}

.elgg-module-widget h3 {
    color: #000000 !important;
}

.module-events ul > li.event .event-section .event-date {
    color: #505050;
}

.margin-top-5 {
    color: #505050;
}

.module-activity_status .elgg-body .bar {
    background: #505050 none repeat scroll 0% 0%;
}



abbr[title], abbr[data-original-title] {
    color: #404040 !important;
}

.navbar-nav li.options .btn {
    color: #FFFFFF !important;
    background-color: #000000 !important;
}

.btn-default, .btn-primary {
    color: #FFF;
    background-color: #000000;
}

.show{
    color: #000000;
}

.btn-border-blue {
    color: #000000 !important;
    background: #FFF none repeat scroll 0% 0% !important;
    border: 1px solid #000000 !important;
}


.mce-btn {
    color: #000000 !important;
}

.mce-container, .mce-container *, .mce-widget, .mce-widget *, .mce-reset {
    color: #000000 !important;
}

.btn-default:hover, .btn-primary:hover, .btn-default:focus, .btn-primary:focus {
    background-color: #404040 !important;
}



/*ICONOS MÓVIL*/



.navbar-default .navbar-toggle .icon-bar {
    background-color: #000000;
}

.navbar-default .navbar-toggle:hover {
    background-color: #505050 !important;
}
/**/



/* EXPLORE */

.breadcrumb li a{
    color: #FFFFFF !important;
}

.nav-stacked a {
    color: #404040 !important;
}

.nav-stacked a:hover{
    background-color: #404040 !important;
    color: #FFFFFF !important;
}

.breadcrumb li:first-child::before {
    color: #FFFFFF !important;
}

.col-md-9 h2 {
   color: #FFFFFF !important;
}

h4.empty {
    color: #202020 !important;
}

.elgg-layout-one-sidebar.one-sidebar-default .elgg-sidebar .elgg-module-aside:nth-child(2) h4, .elgg-layout-one-column.one-sidebar-default .elgg-sidebar .elgg-module-aside:nth-child(2) h4,
.elgg-sidebar .elgg-module-aside h4{
    color: #FFFFFF !important;
}

.nav-tabs > li> a {
    color: #000000 !important;
}

.nav-tabs > li.active > a, .nav-tabs > li.elgg-state-selected > a {
    color: #000000 !important;
}

.tags > a.label {
    color: #000000 !important;
    border: 1px solid;
}
.tags .label-primary:hover, .tags .label-primary:focus {
    background-color: #202020 !important;
    color: #FFFFFF !important;
}



.dropdown .btn-options {
    color: #000000;
    border: 1px solid #000000;
}

.elgg-sidebar .text-muted {
    color: #202020 !important;
}

.table-order th a {
    color: #303030 !important;
}

.table {
    color: #303030 !important;
}

.nav-stacked > li.active {
    background-color: #404040 !important;
}

.nav-stacked > li.active a, .nav-stacked > li.active a:hover {
    color: #FFFFFF !important;
}

.nav-pills > li.active > a, .nav-pills > li.active > a:hover, .nav-pills > li.active > a:focus {
    color: #FFFFFF;
    background-color: #404040 !important;
}

.elgg-layout-one-sidebar.one-sidebar-default .elgg-sidebar .elgg-module-aside:nth-child(2) h4, .elgg-layout-one-column.one-sidebar-default .elgg-sidebar .elgg-module-aside:nth-child(2) h4, .elgg-sidebar .elgg-module-aside h4 {
    background-color: #000000 !important;
}

/* NEW TEST */

small, .small {
    color: #505050 !important;
}

h4 small, h5 small, h6 small, h4 .small, h5 .small, h6 .small {
    color: #FFFFFF !important;
}





.bg-blue {
    background: #000000 none repeat scroll 0% 0% !important;
}

.bg-blue-lighter {
    background-color: #A0A0A0 !important;
}

.dropdown-menu > li > a {
    color: #000000 !important;
}

h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
    color: #000000 !important;
}

.module-controls .tab-set li.active a {
    color: #000000 !important;
}

.module-controls .tab-set li a {
    color: #505050 !important;
}

.margin-bottom-10 .text-muted {
    color: #707070 !important;
}

#footer .site-map h4 {
    color: #FFFFFF !important;
}

.text-left .small {
    color: #000000 !important;
}

.rubric-rating-value{
    color: #000000 !important;
}

.row-horizon > .rubric-item {
    background-color: #000000 !important;
}

.rubric-item p{
    color: #FFFFFF !important;
}
.col-md-3 .btn-border-red {
    background: #000000 none repeat scroll 0% 0%;
    color: #FFFFFF !important;
}



/* CREATE ACTIVITY */

.step-point {
    background-color: #000000 !important;
}

.elgg-layout-one-sidebar .elgg-main h2, .elgg-layout-one-column .elgg-main h2 {
    color: #FFFFFF;
}

.content-block P{
    color: #505050 !important;
}


.margin-right-10 {
    color: #505050 !important;
}

.task-title{
    color: #000000 !important;
}

#attach_list ul.menu-list > li.selected {
    background: #000000 none repeat scroll 0% 0% !important;
    color: #FFFFFF !important;
}

.btn-border-red {
    background: #FFF none repeat scroll 0% 0%;
    color: #000000 !important;
}

.grouping-mode .title-block {
    color: #000000 !important;
}

.ms-container .ms-selectable::after {
    color: #000000 !important;
}

.activity-layout .elgg-head-layout {
   background-color: #000000 !important;
}

.activity-section .elgg-head-layout h4 {
    color: #FFFFFF !important;
}

/* EDITAR ACTIVIDAD */



.col-md-5 .blue {
    color: #000000 !important;
}



a .btn-border-red{
    border: 1px solid #000000 !important;
}

.compose-message-button {
    background: #707070 none repeat scroll 0% 0%;
    border: 1px solid #707070 !important;
    color: #FFFFFF !important;
}

.compose-message-button:hover {
    background: #FFFFFF none repeat scroll 0% 0%;
    border: 1px solid #FFFFFF !important;
    color: #000000 !important;
}

.elgg-module-aside .elgg-body small {
   color: #FFFFFF !important;
}

.fc-header-title h2{
    color: #000000 !important;
}

.fc-day-number {
    color: #000000 !important;
}

.fc-ranged {
    color: #000000 !important;
    font-weight: bold;
    background-color: #CCCCCC !important;
    cursor: pointer;
}



.fc-event {
    border: 1px solid #000000 !important;
    background-color: #000000 !important;
}


.fc-day-content {
    background-color: #CCCCCC !important;
}

.fc-widget-content{
    color: #CCCCCC !important;
}

/* FA */

ul.top-account > li .fa.fa-caret-down{
    color: #000000 !important;
}

.navbar-nav > li > a:hover .fa.fa-caret-down {
    color: #FFFFFF !important;
}

ul.top-account > li .fa.fa-envelope {
 color:#000000 !important;
}

.navbar-nav > li > a:hover .fa.fa-envelope {
    color: #FFFFFF !important;
}

ul.top-account > li ul.caret-menu > li > a > .fa {
    color: #000000 !important;
}

ul.top-account > li ul.caret-menu > li > a:hover > .fa {
    color: #FFFFFF !important;
}

.elgg-module-widget .separator {
    border-top: 1px solid #000000;
}

.fa.fa-circle.fa-stack-2x.blue {
    color: #000000 !important;
}

.compose-message-button:hover .fa.fa-pencil, .compose-message-button:hover {
    color: #505050 !important;
    background-color: #FFFFFF !important;
}

.compose-message-button {
    background: #FFFFFF none repeat scroll 0% 0% !important;
    color: #000000 !important;
    background-color: #FFFFFF !important;
}

.fa.fa-pencil {
    color: #000000 !important;
}

/* FA MOVIL */

.navbar-default ul.top-account li a .fa.fa-globe, .navbar-default ul.top-account li a .fa.fa-cogs, .navbar-default ul.top-account li a .fa.fa-list-alt
{
    color: #000000;
}

.navbar-default ul.top-account li a:hover .fa.fa-globe, .navbar-default ul.top-account li a:hover .fa.fa-cogs
, .navbar-default ul.top-account li a:hover .fa.fa-list-alt, .navbar-default ul.top-account li a:hover .fa.fa-envelope{
    color: #505050 !important;
}

.navbar-default ul.top-account li a:focus .fa.fa-globe, .navbar-default ul.top-account li a:focus .fa.fa-cogs
, .navbar-default ul.top-account li a:focus .fa.fa-list-alt, .navbar-default ul.top-account li a:focus .fa.fa-envelope {
color: #505050 !important;
}

.navbar-default ul.top-account li.active a .fa {
  color: #000000 !important;
}

.fa.fa-sign-out{
    color: #FFFFFF !important;
}

.fa.fa-sort.blue {
    color: #000000 !important;
}

.fa.fa-user.blue {
    color: #000000 !important;
}

.dropdown-menu > li > a:hover, .dropdown-menu > li > a:focus {
    background-color: #F5F5F5;
    color: #505050 !important;
}


.title-block.margin-top-0{
    color: #000000 !important;
    border-bottom: 6px solid #000000;
}

.margin-bottom-10 .title-block{
    color: #000000 !important;
    border-bottom: 6px solid #000000;
}

h3.title-block{
    color: #000000 !important;
    border-bottom: 6px solid #000000;
}


.text-muted .fa.fa-minus{
    color: #000000 !important;
}

.col-md-6.text-right .text-muted {
    color: #000000 !important;
}

.activity-module-title {
color: #000000 !important;
border-top: 6px solid #000000 !important;
}

.blue.fa.fa-pencil-square-o {
    color: #000000 !important;
}

.date.show > span {
    color: #000000 !important;
}

ul.deadline-list > li {
    color: #000000 !important;
}

.progress-bar {
    background: #000000 none repeat scroll 0% 0% !important;
}

.col-md-12  > div{
    color: #000000 !important;
}

h2 > small {
    color: #FFFFFF !important;
}

h3.text-truncate > a {
    color: #FFFFFF !important;
}

.form-group > label {
    color: #000000 !important;
}

/* STUDENTS' VIEW */

.module-tags ul.tag-cloud li a {
    color: #000000;
    border: 1px solid #000000;
}

.text-truncate.blue > span{
    color: #000000 !important;
}

.fa.fa-inbox {
    color: #000000 !important;
}

.elgg-sidebar .elgg-head h3 {
    color: #FFFFFF !important;
}

div.elgg-body > small {
    color: #FFFFFF !important;
}

.progress-bar[value="0"] {
    color: #000000 !important;
}

h1, h2, h3 {
    color: #000000;
}

h3 .yellow{
    color: #000000 !important;
}

.countdown {
    color: #000000 !important;
}

h3.text-muted {
    color: #000000 !important;
}

h4 .text-muted{
    color: #000000 !important;
}

fa.fa-plus.fa-stack-1x, fa.fa-stack-1x {
    color: #000000 !important,
}

.fa-stack-2x {
    color: #000000 !important;
}

.fa-stack-1x {
    color: #000000 !important;
}

.fa-comment, .fa-eye, fa-stack, .fa-stop{
    color: #000000 !important;
}

.panel-group p .text-muted {
    color: #000000 !important;
}

ul.deadline-list > li {
    border-bottom: 1px solid #000000 !important;
}

.fa-stack-1x {
color: #FFFFFF !important;
}

.elgg-message.elgg-state-success {
    background: #FFFFFF none repeat scroll 0% 0%;
}

.question-answer label {
    color: #000000 !important;
}

.green {
    color: #008000 !important;
}

.task-info .description {
    color: #000000 !important;
}

.pull-right abbr{
    color: #101010 !important;
}

.elgg-module-aside .elgg-body small {
    color: #000000 !important;
}

.blue {
    color: #000000 !important;
}

.admin-owner{
    color: #000000 !important;
}

.progress .progress-bar {
    background: #FFFFFF none repeat scroll 0% 0%;
    background-color: #505050 !important;
}

.elgg-module-aside .elgg-body .margin-bottom-5 > span{
    color: #FFFFFF !important;
}

.yellow {
    color: #000000 !important;
}
