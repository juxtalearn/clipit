<?php

        /**
         * Facebook-esque bottom bar
         *
         * @package bottom_bar
         * @author Jay Eames - Sitback
         * @link http://sitback.dyndns.org
         * @copyright (c) Jay Eames 2009
         * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
         */

	 
?>


    $("#bb_left_menu").hide();

    if(!Array.indexOf){
    
      Array.prototype.indexOf = function(obj) {
      
	for(var i=0; i<this.length; i++){
    
	  if(this[i]==obj) return i;
	}
	return -1;
      }
    }

    // Create the function to see if the array key has already been created
    Array.prototype.keyExists = function(obj) {
      for (var k in this) {
	if (k == obj) return true;
      }
      return false;
    }
    
    var chatCount = 0;
    var easecount = 0;
    var bb_chat_windows = new Array();
    var bb_chat_cookie = new Array();

    var notifications;
    var easing;

    // To allow last messages
    var bb_chat_messages = new Array();
    var bb_chat_msg_pos = new Array();

   
 function bb_toggle(id){    
        if(bb_chat_windows.indexOf(id) == -1){
            showBBChatDiv("chatbox_" + id , true); 
            bb_chat_windows.push(id);        
        }
        else{    
            var splice;
            for (var box = 0; box < bb_chat_windows.length; box++) {            
                if (bb_chat_windows[box] == id) { 
                    splice = box;
                }
                bb_minimise(id);
                bb_chat_windows.splice(splice,1);
            }
        }
    }
    
