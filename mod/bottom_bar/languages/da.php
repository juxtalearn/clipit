<?php

        /**
         * Facebook-esque bottom bar
         *
         * @package bottom_bar
         * @author Jay Eames - Sitback
         * @link http://sitback.dyndns.org
         * @copyright (c) Jay Eames 2009
         * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 *
	 * @many thanks to slyhne for providing this translation files
         */

	  $danish = array(

	  // Admin settings

		'bottom_bar' => "Bundlinie",

		'bbar:admin:basicopts' 		=> 'Indstillinger',
		'bbar:admin:refreshrate'	=> 'Genopfrisknings interval<br>(l&aelig;ngere tid = mindre server belastning)',
		'bbar:admin:idlethreshold'	=> 'Bruger inaktivitets timeout',
		'bbar:admin:offlinethreshold'	=> 'Bruger offline timeout',
		'bbar:admin:allowchat'		=> 'Tillad chat?',
		'bbar:admin:forceloginpage'	=> 'Tving brugere til login-siden hvis de er logget ud?',
		'bbar:admin:allowmenu'		=> 'Aktiver ELGG menu ved logo?',
		'bbar:admin:allowradio'		=> 'Aktiver musik funktion?',
		'bbar:admin:allowsounds'        => 'Aktiver Chat anmeldelse lyde?',
		'bbar:admin:radiourl'		=> 'Stream URL til musik<br>(skal v&aelig;re en MP3, eller Icecast server)',
		'bbar:admin:logolocation'	=> 'Logo billede der skal bruges til i menulinjen til venstre:<br>(Efterlad blank for at bruge standard. Kan v&aelig;re jpg, gif eller png. Filen skal gemmes i /mod/bottom_bar/graphics/icons/)',

		'bbar:admin:dbopts'		=> 'Database indstillinger',
		'bbar:admin:dboptsdesc'		=> 'Denne plugin kan enten bruge SQLite database (hvilket burde være godt nok til op til mellemstore sites) eller bruge MySQL. Hvis du er usikker, s&aring; brug SQLite',
		'bbar:admin:dboptstype'		=> 'Database type',
		'bbar:admin:dbmysqlopts'	=> '<b>Mysql indstillinger</b> (ignorer hvis du valgte SQLite ovenfor)',
		'bbar:admin:dboptsuseelgg'	=> 'Brug ELGG indstillinger/database',
		'bbar:admin:dbmysqlsettings'	=> '<b>Mysql tilpassede indstillinger</b><br>(ignorer hvis du valgte SQLite ovenfor, eller valgte "yes" til at bruge ELGG database indstillinger)',
		'bbar:admin:dbmysqluser'	=> 'DB brugernavn<br>(Skal have create rettigheder)',
		'bbar:admin:dbmysqlpass'	=> 'DB kodeord',
		'bbar:admin:dbmysqldbase'	=> 'Database navn',
		'bbar:admin:dbmysqlprefix'	=> 'Tabel prefix',

		'bbar:admin:second'		=> 'sekund',
		'bbar:admin:seconds'		=> 'sekunder',
		'bbar:admin:minute'		=> 'minut',
		'bbar:admin:minutes'		=> 'minutter',

	  // User settings

		'bbar:user:enablechat'		=> 'Aktiver chat?',
		'bbar:user:enablesounds'	=> 'Aktiver lyde?',
		'bbar:user:enableicons'		=> 'Vis profilfoto i venneliste?',

	  // Bar language

		'bbar:bar:notifications'	=> 'Aktivitet',
		'bbar:bar:notify.all'		=> 'Alle',
		'bbar:bar:notify.mine'		=> 'Mine venner',
		'bbar:bar:friends'		=> 'Venner',
		'bbar:bar:online'		=> 'online',
		'bbar:bar:offline'		=> 'offline',
		'bbar:bar:istyping'		=> 'skriver',
		'bbar:bar:noneonline'		=> 'Ingen venner online'
          );

          add_translation("da",$danish);


?>
