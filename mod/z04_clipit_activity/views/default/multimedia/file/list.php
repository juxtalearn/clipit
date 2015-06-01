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
$files = elgg_extract("files", $vars);
$entity = elgg_extract('entity', $vars);
$href = elgg_extract("href", $vars);
$user_id = elgg_get_logged_in_user_guid();
$user = array_pop(ClipitUser::get_by_id(array($user_id)));

// if search form is activated
echo elgg_view("files/search");

foreach($files as $file_id){
    $file =  array_pop(ClipitFile::get_by_id(array($file_id)));
    $file_url = "{$href}/view/{$file->id}". ($vars['task_id'] ? "?task_id=".$vars['task_id']: "");

    $select = '<input type="checkbox" name="check-file[]" value="'.$file->id.'" class="select-simple">';
    $file_icon = '
        <div class="multimedia-preview">
            '.elgg_view('output/url', array(
            'href'  => $file_url,
            'title' => $file->name,
            'text'  => elgg_view("multimedia/file/preview", array('file'  => $file)))).'
        </div>';

    // Owner options (edit/delete)
    $owner_options = "";
    if(($file->owner_id == $user_id || $user->role == ClipitUser::ROLE_TEACHER) && $vars['options'] !== false){
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
    // Owner options (edit/delete)
    $owner_options = "";
    $select = "";
    if ($vars['options'] !== false) {
        $owner_options = elgg_view("multimedia/owner_options", array(
            'entity' => $file,
            'type' => 'file',
            'modal' => false
        ));
        // Remote modal, form content
        echo elgg_view("page/components/modal_remote", array('id'=> "edit-file-{$file->id}" ));
        $select = '<input type="checkbox" '.(($file->owner_id == $user_id || $user->role == ClipitUser::ROLE_TEACHER)?'':'disabled').'
                    name="check-file[]" value="' . $file->id . '" class="select-simple">';
    }
    // Action buttons (Download|Publish)
    $buttons = '<div style="width: 35px;display: inline-block;float: right;text-align: center;margin-left:10px;">
                    '.elgg_view('output/url', array(
            'href'  => "file/download/".$file->id. ($vars['task_id'] ? "?task_id=".$vars['task_id']: ""),
            'title' => $owner->name,
            'class' => 'btn btn-default btn-icon',
            'text'  => '<i class="fa fa-download"></i>')).'
                    <small class="show text-truncate" title="'.formatFileSize($file->size).'" style="margin-top: 3px;">
                        '.formatFileSize($file->size).'
                    </small>
                    </div>';
    if($vars['task_id']){
        if(array_pop(ClipitFile::get_read_status($file_id, array($user_id)))) {
            $buttons .= '<div class="pull-right margin-right-5 margin-top-5">
                        <i class="fa fa-eye blue" style="font-size: 16px;"></i>
                    </div>';
        }
    }

    $row = array(
        array(
            'class' => $vars['create'] ? 'select' : 'hide',
            'content' => $select
        ),
        array(
            'class' => 'text-center',
            'content' => $file_icon
        ),
        array(
            'class' => 'col-md-9 file-info',
            'content' => elgg_view("multimedia/file/title_summary", array('entity' => $file, 'href' => $file_url))
        ),
        array(
            'class' => 'col-md-3',
            'style' => 'vertical-align: middle;',
            'content' => $buttons.$owner_options
        )
    );
    $rows[] = array('content' => $row);
}
$list_options = array();
if($vars['create']){
    // Add files button
    echo elgg_view_form('multimedia/files/upload', array('id' => 'fileupload', 'enctype' => 'multipart/form-data'), array('entity'  => $entity));
    // File options
    if(!empty($files)) {
        $list_options['options_values'] = array(
            '' => elgg_echo('bulk_actions'),
            'remove' => elgg_echo('file:delete'),
        );
    }
}

// set content
$content_list .= elgg_view("page/elements/list/options", array('options' => $list_options));
$content_list .= elgg_view("page/elements/list/table", array('rows' => $rows, 'class' => 'files-table'));

// File list
echo elgg_view_form("multimedia/files/set_options", array('body' => $content_list, 'class' => 'block-total'));
?>