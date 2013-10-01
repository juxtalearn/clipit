<?php
        /*
        **
        ** Facebook-esque bottom bar
        **
        ** @package bottom_bar
        ** @author Jay Eames - Sitback
        ** @link http://sitback.dyndns.org
        ** @copyright (c) Jay Eames 2009
        ** @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
        **
        */

?>


#elggchat_toolbar {
	background: #EBEEF4;
border: 1px solid #BAC0CD;
border-bottom: 0;
-webkit-box-shadow: inset 0 1px rgba(255, 255, 255, .5);
bottom: 0px;
left: 15px;
display: block;
font-family: "Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
font-size: 11px;
width: 100%;
position: fixed;
height: 29px;
text-align: left;
z-index: 1028;
margin-top: 8px;
} 

#html #elggchat_toolbar {
	position: fixed;
	bottom: 0px;
	height: 25px;
	left: 0px;
	z-index: 900;
	background: #DEDEDE;
}

#elggchat_toolbar_left {

	
	float:right;
	
	
	
}

#elggchat_copyright{
	color: #CCCCCC;
	padding-left: 5px;
	float:left;
	display: none;
}

.session {
	float: left;
	background: #E4ECF5;
	
	border: 1px solid #d2d2d2;
	
    padding:3px;
    margin:0 5px 5px 5px;
    
    /* ie fix */
	max-width:200px;
}

.elggchat_session_new_messages {
	background: #333333;
}

.elggchat_session_new_messages.elggchat_session_new_messages_blink{
	background: #E4ECF5;
}

#elggchat_extensions{
	float:right;
	border-left:1px solid #CCCCCC;
	padding: 0 5px 0 5px;	
}

#elggchat_friends{
	float:right;
	border-left:1px solid #d2d2d2;
    height: 29px;
    margin:0px;
	
	
}

#elggchat_friends_picker{
	display:none;
	border: 1px solid #BAC0CD;
background-color: white;
position: fixed;
width: 195px;
font-family: "Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
font-size: 11px;
text-align: left;
z-index: 1025;
line-height: normal;
bottom: 29px !important;
padding:5px;



}

#elggchat_friends_picker .settings{
	font-size: 90%;
	background-color: #DEDEDE;
}
.toggle_elggchat_toolbar {
	border-top:1px solid #ccc;	
	width: 15px;
	height: 100%;
	float:left;
	background:transparent url(<?php echo $CONFIG->wwwroot; ?>mod/elggchat/_graphics/minimize.png) repeat-x left center;	
}

.minimizedToolbar {
	background-position: right center;
	border-right:1px solid #d2d2d2;
			
}

.messageWrapper {
	background:white;
	
    padding:10px;
    margin:0 5px 5px 5px;
}

.messageWrapper table{
	background: white;
	height: 0px;
	font-size: 10px;
}
.systemMessageWrapper {
	

    padding:3px;
    margin:0 5px 5px 5px;
	color: #999999;
}

.messageIcon {
	margin-right: 7px;
}

.messageName {
	border-bottom:1px solid #DDDDDD;
	width: 100%;
	font-weight: bold;
	color: #4690D6;
}

.chatsessiondatacontainer {
	width:200px;
	display: none;
}

.chatsessiondata{
	border: 1px solid #d2d2d2;
	border-bottom: 0px;
	background: #f2f2f2;
	margin: 0 -4px;
	position:absolute;
	bottom:17px;
	width:206px;
	max-height:600px;
	overflow:hidden;
}

.chatmembers{
	border-bottom: 1px solid #DEDEDE;
	max-height:154px;
	overflow-y:auto;
margin-left:2px;
margin-bottom:2px;
margin-top:2px;
}

.chatmember td{
	vertical-align: middle;
}