function restructureChatBoxes() {
	align = 0;
	for (x in chatBoxes) {
		chatboxtitle = chatBoxes[x];

		if ($("#chatbox_"+chatboxtitle).css('display') != 'none') {
			if (align == 0) {
				$("#chatbox_"+chatboxtitle).css('right', '20px');
			} else {
				width = (align)*(225+7)+20;
				$("#chatbox_"+chatboxtitle).css('right', width+'px');
			}
			align++;
		}
	}
}

    function addChat(chatboxtitle, chatwithname) {
    if ($("#chatbox_"+chatboxtitle).length > 0) {
		if ($("#chatbox_"+chatboxtitle).css('display') == 'none') {
			$("#chatbox_"+chatboxtitle).css('display','block');
			restructureChatBoxes();
		}
		$("#chatbox_"+chatboxtitle+" .chatboxtextarea").focus();
		return;
	}
        if ((bb_chat_windows.indexOf(chatboxtitle) == -1) && (typeof chatwithname != "undefined")) {
        
	   

      


        if($(".chatbox").length==0)
            $("body").append("<div class='containerChat'></div>");
            
        $(" <div />" ).attr("id","chatbox_"+chatboxtitle)
        .addClass("chatbox")
        .html('<div class="chatboxhead"><div class="chatboxtitle">' + chatwithname + '</div><div class="chatboxoptions"><a href="javascript:void(0)" onclick="javascript:bb_minimise(\''+chatboxtitle+'\')">-</a> <a href="javascript:void(0)" onclick="javascript:bb_maximize(\''+chatboxtitle+'\')">+</a>  <a href="javascript:void(0)" onclick="javascript:bb_close(\''+chatboxtitle+'\')">X</a></div><br clear="all"/></div><div class="chatboxcontent"></div><div class="chatboxinput"><input type="text" name="chat_' + chatboxtitle + '"  onkeydown="javascript:return checkChatBoxInputKey(event,this,\''+chatboxtitle+'\');" style="height: 35px;width: 100%;box-sizing: border-box;-moz-box-sizing: border-box;margin-bottom: 0px;"></input></div>')
	    .appendTo($(".containerChat"));
        
	    $("#chatbox_" + chatboxtitle + " .chatboxcontent" ).append($.cookie(chatboxtitle + "_html"));
     	$("#chatbox_" + chatboxtitle + " .chatboxcontent").scrollTop($("#chatbox_" + chatboxtitle + " .chatboxcontent")[0].scrollHeight);
        

	  



        $("#chatbox_"+chatboxtitle).css('bottom', '0px');
        chatBoxeslength = 0;
        
        for (x in bb_chat_windows) {
		if ($("#chatbox_"+bb_chat_windows[x]).css('display') != 'none') {
			chatBoxeslength++;
		}
	}
        width = (chatBoxeslength)*(225+7)+20;
		$("#chatbox_"+chatboxtitle).css('right', width+'px');

       

        $("#chatbox_"+chatboxtitle).click(function() {
                if ($('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display') != 'none') {
                        $("#chatbox_"+chatboxtitle+" .chatboxtextarea").focus();
                }
        });

        $("#chatbox_"+chatboxtitle).show();
        $("#chatbox_"+chatboxtitle+" .chatboxtextarea").focus();

	if (bb_chat_windows.length > 0) {
	  for (var box in bb_chat_windows) {
	    $("#chatbox_" + bb_chat_windows[box] + ":visible").show();
	  }
	}

	bb_chat_windows.push(chatboxtitle);
	bb_chat_cookie.push(chatboxtitle + "|" + chatwithname + "|visible");
	updateCookie();

	
	easing = 500;
	easecount = 0;

	if (!bb_chat_messages.keyExists(chatboxtitle)) {
	  bb_chat_messages.push(chatboxtitle);
	  bb_chat_messages[chatboxtitle] = new Array();
    	  bb_chat_msg_pos.push(chatboxtitle);

	  if ($.cookie(chatboxtitle) != null) {
	    bb_chat_messages[chatboxtitle] = $.cookie(chatboxtitle).split("|~|");
	    bb_chat_msg_pos[chatboxtitle] = bb_chat_messages[chatboxtitle].length;
	  }
	}

      } else {
        if (typeof chatwithname != "undefined") {
	  showBBChatDiv("chatbox_" + chatboxtitle);
	}
      }
    }



  function checkMessages() { 

                var newMessage = false;

                $.ajax({
				url : "<?php echo $CONFIG->wwwroot; ?>mod/bottom_bar/chat.php?action=rx", 
				 
				success: function(data){
				if (data != "") {
	            try {
  	            newMessage = true;
            
	            msg = data.split("|",3);
            
	            if (bb_chat_windows.indexOf(msg[0]) == -1) {
          
	  	        addChat(msg[0], msg[1]);
              
 	            }
	      

	            var message = bbParseText(msg[2].replace(/^\s+|\s+$/g,"").replace(/\n/g,'<br />'));

	            if (message.substring(0,3)=="/me") {
		        message = message.substring(3).replace(/^\s+|\s+$/g,"");
                }

		       if (message.substring(0,1)=="'"){
               $("#chatbox_"+msg[0]+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom">' + msg[1] + '</span><span class="chatboxmessagecontent">' + message + '</span></div>');
		       } else {
               $("#chatbox_"+msg[0]+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom">' + msg[1] + '&nbsp;</span><span class="chatboxmessagecontent">' + message + '</span></div>');
	           } 
               $("#chatbox_"+msg[0]+" .chatboxcontent").scrollTop($("#chatbox_" + msg[0] + " .chatboxcontent")[0].scrollHeight);

               if (!$("#chatbox_" + msg[0]).is(':visible')) {
          
		       $("#chatbox_button_" + msg[0]).css('background','#ff0000');
             
	           }
            
               soundManager.play('msg_in');
               
               updateChatHistoryCookie(msg[0]);

	           easing = 500;
	           easecount = 0;

//            } else {
//	            alert("no messages");
	          } catch (ex) {

	          }
	          }
                

				}

				});
    
}
    setInterval("checkMessages()", 5000);

    function updateChatHistoryCookie(id) {
 	var last = $("#chatbox_" + id + " .chatboxcontent").html();
	if (last.length >= 2000) {
	   while (last.length > 2000 && last.toLowerCase().indexOf("</div>")!=-1) {
	     last = last.substring(last.indexOf("</div>")+6);
	   }
	}
	if (last.length <= 2000) $.cookie(id + "_html", last, { path: "/" });
    }

    function checkChatBoxInputKey(event,chatboxtextarea,chatboxtitle) {
	if(event.keyCode == 38 && bb_chat_messages.length >= 0) {
	  var pos = bb_chat_msg_pos[chatboxtitle]==0 ? 0 : --bb_chat_msg_pos[chatboxtitle];
	  $(chatboxtextarea).val(bb_chat_messages[chatboxtitle][pos]);
          return false;
	}

	if(event.keyCode == 40 && bb_chat_messages.length != 0) {
	  var pos = bb_chat_msg_pos[chatboxtitle]==bb_chat_messages[chatboxtitle].length ? bb_chat_messages[chatboxtitle].length : ++bb_chat_msg_pos[chatboxtitle];

	  if (pos >= bb_chat_messages[chatboxtitle].length) {
	    $(chatboxtextarea).val("");
	  } else {
	    $(chatboxtextarea).val(bb_chat_messages[chatboxtitle][pos]);
	  }

          return false;
	}


        if(event.keyCode == 13 && event.shiftKey == 0)  {

                message = $(chatboxtextarea).val();
		        origmsg = message.replace(/^\s+|\s+$/g,"");
                message = bbParseText(message.replace(/^\s+|\s+$/g,"").replace(/\n/g,'<br />'));

                $(chatboxtextarea).css('height','44px');
		        chatboxtextarea.value = "";
                $(chatboxtextarea).focus();
                if (message != '') {
                
                
                
                
                $.ajax({
				url : "<?php echo $CONFIG->wwwroot; ?>mod/bottom_bar/chat.php?action=tx", 
				data : {from: '<?php echo $_SESSION['user']->guid; ?>' ,to: chatboxtitle, message: origmsg}, 
				success: function(data,status){
				$("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom"><?php echo $_SESSION['user']->name; ?>&nbsp;</span><span class="chatboxmessagecontent">' + message + '</span></div>');
             
                $("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);
             
                updateChatHistoryCookie(chatboxtitle);

							}

				});
                
                }
		
                return false;
        }

        
    }
  
    function showBBChatDiv(div) {
      for (var check = 0; check < bb_chat_windows.length; check++)
      {
        var test = "chatbox_" + bb_chat_windows[check];
        var name = $("#" + test + " .chatboxtitle").html();
        if (name != null) {
          if (div != test) {
            $("#" + test + ":visible").hide();
            bb_chat_cookie[check] = bb_chat_windows[check] + "|" + name + "|hidden";
          } else {
            $("#chatbox_button_" + bb_chat_windows[check]).css('background','none');
            bb_chat_cookie[check] = bb_chat_windows[check] + "|" + name + "|visible";
          }
        }
      }
      updateCookie();
      $("#" + div).show();
      $("#" + div + " .chatboxtextarea").focus();
    }

    function bb_minimise(id) {

      $("#chatbox_"+id+" .chatboxcontent ").hide();
       $("#chatbox_"+id+" .chatboxinput ").hide();
      for (var check in bb_chat_windows) {
	var test = "chatbox_" + bb_chat_windows[check];
	var name = $("#" + test + " .chatboxtitle").html();
	if (name != null) {
	  if (id == bb_chat_windows[check]) {
	    bb_chat_cookie[check] = bb_chat_windows[check] + "|" + name + "|hidden";
	  }
	}
      }
      //$.cookie("bb_chat_cookie", bb_chat_cookie.join(","), { path: "/"});
      updateCookie();
    }


    function bb_maximize(id) {
      $("#chatbox_"+id+" .chatboxcontent").show();
        $("#chatbox_"+id+" .chatboxinput ").show();
      for (var check in bb_chat_windows) {
	var test = "chatbox_" + bb_chat_windows[check];
	var name = $("#" + test + " .chatboxtitle").html();
	if (name != null) {
	  if (id == bb_chat_windows[check]) {
	    bb_chat_cookie[check] = bb_chat_windows[check] + "|" + name + "|visible";
	  }
	}
      }
      //$.cookie("bb_chat_cookie", bb_chat_cookie.join(","), { path: "/"});
      updateCookie();
    }

    function bb_close(id) {
      // On closing a window, work out how many are above it and shuffle their positions down
      try {
        $("#chatbox_" + id).remove();
        $("#chatbox_button_" + id).remove();
        if (bb_chat_windows.length > 1) {
  	  var sort = false;
  	  var splice;
          for (var box = 0; box < bb_chat_windows.length; box++) {
 	    if (sort) {
	      var div = bb_chat_windows[box];
 	      var r = parseInt(($("#chatbox_" + div).css('right')).slice(0,-2))-150;
	      $("#chatbox_" + div).css('right', r + 'px');
	      $("#chatbox_button_" + div).css('right', r + 'px');
	    }
	    if (bb_chat_windows[box] == id) { 
	      sort = true; 
	      splice = box;
	    }
	  }
	  bb_chat_windows.splice(splice,1);
	  bb_chat_cookie.splice(splice,1);
        } else {
	  bb_chat_windows = new Array();
	  bb_chat_cookie = new Array();
          updateCookie();
        }
        chatCount--;
      }
      catch (err) {
	//alert(err.message);
      }
    }

   

   

    function initPage() {
      initWindows();
    }

    function initWindows() {
      bbwin = new Array();
      try {
        if ($.cookie("bb_chat_cookie")!= null) {
          var bbwinc = $.cookie("bb_chat_cookie");
	  if (bbwinc.indexOf(",") != -1) {
	    bbwin = bbwinc.split(",");
          } else {
	    bbwin.push(bbwinc);
	  }
          if (bbwin.length > 0) {
            for (var i=0; i < bbwin.length; i++) {
	      reloadWindows(bbwin[i]);
            }
          }
        }
      } 
      catch(err) {
	//alert(err.message);
      }
    }

    function updateCookie() {
      try {
        if (bb_chat_cookie.length > 0) {
	  $.cookie("bb_chat_cookie", bb_chat_cookie.join(","), { path: "/"});
        } else {
	  $.cookie("bb_chat_cookie", "", { path: "/"});
        }
      }
      catch (err) {
	//alert(err.message);
      }
    }

    function reloadWindows(hash) {
	var wins = hash.split("|");
	if (wins.length == 3) {
	  addChat(wins[0],wins[1]);
	  if (wins[2]=="hidden") bb_minimise(wins[0]);
	}
    }

    
   

    // Smiley replacement code! ;)

    var smiley_array = [":)",":D","8)",":P",":P",":o",":O",":(",":'(",";)",":lol:",":mad:",":heartbeat:",":love:",":eprop:",":wave:",":sunny:",":wha:",":yes:",":sleepy:",":rolleyes:",":lookaround:",":eek:",":confused_2:",":nono:",":fun:",":goodjob:",":giggle:",":cry:",":shysmile:",":jealous:",":whocares:",":spinning:",":coolman:",":littlekiss:",":laugh:"];
    var smiley_xhtml = ['ss.png','d.png','mafia.png','p.png','p.png','oh.png','oh.png','sad.png','cry.png','zmik.png',"Smileylol.gif","7_mad.gif","heartbeating.gif","SmileLove.gif","eProp.gif","SmileyWave.gif","sunnySmiley.gif","wha.gif","yes.gif","Smileysleep.gif","Smileyrolleyes.gif","SmileyLookaround.gif","Smileyeek.gif","Smileyconfused.gif","SmileyAnimatedNoNo.gif","propeller.gif","goodjob.gif","emot-giggle.gif","blueAnimatedCry.gif","Animatedshysmile.gif","AliceJealous.gif","19_indifferent.gif","Smileyspinning.gif","25_coolguy.gif","AliceSmileyAnimatedBlinkKiss.gif","LaughingAgua.gif"];
 
    function bbParseText(text)
    {
      // Check for any html code and disable
      ind = text.indexOf("<");
      while (ind != -1) {
	text = text.replace('<','&#60;');
	ind = text.indexOf("<");
      }

      ind = text.indexOf(">");
      while (ind != -1) {
	text = text.replace('>','&#62;');
	ind = text.indexOf(">");
      }


      // Parse url's and code them

      text = text.replace(/((https?\:\/\/|ftp\:\/\/)|(www\.))(\S+)(\w{2,4})(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/gi,function(url){
        nice = url;
        if( url.match('^https?:\/\/') ) {
	  nice = nice.replace(/^https?:\/\//i,'')
        } else {
	  url = 'http://'+url;
        }
	if ( url.indexOf('<?php echo substr($CONFIG->wwwroot,7); ?>') != -1)
          return '<a rel="nofollow" href="'+ url +'">'+ nice +'</a>';
	else
          return '<a target="_blank" rel="nofollow" href="'+ url +'">'+ nice +'</a>';
      });
      

      // Parse for underline and bold
      var b_open = false;

      ind = text.indexOf("*");
      while (ind != -1) {
	if (b_open) {
	  text = text.replace('*','</b>');
	} else {
	  text = text.replace('*','<b>');
	}
	b_open = !b_open;
	ind = text.indexOf("*");
      }
      if (b_open) text += "</b>";


      // Finally parse smiliey
      for (var i in smiley_array) {
        var smiley_img = '<img alt="" src="<?php echo $CONFIG->wwwroot; ?>mod/bottom_bar/graphics/icons/smilies/' + smiley_xhtml[i] + '" />';
  	var intIndexOfMatch = text.indexOf(smiley_array[i]);
	if (intIndexOfMatch != -1) {
  	  while (intIndexOfMatch != -1) {
   	    text = text.replace(smiley_array[i],smiley_img);
   	    intIndexOfMatch = text.indexOf(smiley_array[i]);
          }
        }
      }

      return text;
    }



jQuery.cookie = function(name, value, options) {
    if (typeof value != 'undefined') { // name and value given, set cookie
        options = options || {};
        if (value === null) {
            value = '';
            options.expires = -1;
        }
        var expires = '';
        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
            var date;
            if (typeof options.expires == 'number') {
                date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
            } else {
                date = options.expires;
            }
            expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
        }
        // CAUTION: Needed to parenthesize options.path and options.domain
        // in the following expressions, otherwise they evaluate to undefined
        // in the packed version for some reason...
        var path = options.path ? '; path=' + (options.path) : '';
        var domain = options.domain ? '; domain=' + (options.domain) : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    } else { // only name given, get cookie
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                // Does this cookie string begin with the name we want?
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
};

