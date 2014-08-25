<?php
/**
 * Die Hauptsprachdatei ist im Verzeichnis /languages/en.php und jedes Plugin hat seine
 * Sprachdatei in einem eigenen languages-Verzeichnis. Um einen Sprach-String zu ändern, kopiere die
 * entsprechende Zeile in diese Datei.
 *
 * Um beispielsweise den Menueintrag "Blog"
 * von "Blog" zu "Schimpftiraden" zu ändern, kopiere dieses Paar:
 *                      'blog' => "Blog",
 * in das $mapping-Array und ändere es wie folgt:
 *                      'blog' => "Schimpftiraden",
 *
 * Mache das gleiche für alle anderen Strings, die Du ändern möchtest. Stelle sicher, dass das Plugin,
 * das die Sprachdatei mit Deinen Änderungen enthält in der Pluginliste tiefer angeordnet ist als
 * alle Plugins, deren Sprach-Strings Du modifizieren möchtest.
 *
 * Wenn Du andere Sprachen außer Englisch hinzufügen möchtest, benenne die Datei entsprechend dem
 * ISO 639-1 Länderkürzel: http://en.wikipedia.org/wiki/List_of_ISO_639-1_codes
 *
 * (C) iionly 2012-2014
 * Dual licensed under the MIT or GPL Version 2 licenses
 *
 * https://github.com/iionly
 * Contact: iionly@gmx.de
 */

$mapping = array(
        'string:here' => 'Auf der Seite anzuzeigender String hier eingeben.'
);

add_translation('de', $mapping);