.chatmembers .chatmemberinfo{
	width: 100%;
}
.chatmembersfunctions {
	text-align:right;
	padding-right:2px;
	height:20px;
	border-bottom: 1px solid #DEDEDE;
	font-size:10px;
}
.chatmembersfunctions_invite{
	display:none;
	text-align:left;
	position:absolute;
	background: #333333;
	width:100%;
	opacity: 0.8;
	filter: alpha(opacity=80);
	max-height:250px;
	overflow-x: hidden;
	overflow-y: auto;	
}

.chatmembersfunctions_invite a {
	color: #FFFFFF;
	padding:3px;
}

.online_status_chat{
	width:24px;
	height:24px;
	background: transparent url("<?php echo $CONFIG->wwwroot; ?>mod/elggchat/_graphics/online_status.png") no-repeat 0 0;
}

.online_status_idle{
	background-position: 0 -24px;
}

.online_status_inactive{
	background-position: 0 -48px;
}

.elggchat_session_leave{
	margin: 2px 0 0 4px;	
	float:right; 
	cursor: pointer;
	width:14px;
	height:14px;
	background: url("<?php echo $CONFIG->wwwroot; ?>_graphics/icon_customise_remove.png") no-repeat 0 0;
	
}

.elggchat_session_leave:hover{
	background-position: 0 -16px;
}

.chatmessages{
	min-height: 250px;
	max-height: 400px;
	overflow-y:auto;
}

.elggchatinput{
	background: #FFFFFF url("<?php echo $CONFIG->wwwroot; ?>mod/elggchat/_graphics/chatwindow/chat_input.png") no-repeat 1px 50%;
	padding-left:18px;
	border-top: 1px solid #DEDEDE;
	border-bottom: 1px solid #DEDEDE;
	height:22px;
}

.elggchatinput input{
	border: none;
	font-size:100%;
	padding: 2px;
}

.elggchatinput input:focus{
	border: none;
	background:none;
}









#bb_left_menu {
    position: fixed;
    bottom: 25px;
    left: 2px;
    padding: 5px;
    background: #ccccdd;
    border: solid 1px #999999;
    z-index: 10010;
    display: none;
}

#bb_left_menu_top {
    text-align: right; 
    cursor: pointer;
    font-size: 18px;
    font-weight: 900;
    line-height: 80%;
    border-bottom: solid 1px #aaaaaa;
    margin-bottom: 5px;
}

#bb_left_menu table {
    background: #ffffff;
    -moz-border-radius-topleft: 5px;
    -moz-border-radius-topright: 5px;
    -moz-border-radius-bottomright: 5px;
    -moz-border-radius-bottomleft: 5px;
    font-size: 15px;
    font-face: verdana, tahoma;
    font-weight: bold;
    padding: 5px;
}

#bb_left_menu td {
    padding: 3px;
}

#bb_left_menu td:hover{
    background: #ddddff;
}

#bb_container {
    height: 25px; 
    width: 100%; 
    bottom: 0px; 
    position:fixed; 
    z-index: 10000;
}

#bb_bar {
    width: 100%;
    height: 25px;
    margin-left: auto;
    margin-right: auto;
    overflow: hidden;
    border: solid 1px #999999;
    background-color:#d2d2d2;
}

#bb_notification_top {
    color: blue;
    font-weight: 900;
    font-size: 12px;
    width: 100%;
    padding: 2px 0px 0px 0px;
}

#bb_notification_main {
    background: #ffffff;
    -moz-border-radius-topleft: 5px;
    -moz-border-radius-topright: 5px;
    -moz-border-radius-bottomright: 5px;
    -moz-border-radius-bottomleft: 5px;
    font-size: 11px;
    font-face: verdana;
}

#bb_bar_icon {
    width: 50px;
    padding-left: 5px;
}

#newPosts {
    width: 200px;
    max-height: 80%;
    right: 5px;
    bottom: 25px;
    background: #ccccdd;
    border: solid 1px #999999;
    position: fixed;
    display: none;
    z-index: 10000;
    overflow: hidden;
    padding: 0px 5px 5px 5px;
}

