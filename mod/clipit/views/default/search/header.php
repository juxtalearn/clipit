<?php
/**
 * Search box in page header
 */

if (elgg_is_logged_in()) {
    echo elgg_view('search/search_box', array('class' => 'elgg-search-header'));
}