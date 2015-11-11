<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   26/06/2015
 * Last update:     26/06/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
// Save quiz
$body = '<p>'.elgg_echo("quiz:result:send").'</p>';
$body .= '<div class="clearfix"></div>';
$body .= elgg_view('input/submit',
    array(
        'value' => elgg_echo('input:ok'),
        'data-type' => 'save',
        'class' => "btn btn-primary btn-sm pull-right margin-bottom-10 finish-quiz"
    ));
$body .= '<div class="clearfix"></div>';
// Set finish quiz
$body .= '<div class="bg-info margin-top-10">';
$body .= '<p>'.elgg_echo("quiz:result:finish").'</p>';
$body .= elgg_view('input/submit',
    array(
        'value' => elgg_echo('finish'),
        'data-type' => 'finish',
        'class' => "btn btn-primary btn-sm pull-right btn-border-blue finish-quiz"
    ));
$body .= '
    <div class="clearfix"></div>
</div>';

echo elgg_view("page/components/modal",
    array(
        "dialog_class"     => "modal-md",
        "target"    => "save-quiz",
        "title"     => '',
        "form"      => true,
        "body"      => $body,
        "footer" => false
    ));