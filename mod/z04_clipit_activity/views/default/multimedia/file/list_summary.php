<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   9/05/14
 * Last update:     9/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$files = elgg_extract("entities", $vars);
$files = ClipitFile::get_by_id($files);
$entity = elgg_extract('entity', $vars);
$href = elgg_extract("href", $vars);
$user_id = elgg_get_logged_in_user_guid();
$user = array_pop(ClipitUser::get_by_id(array($user_id)));

// if search form is activated
echo elgg_view("files/search");

foreach($files as $file){
    $file_url = "{$href}/view/{$file->id}". ($vars['task_id'] ? "?task_id=".$vars['task_id']: "");
    $owner = array_pop(ClipitUser::get_by_id(array($file->owner_id)));
    $select = '<input type="checkbox" name="check-file[]" value="'.$file->id.'" class="select-simple">';
    $file_icon_preview = elgg_view("multimedia/file/preview", array('file'  => $file));
    $file_icon = elgg_view('output/url', array(
                'href'  => $file_url,
                'title' => $file->name,
                'text'  => $file_icon_preview
            ));

    // Owner options (edit/delete)
    $owner_options = "";
    if(($file->owner_id == $user_id || hasTeacherAccess($user->role)) && $vars['options'] !== false){
        $options = array(
            'entity' => $file,
            'edit' => array(
                "data-target" => "#edit-file-{$file->id}",
                "href" => elgg_get_site_url()."ajax/view/modal/multimedia/file/edit?id={$file->id}",
                "data-toggle" => "modal"
            )
        );
        if($file->owner_id == $user_id){
            $options['remove'] = array("href" => "action/multimedia/files/remove?id={$file->id}");
        }
        $owner_options = elgg_view("page/components/options_list", $options);
        // Remote modal, form content
        echo elgg_view("page/components/modal_remote", array('id'=> "edit-file-{$file->id}" ));
    }
    // Action buttons (Download|Publish)
    $buttons = elgg_view('output/url', array(
                    'href'  => "file/download/".$file->id. ($vars['task_id'] ? "?task_id=".$vars['task_id']: ""),
                    'class' => 'btn btn-default btn-icon margin-left-10 pull-right',
                    'text'  => '<i class="fa fa-download"></i>'
    ));
    $author = elgg_view("publications/owner_summary", array(
        'entity' => $file,
        'entity_class' => 'ClipitFile',
        'msg' => elgg_echo('multimedia:uploaded_by')
    ));
    $file_link_text = '<strong>'.$file->name.'</strong>';
    $file_link = elgg_view('output/url', array(
        'href'  => $file_url,
        'title' => $file->name,
        'text'  => $file_link_text
    ));
    if($vars['preview'] !== false) {
        echo elgg_view("page/components/modal_remote", array('id' => "viewer-id-{$file->id}"));
        $href_viewer = "ajax/view/multimedia/viewer?id=" . $file->id;
        $file_link = elgg_view('output/url', array(
            'href'  => $href_viewer,
            'title' => $file->name,
            'data-target' => '#viewer-id-'.$file->id,
            'data-toggle' => 'modal',
            'text'  => $file_link_text
        ));
        $file_icon = elgg_view('output/url', array(
            'href'  => $href_viewer,
            'title' => $file->name,
            'data-target' => '#viewer-id-'.$file->id,
            'data-toggle' => 'modal',
            'text'  => $file_icon_preview
        ));
    }
    $row = array(
        array(
            'class' => $vars['create'] ? 'select' : 'hide',
            'content' => $select
        ),
        array(
            'class' => 'text-center',
            'content' => '<div class="multimedia-preview">'.$file_icon.'</div>'
        ),
        array(
            'class' => 'file-info',
            'content' => $file_link
        ),
        array(
            'content' => elgg_view('tricky_topic/tags/view', array(
                            'tags' => ClipitFile::get_tags($file->id), 'limit' => 2, 'width' => 100)
                        )
        ),
        array(
            'content' => '<small>'.
                        $author.
                        '<div class="margin-top-5">'
                            .elgg_view('output/friendlytime', array('time' => $file->time_created)).
                        '</div>'
                        .'</small>',
        ),
        array(
            'style' => 'vertical-align: middle;',
            'content' => $buttons.$owner_options
        ),
        array(
            'content' => formatFileSize($file->size)
        )
    );
    $rows[] = array('content' => $row);
}
$list_options = array();
if($vars['create']){
    // Add files button
    echo elgg_view_form('multimedia/files/upload', array(
        'action' => 'action/multimedia/files/save',
        'id' => 'fileupload',
        'enctype' => 'multipart/form-data',
        'data-validate' => 'true'
    ), array('entity'  => $entity));
    // File options
    $list_options['options_values'] = array(
        ''          => elgg_echo('bulk_actions'),
        'remove'      => elgg_echo('file:delete'),
    );
}

// set content
$content_list .= elgg_view("page/elements/list/options", array('options' => $list_options));
$content_list .= elgg_view("page/elements/list/table", array('rows' => $rows, 'class' => 'files-table'));

// File list
echo elgg_view_form("multimedia/files/set_options", array('body' => $content_list, 'class' => 'block-total'));
?>