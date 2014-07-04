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
// if search form is activated
echo elgg_view("storyboards/search");

foreach($storyboards as $sb_id){
    $storyboard =  array_pop(ClipitStoryboard::get_by_id(array($sb_id)));
    $file =  array_pop(ClipitFile::get_by_id(array($storyboard->file)));
    $sb_url = "{$href}/view/{$storyboard->id}";

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
    if($storyboard->owner_id == elgg_get_logged_in_user_guid()){
        $options = array(
            'entity' => $storyboard,
            'edit' => array(
                "data-target" => "#edit-storyboard-{$storyboard->id}",
                "href" => elgg_get_site_url()."ajax/view/modal/multimedia/storyboard/edit?id={$storyboard->id}",
                "data-toggle" => "modal"
            ),
            'remove' => array("href" => "action/multimedia/storyboards/remove?id={$storyboard->id}"),
        );
        if($vars['actions']){
            $owner_options = elgg_view("page/components/options_list", $options);
            $select = '<input type="checkbox" name="check-file[]" value="'.$file->id.'" class="select-simple">';
        }
        // Remote modal, form content
        echo elgg_view("page/components/modal_remote", array('id'=> "edit-storyboard-{$storyboard->id}" ));
    }
    // Action buttons (Download|Publish)
    $buttons = '<div style="width: 35px;display: inline-block;float: right;text-align: center;margin-left:10px;">
                    '.elgg_view('output/url', array(
                        'href'  => "file/download/".$file->id,
                        'title' => $owner->name,
                        'class' => 'btn btn-default btn-icon',
                        'text'  => '<i class="fa fa-download"></i>'
                    )).'
                    <small class="show text-truncate smaller" title="'.formatFileSize($file->size).'" style="margin-top: 3px;">
                        '.formatFileSize($file->size).'
                    </small>
                    </div>';
    if($vars['publish']){
        $buttons .= elgg_view('output/url', array(
            'href'  => "{$href}/publish/{$storyboard->id}".($vars['task_id'] ? "?task_id=".$vars['task_id']: ""),
            'title' => elgg_echo('publish'),
            'style' => 'padding: 1px 5px;  background: #47a447;color: #fff;font-weight: bold;margin-left:10px;',
            'class' => 'btn-xs btn pull-right',
            'text'  => '<i class="fa fa-arrow-circle-up"></i> '.elgg_echo('publish')
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
    ), array('entity'  => $entity));
    // File options
    $list_options['options_values'] = array(
        ''          => '['.elgg_echo('options').']',
        'remove'      => elgg_echo('file:delete'),
    );
}

// set content
$content_list .= elgg_view("page/elements/list/options", array('options' => $list_options));
$content_list .= elgg_view("page/elements/list/table", array('rows' => $rows, 'class' => 'files-table'));

// File list
echo elgg_view_form("multimedia/files/set_options", array('body' => $content_list, 'class' => 'block-total'));
?>
