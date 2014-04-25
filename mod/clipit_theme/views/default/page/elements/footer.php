<?php
/**
 * Elgg footer
 * The standard HTML footer that displays across the site
 *
 * @package Elgg
 * @subpackage Core
 *
 */

echo'
<div class="col-sm-2 col-xs-4">
    <div class="contact">
        <h2>Hola!</h2>
        <img src="'.$CONFIG->wwwroot.'mod/clipit_theme/graphics/mail.png">
    </div>
</div>
';

echo elgg_view_menu('footer_clipit', array('sort_by' => 'priority', 'class' => 'pull-right site-map col-sm-9 col-xs-12 col-md-7 col-lg-6'));