<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   03/11/2015
 * Last update:     03/11/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
//$id = '19NW2yKFpEu7bO-anlYTpyKoykGebpB7EmvUg60ylHDs';
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
if($user_id = elgg_get_logged_in_user_guid()){
    $user = array_pop(ClipitUser::get_by_id(array($user_id)));
    if(isset($id_array[$user->role][get_current_language()])){
        $id = $id_array[$user->role][get_current_language()];
    }
}

if(!elgg_is_logged_in()){
    $student_id = $id_array["student"][get_current_language()];
    $teacher_id = $id_array["teacher"][get_current_language()];

    $content = '
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#student" aria-controls="home" role="tab" data-toggle="tab">'.elgg_echo('student').'</a></li>
        <li role="presentation"><a href="#teacher" aria-controls="profile" role="tab" data-toggle="tab">'.elgg_echo('teacher').'</a></li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="student">
            '.elgg_view('output/url', array(
                'href' => 'https://docs.google.com/feeds/download/documents/export/Export?id='.$student_id.'&exportFormat=pdf',
                'title' => elgg_echo('file:download'),
                'target' => '_blank',
                'text' => '<i class="fa fa-download"></i> '.elgg_echo('file:download'),
                'class' => 'btn btn-sm btn-primary'
            )).'
            <hr/>
            <div class="frame-container">
                <iframe src="https://docs.google.com/document/d/'.$student_id.'/pub?embedded=true" frameborder="0"></iframe>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="teacher">
            '.elgg_view('output/url', array(
                'href' => 'https://docs.google.com/feeds/download/documents/export/Export?id='.$teacher_id.'&exportFormat=pdf',
                'title' => elgg_echo('download'),
                'target' => '_blank',
                'text' => '<i class="fa fa-download"></i> '.elgg_echo('file:download'),
                'class' => 'margin-top-20 btn btn-sm btn-primary'
            )).'
            <hr/>
            <div class="frame-container">
                <iframe src="https://docs.google.com/document/d/'.$teacher_id.'/pub?embedded=true" frameborder="0"></iframe>
            </div>
        </div>
    </div>
    ';
} else { // User connected
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
        <iframe src="https://docs.google.com/document/d/'.$id.'/pub?embedded=true" frameborder="0"></iframe>
    </div>
    ';
}
$params = array(
    'content' => $content,
    'filter' => '',
    'title' => $title,
);
$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);