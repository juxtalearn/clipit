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


  require_once(dirname(dirname(dirname(__FILE__))) . '/engine/start.php');

  
    if (elgg_is_logged_in() && !is_null($_REQUEST['action'])) {
      if ($_REQUEST['action']=="rx") {
        $chat = $_SESSION['user']->getObjects("bb_chat");

        if (!is_null($chat) && $chat) {
	  $objCount = 0;
  	  foreach ($chat as $c) {
	    if ($objCount++ > 0) {
	      $c->delete();
	    } else {
	      $messages = $c->getAnnotations('messages');
	      foreach ($messages as $msg) {
	        $user = get_entity($msg['owner_guid']);
	        echo $msg['owner_guid'] . "|" . $user->name . "|" . stripslashes($msg['value']);
	        $msg->delete();
	      }
	    }

	    //$c->delete();
	  }
        } else {
	  echo "No object";
  	  $test = new ElggObject();
//	  $test->owner_guid = $_REQUEST['to'];
//	  $test->container_guid = $_REQUEST['to'];
  	  $test->subtype = "bb_chat";
	  $test->access_id = 2;
  	  $test->save();
	}
      } else if ($_REQUEST['action']=="tx") {
        $message = addslashes(html_entity_decode($_REQUEST['message']));
	$target = get_entity($_REQUEST['to']);
	$test = $target->getObjects("bb_chat");
	if ($test) {
	  $count = 0;
	  foreach ($test as $t) {
	    if ($count++ == 0) {
	      $t->annotate('messages', $message, 2);
	    } else {
	      $t->delete();
	    }
	  }
	}
      }
    }
  

?>
