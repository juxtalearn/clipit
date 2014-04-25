<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 25/02/14
 * Time: 10:41
 * To change this template use File | Settings | File Templates.
 */
$entity = elgg_extract('entity', $vars);

$body = elgg_view("input/hidden", array(
    'name' => 'entity-id',
    'value' => $entity->id,
));
// Attachment simulator
$body .='<div class="form-group">
    <label for="discussion-title">'.elgg_echo("discussion:title_topic").'</label>
    '.elgg_view("input/text", array(
        'name' => 'discussion-title',
        'class' => 'form-control',
        'required' => true
    )).'
</div>
<div class="form-group">
    <label for="discussion-text">'.elgg_echo("discussion:text_topic").'</label>
    '.elgg_view("input/plaintext", array(
        'name' => 'discussion-text',
        'class' => 'form-control wysihtml5',
        'required' => true,
        'rows'  => 6,
    )).'
</div>';

$body .= '<div class="show" style="
    background: #ECF7FB;
    padding: 5px;
"><img src="http://www.ucci.urjc.es/wp-content/uploads/Juxtalearn-620x434.jpg" style="
    width: 150px;
    margin: 5px;
    height: 100px;
    display: inline-block;
"><img src="https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcTz_3Stt6EU0FOiFimoaAjKOteMcu-XW5VusMoXGTTmeE6JQQwHWw" style="
    width: 150px;
    margin: 5px;
    height: 100px;
    display: inline-block;
">
<div style="  display: inline-block; width: 100px; height: 100px; background: #fff; border-radius: 3px; margin: 5px; ">
<span class="fa-stack fa-lg" style="
    color: #1ba1d3;
    height: 100%;
    width: 100%;
">
  <i class="fa fa-file-o fa-stack-2x" style="
    font-size: 100px;
"></i>
  <b class="fa-stack-1x" style="
    height: 100%;
    top: 50%;
">Word</b>
</span>
</div>


</div>';


echo elgg_view("page/components/modal",
    array(
        "dialog_class"     => "modal-lg",
        "target"    => "create-new-topic",
        "title"     => elgg_echo("discussion:create"),
        "form"      => true,
        "body"      => $body,
        "cancel_button" => true,
        "ok_button" => elgg_view('input/submit',
            array(
                'value' => elgg_echo('create'),
                'class' => "btn btn-primary"
            ))
));