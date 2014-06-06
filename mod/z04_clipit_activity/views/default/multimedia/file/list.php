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
$add_files = elgg_extract("add_files", $vars);
$task_id = ClipitTask::create(array(
    'name' => 'Upload video',
    'type' => '',
    'deadline' => time()
));
ClipitActivity::add_tasks(74, array($task_id));
foreach($files as $file_id){
    $file =  array_pop(ClipitFile::get_by_id(array($file_id)));
    $file_url = "{$href}/view/{$file->id}";

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
    if($file->owner_id == elgg_get_logged_in_user_guid()){
        $options = array(
            'entity' => $file,
            'edit' => array(
                "data-target" => "#edit-file-{$file->id}",
                "href" => elgg_get_site_url()."ajax/view/modal/multimedia/file/edit?id={$file->id}",
                "data-toggle" => "modal"
            ),
            'remove' => array("href" => "action/multimedia/files/remove?id={$file->id}"),
        );

        $owner_options = elgg_view("page/components/options_list", $options);
        // Remote modal, form content
        echo elgg_view("page/components/modal_remote", array('id'=> "edit-file-{$file->id}" ));
    }
    // Action buttons (Download|Publish)
    $buttons = '<div style="width: 35px;display: inline-block;float: right;text-align: center;margin-left:10px;">
                    '.elgg_view('output/url', array(
                        'href'  => "{$href}/download/".$file->id,
                        'title' => $owner->name,
                        'class' => 'btn btn-default btn-icon',
                        'text'  => '<i class="fa fa-download"></i>')).'
                    <small class="show text-truncate" title="'.formatFileSize($file->size).'" style="margin-top: 3px;">
                        '.formatFileSize($file->size).'
                    </small>
                    </div>';

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
            'content' => elgg_view("multimedia/file/summary", array('entity' => $file, 'href' => $file_url))
        ),
        array(
            'class' => 'col-md-3',
            'style' => 'vertical-align: middle;',
            'content' => $buttons.$owner_options
        )
    );
    $rows[] = array('content' => $row);
}

$list_options = array(
    'search'    => true
);

if($add_files){
    // Add files button
    echo elgg_view_form('multimedia/files/upload', array('id' => 'fileupload', 'enctype' => 'multipart/form-data'), array('entity'  => $entity));
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
echo elgg_view_form("multimedia/files/set_options", array('body' => $content_list));
?>
<style>
.labelx:after{
    content: " ";
    display: inline-block;
    width: 0;
    height: 0;
    margin-left: 2px;
    vertical-align: middle;
    border-top: 4px solid;
    border-right: 4px solid #32b4e5;
    border-left: 4px solid #32b4e5;
}
</style>