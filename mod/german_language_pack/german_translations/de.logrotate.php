<?php
/**
 * Logrotate German language file
 *
 * (C) iionly 2012-2014
 * Dual licensed under the MIT or GPL Version 2 licenses
 *
 * https://github.com/iionly
 * Contact: iionly@gmx.de
 */

$german = array(
	'logrotate:period' => 'Wie oft sollen die Einträge im Systemlog archiviert werden?',

	'logrotate:logrotated' => "Die alten Einträge im Log wurden archiviert.\n",
	'logrotate:lognotrotated' => "Beim Archivieren der alten Einträge im Log ist ein Fehler aufgetreten.\n",

	'logrotate:delete' => 'Löschen von archivierten Logs älter als',

	'logrotate:week' => 'eine Woche',
	'logrotate:month' => 'einen Monat',
	'logrotate:year' => 'ein Jahr',
	'logrotate:never' => 'nie',

	'logrotate:logdeleted' => "Das Log wurde gelöscht.\n",
	'logrotate:lognotdeleted' => "Es wurden keine Logs gelöscht.\n"
);

add_translation('de', $german);