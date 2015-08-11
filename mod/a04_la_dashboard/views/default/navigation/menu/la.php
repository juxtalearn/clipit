<?php
/**
 * Created by PhpStorm.
 * User: malzahn
 * Date: 28.05.2015
 * Time: 15:16
 */
if ( elgg_in_context('la_metrics')) {
    echo '<li class="active">';
} else {

 echo '<li>';}
echo elgg_view('output/url', array(
    'href'  => "stats",
    'title' => elgg_echo('dashboard'),
    'text'  => elgg_echo('dashboard')
));
?>
</li>
<li class="separator">|</li>