#bb_chat {
    width: 170px; 
    max-height: 80%;
    right: 5px;
    bottom: 25px;
    background: #ccccdd;
    border: solid 1px #999999;
    position: fixed;
    display: none;
    z-index: 10000;
    padding: 5px;
    overflow: auto;
}

#bb_friends_top {
    color: blue;
    font-size: 12px;
    width: 100%;
    padding: 0px 0px 2px 0px;
}

#bb_friends_main {
    background: #ffffff;
    -moz-border-radius-topleft: 5px;
    -moz-border-radius-topright: 5px;
    -moz-border-radius-bottomright: 5px;
    -moz-border-radius-bottomleft: 5px;
    font-size: 11px;
    font-face: verdana;
    padding: 5px;
}

#bb_friendslist {
}

#bb_friends_bartitle {
    color: white;
    font-size: 10px;
    margin-left: 5px;
}
#bb_chat_toolbar {
	position: fixed;
	bottom: 0px;
	height: 25px;
	left: 0px;
	z-index: 9999;
	background: #DEDEDE;
    
} 
#bb_friendslist_button {
    border-left: solid 1px #999999; 
    cursor: pointer;
}

#bb_newposts_button {
    border-left: solid 1px #999999; 
    text-align: center;
    cursor: pointer;
}

#showMine, #showAll {
    padding: 0px 10px 5px 10px;
}

#bb_chat_list {
    border-left: solid 1px #999999;
}

#bb_chat_list_area {
    width: 100%;
}

.bb_chat_list_button {
    width: 120px;
     height: 29px;
    border-left: 1px solid #BAC0CD;
    position: absolute;
   

    color: white;
    font-size: 10px;
    padding-left: 3px;
  
}

.bb_chat_window {
    border: solid 1px #ccccdd;
    width: 200px;
    background: #ffffff;
    position: absolute;
    bottom: 25px;
}


.bb_chat_div_tx {
    height: 20px;
}




.chatbox {
   

border: 1px solid #BAC0CD;
background-color: white;
position: fixed;
margin:0px;
width: 230px;
font-family: "Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
font-size: 11px;
text-align: left;
z-index: 9999;
line-height: normal;

}

.chatboxhead {
        background-color: #173455;
        padding:7px;
        color: #ffffff;
	font-size: 12px;
       text-shadow: 0px 1px 1px rgba(0, 0, 0, 0.5);
}

.chatboxblink {
        background-color: #176689;
        border-right:1px solid #176689;
        border-left:1px solid #176689;
}

.chatboxcontent {
        font-family: arial,sans-serif;
        font-size: 12px;
        color: #333333;
        height:200px;
        width:209px;
        overflow-y:auto;
        overflow-x:auto;
        padding:7px;
       
        background-color: #ffffff;
        line-height: 1.3em;
}

.chatboxinput {
       
        border-top:1px solid #cccccc;
        
}

.chatboxtextarea {
       background: none;
width: 195px;
border: 0px;
height: 18px;
padding: 1px 5px 0px 2px;
overflow: hidden;
font-family: "Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
font-size: 11px;
color: #444;
background-color: white;
outline: none;
resize: none;
text-align: left;
margin: 0px;
}

.chatboxtextareaselected {
        border: 2px solid #f99d39;
        margin:0;
}

.chatboxmessage {
        margin-left:1em;
}

.chatboxinfo {
        margin-left:-1em;
        color:#666666;

}

.chatboxmessagefrom {
        margin-left:-1em;
        font-weight: bold;
}

.chatboxmessagecontent {
}

.chatboxoptions {
        float: right;
}

.chatboxoptions a {
        text-decoration: none;
        color: white;
        font-weight:bold;
        font-family:Verdana,Arial,"Bitstream Vera Sans",sans-serif;
}

.chatboxtitle {
        float: left;
}
