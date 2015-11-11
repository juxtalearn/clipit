<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   03/11/2015
 * Last update:     03/11/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$id_array = array(
    'student' => array(
        'es' => '19NW2yKFpEu7bO-anlYTpyKoykGebpB7EmvUg60ylHDs',
        'en' => '1YB0SvpWbOWnwiGyJVjiSh_AFpIjrcIu7lMeQg3wlUOo',
    ),
    'teacher' => array(
        'es' => '1NR5B1342sOGYp3ZwRklmTvp7cGuoXxTcbFjOFhtXfuQ',
        'en' => '1zXoxdlpQJQcoCGxNSBeuLi1dcBQ7hTTPKsxMJ7vXsO0',
    ),
    'admin' => array(
        'es' => '1hGVxw4Z4-T4fDYTODmbMA_CkB71tmTV3qfEaIhpMYoc',
        'en' => '1e12ZagArU8H_2Hsttp_q_CHReouEkqUxqURVnukRo30',
    ),
);

if($id = $id_array[$page[1]][get_current_language()]){
    $content = elgg_view('output/url', array(
        'href' => 'https://docs.google.com/feeds/download/documents/export/Export?id='.$id.'&exportFormat=pdf',
        'title' => elgg_echo('download'),
        'target' => '_blank',
        'text' => '<i class="fa fa-download"></i> '.elgg_echo('file:download'),
        'class' => 'btn btn-sm btn-primary'
    ));
    $content .= '
    <hr/>
    <div class="frame-container">
        <iframe src="https://docs.google.com/document/d/'.$id.'/pub?embedded=false" frameborder="0"></iframe>
    </div>
    ';
} else{
    return false;
}

$params = array(
    'content' => $content,
    'filter' => '',
    'title' => $title,
);
$body = elgg_view_layout('one_column', $params);

echo elgg_view_page($title, $body);