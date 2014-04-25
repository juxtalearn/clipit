<?php
$plugin = elgg_get_plugin_from_id('clipit_theme');


$form.= "<p><label>Mensaje principal</label>";
$form.= elgg_view('input/text',
    array(
        'name' => "params[main_message]",
        'value' => $plugin->main_message,
    )
);
$form.= '</p>';
$form.= "<p><label>Texto secundario</label>";
$form.= elgg_view('input/plaintext',
    array(
        'name' => "params[second_message]",
        'value' => $plugin->second_message,
    )
);
$form.= '</p>';
$form.= "<label>Logotipo</label>";
$form.= '
<div style="float:right;margin:0px;">
    <label style="color: #CCC;display: block;margin-top: -5px;text-align:right;">Logotipo</label>
    <img src="'.$CONFIG->wwwroot."mod/clipit_theme/graphics/icons/".$plugin->logo_img.'" style="max-height:50px;max-width:340px;">
</div>
';
$form.= "<p>";
$form.= elgg_view('input/file',
    array(
        'name' => "logo_img",
    )
);
$form.= '</p>';
$form.= '
<label>Imagen de fondo (subir imagen con desenfoque)</label>
<a style="float: right;width: 340px;height: 70px;overflow: hidden;position: relative;">
    <label style="display: block;position: absolute;padding: 5px;right: 0;color: #FFF;">Imagen de fondo</label>
    <img src="'.$CONFIG->wwwroot."mod/clipit_theme/graphics/icons/".$plugin->bg_img.'" style="max-width: 100%;min-height: 100%;">
</a>
';
$form.= "<p>";
$form.= elgg_view('input/file',
    array(
        'name' => "bg_img",
    )
);
$form.= '</p><br>';

$form.= '<div style="overflow:hidden">';
$form.= '<div style="float:left;width:45%">';
$form.= "<h2>Redes sociales</h2><hr>";
$form.= '<p style="overflow: hidden;">';
$form.= "<label style='max-width: 85px;float: left;'>Facebook</label>";
$form.= elgg_view('input/text',
    array(
        'name' => "params[account_facebook]",
        'style' => "margin-left:5px;width: 70%;float:right;",
        'value' => $plugin->account_facebook,
    )
);
$form.= '</p>';
$form.= '<p style="overflow: hidden;">';
$form.= "<label style='max-width: 85px;float: left;'>Twitter</label>";
$form.= elgg_view('input/text',
    array(
        'name' => "params[account_twitter]",
        'style' => "margin-left:5px;width: 70%;float:right;",
        'value' => $plugin->account_twitter,
    )
);
$form.= '</p>';
$form.= '<p style="overflow: hidden;">';
$form.= "<label style='max-width: 85px;float: left;'>Youtube</label>";
$form.= elgg_view('input/text',
    array(
        'name' => "params[account_youtube]",
        'style' => "margin-left:5px;width: 70%;float:right;",
        'value' => $plugin->account_youtube,
    )
);
$form.= '</p>';
$form.= '<p style="overflow: hidden;">';
$form.= "<label style='max-width: 85px;float: left;'>Vimeo</label>";
$form.= elgg_view('input/text',
    array(
        'name' => "params[account_vimeo]",
        'style' => "margin-left:5px;width: 70%;float:right;",
        'value' => $plugin->account_vimeo,
    )
);
$form.= '</p>';
$form.= '<p style="overflow: hidden;">';
$form.= "<label style='max-width: 85px;float: left;'>LinkedIn</label>";
$form.= elgg_view('input/text',
    array(
        'name' => "params[account_linkedin]",
        'style' => "margin-left:5px;width: 70%;float:right;",
        'value' => $plugin->account_linkedin,
    )
);
$form.= '</p>';
$form.= '</div>';

$form.= '<div style="float:right;width:45%">';
$form.= "<h2>Contacto</h2><hr>";
$form.= '<p style="overflow: hidden;">';
$form.= "<label style='max-width: 85px;float: left;'>Correo electrónico</label>";
$form.= elgg_view('input/text',
    array(
        'name' => "params[email_contact]",
        'style' => "margin-left:5px;width: 70%;float:right;",
        'value' => $plugin->email_contact,
    )
);
$form.= '</p>';
$form.= '</div>';
$form.= '</div>';
$form .= "<br>" . elgg_view('input/submit', array('value' => elgg_echo("save")));

$action = $vars['url'] . 'action/clipit_theme/settings';

echo elgg_view('input/form', array('action' => $action, 'body' => $form, 'enctype' => 'multipart/form-data'));