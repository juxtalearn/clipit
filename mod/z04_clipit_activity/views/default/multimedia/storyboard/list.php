<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   16/05/14
 * Last update:     16/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$storyboards = elgg_extract("entities", $vars);
$entity = elgg_extract('entity', $vars);
$href = elgg_extract("href", $vars);
$user_id = elgg_get_logged_in_user_guid();
$user = array_pop(ClipitUser::get_by_id(array($user_id)));

// if search form is activated
echo elgg_view("storyboards/search");

foreach($storyboards as $sb_id){
    $storyboard =  array_pop(ClipitStoryboard::get_by_id(array($sb_id)));
    $file =  array_pop(ClipitFile::get_by_id(array($storyboard->file)));
    $sb_url = "{$href}/view/{$storyboard->id}". ($vars['task_id'] ? "?task_id=".$vars['task_id']: "");

    $file_icon = '
        <div class="multimedia-preview">
            '.elgg_view('output/url', array(
            'href'  => $sb_url,
            'title' => $storyboard->name,
            'text'  => elgg_view("multimedia/file/preview", array('file'  => $file)))).'
        </div>';

    // Owner options (edit/delete)
    $owner_options = "";
    $select = "";
    if ($vars['actions']) {
        $owner_options = elgg_view("multimedia/owner_options", array(
            'entity' => $storyboard,
            'type' => 'storyboard',
            'modal' => false
        ));
        // Remote modal, form content
        echo elgg_view("page/components/modal_remote", array('id'=> "edit-storyboard-{$storyboard->id}" ));
        $select = '<input type="checkbox" '.(($storyboard->owner_id == $user_id || $user->role == ClipitUser::ROLE_TEACHER)?'':'disabled').'
                    name="check-file[]" value="' . $storyboard->id . '" class="select-simple">';
    }


    // Action buttons (Download|Publish)
    $buttons = '<div style="width: 35px;display: inline-block;float: right;text-align: center;margin-left:10px;">
                    '.elgg_view('output/url', array(
                        'href'  => "file/download/".
                            $file->id. ($vars['task_id'] ? "?task_id=".$vars['task_id']."&storyboard=".$storyboard->id: ""),
                        'title' => $owner->name,
                        'class' => 'btn btn-default btn-icon',
                        'text'  => '<i class="fa fa-download"></i>'
                )).'
                <small class="show text-truncate smaller" title="'.formatFileSize($file->size).'" style="margin-top: 3px;">
                    '.formatFileSize($file->size).'
                </small>
                </div>';
    if($vars['task_id'] && !$vars['publish']){
        if(array_pop(ClipitStoryboard::get_read_status($storyboard->id, array($user_id)))) {
            $buttons .= '<div class="pull-right margin-right-5 margin-top-5">
                        <i class="fa fa-eye blue" style="font-size: 16px;"></i>
                    </div>';
        }
    }
    if($vars['publish']){
        $buttons = elgg_view('output/url', array(
            'href'  => "{$href}/publish/{$storyboard->id}".($vars['task_id'] ? "?task_id=".$vars['task_id']: ""),
            'title' => elgg_echo('review'),
            'style' => 'background: #47a447;color: #fff;font-weight: bold;margin-left:10px;',
            'class' => 'btn-sm btn pull-right btn-primary',
            'text'  => elgg_view('page/components/tooltip', array('text' => elgg_echo('publications:select:tooltip')))
                .elgg_echo('select').'...'
        ));

    }

    $row = array(
        array(
            'class' => 'select',
            'content' => $select
        ),
        array(
            'class' => 'text-center',
            'content' => $file_icon
        ),
        array(
            'class' => 'col-md-9 file-info',
            'content' => elgg_view("multimedia/storyboard/summary", array(
                'entity' => $storyboard,
                'file' => $file,
                'href' => $sb_url
            ))
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
    echo elgg_view_form('multimedia/storyboards/upload', array(
        'id' => 'fileupload',
        'enctype' => 'multipart/form-data',
    ), array('entity'  => $entity, 'create_form' => $vars['create_form']));
    if(!empty($storyboards)) {
        // File options
        $list_options['options_values'] = array(
            '' => '[' . elgg_echo('options') . ']',
            'remove' => elgg_echo('file:delete'),
        );
    }
}

// set content
$content_list .= elgg_view("page/elements/list/options", array('options' => $list_options));
$content_list .= elgg_view("page/elements/list/table", array('rows' => $rows, 'class' => 'files-table'));

// File list
echo elgg_view_form("multimedia/storyboards/set_options", array('body' => $content_list, 'class' => 'block-total'));
?>
