<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity = elgg_extract('entity', $vars);

$body .= elgg_view("input/hidden", array(
    'name' => 'entity-id',
    'value' => $entity->id,
));
$body .= '<div class="col-md-12">';
$body .= '
<div class="pull-left video-prev" style="
    margin-right: 10px;
    width: 250px;
    height: 140px;
    display: table;
    background: #bae6f6;
">
  <i class="fa fa-play" style="
    color: #fff;
    display: table-cell;
    text-align: center;     vertical-align: middle;
    font-size: 60px;
    opacity: 1;
"></i>
<a target="_blank">
<img id="video-prev" src="http://b.vimeocdn.com/ts/450/621/450621782_640.jpg" style="
    width: 250px;
    display: none;
">
</a>
</div>';
$body .='<div style="overflow: hidden">';
$body .= '<div class="form-group">
    <label for="link-url">'.elgg_echo("multimedia:links:add").'</label>
    <div style="position:relative;">
      <span style="position: absolute;top: 7px;left: 5px;">
        <a class="loading" style="display:none;"><i style="width:16px;height:16px;" class="fa fa-spinner fa-spin"></i></a>
        <img id="link-favicon" src="http://www.google.com/s2/favicons?domain=">
      </span>
     '.elgg_view("input/text", array(
        'name' => 'video-url',
        'id' => 'video-url',
        'style' => 'padding-left: 25px;',
        'class' => 'form-control blue',
        'required' => true
    )).'
    </div>
</div>';
// Input group set hidden by default
$body .= '<div id="group-hide" style="display: none">';

$body .= '<div class="form-group">
    <label for="link-title">'.elgg_echo("multimedia:links:title").'</label>
    '.elgg_view("input/text", array(
        'name' => 'video-title',
        'id' => 'video-title',
        'class' => 'form-control',
        'required' => true
    )).'
</div>';
$body .= '<div class="form-group">
    '.elgg_view("input/plaintext", array(
        'name' => 'video-description',
        'class' => 'form-control mceEditor',
        'id' => 'video-description',
        'rows'  => 3,
        'placeholder' => 'Set description...',
        'style' => "width: 100%;"
    )).'
</div>';

$body .='</div>';
$body .='</div>';

echo elgg_view("page/components/modal",
    array(
        "dialog_class"     => "modal-lg",
        "target"    => "add-video",
        "title"     => elgg_echo("video:add"),
        "form"      => true,
        "body"      => $body,
        "cancel_button" => true,
        "ok_button" => elgg_view('input/submit',
            array(
                'value' => elgg_echo('add'),
                'class' => "btn btn-primary"
            ))
    ));
