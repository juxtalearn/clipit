<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   16/12/2014
 * Last update:     16/12/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$text = null;
if($vars['text'] !== false){
    $text = elgg_echo('print');
}
echo elgg_view('output/url', array(
    'href'  => "javascript:;",
    'class' => 'btn-print btn btn-primary btn-xs btn-border-blue',
    'onclick' => 'window.print()',
    'title' => elgg_echo('print'),
    'text'  => '<i class="fa fa-print"></i> '.$text,
));