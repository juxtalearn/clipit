<?php
/**
 * Elgg page header
 * In the default theme, the header lives between the topbar and main content area.
 */



// link back to main site.
echo elgg_view('page/elements/header_logo', $vars);

if (elgg_is_logged_in()) {
    // insert site-wide navigation
    echo elgg_view_menu('site');
}

