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

	  $english = array(

	  // Admin settings

		'bbar:admin:basicopts' 		=> 'Basic Options',
		'bbar:admin:refreshrate'	=> 'Refresh rate<br>(longer times = less server load)',
		'bbar:admin:idlethreshold'	=> 'User idle threshold',
		'bbar:admin:offlinethreshold'	=> 'User offline threshold',
		'bbar:admin:allowchat'		=> 'Allow chat?',
		'bbar:admin:forceloginpage'	=> 'Force users to the login page if logged out?',
		'bbar:admin:allowmenu'		=> 'Enable ELGG menu on clicking logo?',
		'bbar:admin:allowradio'		=> 'Enable Radio button?',
		'bbar:admin:allowsounds'	=> 'Enable Chat notification sounds?',
		'bbar:admin:radiourl'		=> 'Stream URL for radio<br>(must be an MP3, or an icecast server)',
		'bbar:admin:logolocation'	=> 'Logo image to be used bottom left:<br>(Leave blank to use the default. Can be jpg,gif or png. File to be stored in /mod/bottom_bar/graphics/icons/)',

		'bbar:admin:dbopts'		=> 'Database Options',
		'bbar:admin:dboptsdesc'		=> 'This plugin can use either its own SQLite database (which should be suitable for small to medium size sites) or can be upscaled to use MySQL via ELGG objects. If you are unsure about which setting to use, stick with SQLite',
		'bbar:admin:dboptstype'		=> 'Database type',
		'bbar:admin:dbmysqlopts'	=> '<b>Mysql Options</b> (ignore if you selected SQLite above)',
		'bbar:admin:dboptsuseelgg'	=> 'Use ELGG Settings/Database',
		'bbar:admin:dbmysqlsettings'	=> '<b>Mysql custom settings</b><br>(ignore if you are using SQLite or ELGG objects)',
		'bbar:admin:dbmysqlhost'	=> 'Host<br>(FQDNS or IP)',
		'bbar:admin:dbmysqluser'	=> 'Username<br>(Must have create privs)',
		'bbar:admin:dbmysqlpass'	=> 'Password',
		'bbar:admin:dbmysqldbase'	=> 'Database',
		'bbar:admin:dbmysqlprefix'	=> 'Table prefix',

		'bbar:admin:nosqlite'		=> 'SQLite extensions not installed - using ELGG Objects',

		'bbar:admin:second'		=> 'second',
		'bbar:admin:seconds'		=> 'seconds',
		'bbar:admin:minute'		=> 'minute',
		'bbar:admin:minutes'		=> 'minutes',

	  // User settings

		'bbar:user:enablechat'		=> 'Enable chat?',
		'bbar:user:enablesounds'	=> 'Enable sounds?',
		'bbar:user:enableicons'		=> 'Show user icons in friends list?',

	  // Bar language

		'bbar:bar:notifications'	=> 'Notifications',
		'bbar:bar:notify.all'		=> 'All',
		'bbar:bar:notify.mine'		=> 'Mine',
		'bbar:bar:friends'		=> 'Friends',
		'bbar:bar:online'		=> 'online',
		'bbar:bar:offline'		=> 'offline',
		'bbar:bar:istyping'		=> 'is typing',
		'bbar:bar:noneonline'		=> 'No friends online'
          );

          add_translation("en",$english);


?>
