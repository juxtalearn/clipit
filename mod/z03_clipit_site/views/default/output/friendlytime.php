<?php
/**
 * Friendly time
 * Translates an epoch time into a human-readable time.
 *
 * @uses string $vars['time'] Unix-style epoch timestamp
 */

$friendly_time = get_friendly_time($vars['time']);
$timestamp = (ucwords(strftime("%d %B %Y @ %H:%M", $vars['time'])));
echo "<abbr title=\"{$timestamp}\">{$friendly_time}</abbr>";