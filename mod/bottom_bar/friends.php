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

//  gatekeeper();
  if (elgg_is_logged_in()) {
  $showFriendIcon = elgg_get_plugin_setting("friends_icons",$_SESSION['user']->guid,"bottom_bar");
  if ($showFriendIcon == "true") {
  $friends = $_SESSION['user']->getFriends("",1000);
   }
  $friends_online = 0;
  if (count($friends) > 0) {
    echo "<table width=100% id='bb_friendslist'>";
      foreach ($friends as $friend) {
	$icon = $friend->getIcon('topbar');
        if ($friend->last_action < time() - 600 || elgg_get_plugin_setting("chat_enabled",$friend->guid,"bottom_bar") == "false") {
        // Consider them offline if no action for 10 mins ..

        } elseif ($friend->last_action < time() - 300) {
          echo "<tr>";
	  if ($showFriendIcon) echo "<td width=10><img src='$icon'></td>";
	  echo "<td style='padding-left: 5px;'><a href='#' onClick='addChat(\"" . $friend->guid . "\", \"" . $friend->name . "\");'>" . $friend->name . "</a></td><td width=10 style='padding-top: 3px;'>";
          echo "<img src='" . $CONFIG->wwwroot . "mod/bottom_bar/graphics/icons/inactive.gif'>";
          $friends_online ++;
        } else {
          echo "<tr>";
	  if ($showFriendIcon) echo "<td width=10><img src='$icon'></td>";
	  echo "<td style='padding-left: 5px;'><a href='#' onClick='addChat(\"" . $friend->guid . "\", \"" . $friend->name . "\");'>" . $friend->name . "</a></td><td width=10 style='padding-top: 3px;'>";
          echo "<img src='" . $CONFIG->wwwroot . "mod/bottom_bar/graphics/icons/online_s.png'>";
          $friends_online ++;
        }
        echo "</td></tr>";
      }
    echo "</table>";
  }

  if ($friends_online == 0) {
    //echo "No friends online";
    echo elgg_echo('bbar:bar:noneonline');
  }
  echo "|" . $friends_online;

  }
?>
