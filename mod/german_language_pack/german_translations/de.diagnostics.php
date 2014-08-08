<?php
/**
 * Elgg diagnostics German language file
 *
 * (C) iionly 2012-2014
 * Dual licensed under the MIT or GPL Version 2 licenses
 *
 * https://github.com/iionly
 * Contact: iionly@gmx.de
 */

$german = array(
	'admin:administer_utilities:diagnostics' => 'Systemüberprüfung',
	'diagnostics' => 'Systemüberprüfung',
	'diagnostics:report' => 'Report',
	'diagnostics:description' => 'Der Report, der im folgenden erstellt werden kann, kann bei der Fehlersuche hilfreich sein. In manchen Fällen bitten die Entwickler von Elgg, dass er zu einem Bugreport beigefügt wird.',
	'diagnostics:header' => '========================================================================
Elgg-Diagnose-Report
Generiert %s von %s
========================================================================

',
	'diagnostics:report:basic' => '
Elgg-Release %s, Version %s

------------------------------------------------------------------------',
	'diagnostics:report:php' => '
PHP info:
%s
------------------------------------------------------------------------',
	'diagnostics:report:plugins' => '
Einzelheiten zu den installierten Plugins:

%s
------------------------------------------------------------------------',
	'diagnostics:report:md5' => '
Installierte Dateien und Prüfsummen:

%s
------------------------------------------------------------------------',
	'diagnostics:report:globals' => '
Globale Variablen:

%s
------------------------------------------------------------------------'
);

add_translation('de', $german);