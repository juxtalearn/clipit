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
$files_id = elgg_extract('files', $vars);
$href = elgg_extract("href", $vars);
?>

<div class="block" style="margin-bottom: 10px;">
    <?php echo elgg_view_form('multimedia/files/upload', array('data-validate'=> "true", 'enctype' => 'multipart/form-data'), array('entity'  => $entity)); ?>
</div>

<script src="http://blueimp.github.io/jQuery-File-Upload/js/vendor/jquery.ui.widget.js"></script>
<script src="http://blueimp.github.io/JavaScript-Load-Image/js/load-image.min.js"></script>
<script src="http://blueimp.github.io/jQuery-File-Upload/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="http://blueimp.github.io/jQuery-File-Upload/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="http://blueimp.github.io/jQuery-File-Upload/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="http://blueimp.github.io/jQuery-File-Upload/js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="http://blueimp.github.io/jQuery-File-Upload/js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="http://blueimp.github.io/jQuery-File-Upload/js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="http://blueimp.github.io/jQuery-File-Upload/js/jquery.fileupload-validate.js"></script>
<script>
    function formatFileSize(bytes) {
        if (typeof bytes !== 'number') {
            return '';
        }
        if (bytes >= 1000000000) {
            return (bytes / 1000000000).toFixed(2) + ' GB';
        }
        if (bytes >= 1000000) {
            return (bytes / 1000000).toFixed(2) + ' MB';
        }
        return (bytes / 1000).toFixed(2) + ' KB';
    }
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = "<?php echo elgg_add_action_tokens_to_url(elgg_normalize_url(elgg_get_site_url()."action/multimedia/files/upload"), true);?>",
            uploadButton = $('<button/>')
                .addClass('btn btn-primary')
                .text('Upload')
                .on('click', function () {
                    var $this = $(this),
                        data = $this.data();
                    $this
                        .off('click')
                        .text('Abort')
                        .on('click', function () {
                            $this.remove();
                            data.abort();
                        });
                    data.submit().always(function () {
                        $this.remove();
                    });
                });
        $(document).on("change", "#uploadfiles",function(){
            $("#add-file .modal-body").html("");
        });
        $('#uploadfiles').fileupload({
            url: url,
            dataType: 'json',
            autoUpload: false,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png|wmv|mp4)$/i,
            maxFileSize: 500000000, // 500 MB
            // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            disableImageResize: /Android(?!.*Chrome)|Opera/
                .test(window.navigator.userAgent),
            previewMaxWidth: 100,
            previewMaxHeight: 100,
            previewCrop: true
        }).on('fileuploadadd', function (e, data) {
            $('#add-file').modal('show');
            data.context = $('<div class="files-upload-list"/>').appendTo("#add-file .modal-body");
            $("#add-file .modal-footer").prepend(uploadButton.data(data));

        }).on('fileuploadprocessalways', function (e, data) {
            var index = data.index,
                file = data.files[index];
//                node = $($(".upload-file-info").children()[index]);
//                node.find(".size").text(formatFileSize(file.size));

            console.log(formatFileSize(file.size));
//            node = node.find('.file');
//            node.remove();

            var node_row = $(<?php echo elgg_view("multimedia/file_upload");?>);
            node_row.appendTo("#add-file .modal-body");
            var node = node_row.find(".file-info");
            var node_file_info = $('<div class="text-truncate"/>')
                .append($('<small class="size pull-right"/>').text(formatFileSize(file.size)))
                .append($('<div class="text-truncate"/>').text(file.name));
            var progress = $('<div id="progress" class="progress"><div class="progress-bar progress-bar-success"></div></div>');

            node_file_info.appendTo(node);
            progress.appendTo(node);

            if (file.preview) {
                node.find(".no-file").remove();
                $(file.preview).prependTo(node).wrap("<div class='img-prev'><div></div></div>");
            }
            if (file.error) {
                node
                    .append('<br>')
                    .append($('<span class="text-danger"/>').text(file.error));
            }
            if (index + 1 === data.files.length) {
                data.context.find('button')
                    .text('Upload')
                    .prop('disabled', !!data.files.error);
            }
        }).on('fileuploadprogressall', function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }).on('fileuploaddone', function (e, data) {
            $.each(data.result.files, function (index, file) {
                if (file.url) {
                    var link = $('<a>')
                        .attr('target', '_blank')
                        .prop('href', file.url);
                    $(data.context.children()[index])
                        .wrap(link);
                } else if (file.error) {
                    var error = $('<span class="text-danger"/>').text(file.error);
                    $(data.context.children()[index])
                        .append('<br>')
                        .append(error);
                }
            });
        }).on('fileuploadfail', function (e, data) {
            $.each(data.files, function (index, file) {
                var error = $('<span class="text-danger"/>').text('File upload failed.');
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            });
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });
</script>
<style>
    .table td{
        border-bottom: 1px solid #bae6f6;
        border-top: 0 !important;
    }
    input[type=file]#uploadfiles {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        -ms-filter: 'alpha(opacity=0)';
        direction: ltr;
        cursor: pointer;
    }
    .file-info > .img-prev{
        background: #f1f2f7;
        display: table;
        width: 100%;
        height: 100%;
        padding: 10px;
    }
    .file-info > .img-prev > div{
        display: table-cell;
        vertical-align: middle;
        text-align: center;
    }
</style>
<?php
// MODAL SIMULATE
for($i=0; $i<3; $i++){
$body .='
<div class="row">
<div class="col-md-3">
    <div class="no-file" style="background: #f1f2f7;display:table;width:100%;height: 150px;">
        <div style="display:table-cell;vertical-align:middle;text-align:center;">
           <h2 style="text-transform: uppercase;color: #999;">'.elgg_echo("file:nofile").'</h2>
        </div>
    </div>
    <div class="upload-files-list" style="float: left; width: 100%;"></div>
</div>
<div class="col-md-8">
    <div class="form-group">
        <label for="file-name">'.elgg_echo("multimedia:links:add").'</label>
    '.elgg_view("input/text", array(
            'name' => 'file-name[]',
            'id' => 'file-name',
            'style' => 'padding-left: 25px;',
            'class' => 'form-control blue',
            'required' => true
        )).'
    </div>
    <div class="form-group">
        '.elgg_view("input/plaintext", array(
            'name' => 'file-text[]',
            'class' => 'form-control mceEditor',
            'required' => true,
            'rows'  => 3,
        )).'
    </div>
</div>
</div>';
}
$body = "";
echo elgg_view("page/components/modal",
    array(
        "dialog_class"     => "modal-lg add-files-list",
        "target"    => "add-file",
        "title"     => elgg_echo("multimedia:files:add"),
        "form"      => true,
        "body"      => $body,
        "cancel_button" => true,
        "ok_button" => elgg_view('input/submit',
            array(
                'value' => elgg_echo('add'),
                'class' => "btn btn-primary"
            ))
    ));
// MODAL SIMULATE
?>


<div style="margin-bottom: 30px;color: #999;margin-left: 10px;">
    <div class="checkbox" style=" display: inline-block;margin: 0;">
        <label>
            <input type="checkbox" class="select-all"> Select all
        </label>
    </div>
    <div style=" display: inline-block; margin-left: 10px; ">
        <select name="set-option" class="form-control message-options" style="height: 20px;padding: 0;" disabled="">
            <option>[Options]</option>
            <option value="read">Download</option>
            <option value="unread">Publish</option>
        </select>
    </div>
    <div class="pull-right search-box">
        <input type="text" placeholder="Search">
        <div class="input-group-btn">
            <span></span>
            <button type="submit">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </div>
</div>
<table class="table files-table">
<tbody>
<?php
foreach($files_id as $file_id):
    $file = array_pop(ClipitFile::get_by_id(array($file_id)));
    $owner = array_pop(ClipitUser::get_by_id(array($file->owner_id)));
?>
<tr>
    <td>
        <input type="checkbox">
    </td>
    <td>
        <i class="fa fa-file-o file-icon"></i>
    </td>
    <td class="col-md-9 file-info">
        <h4>
            <?php echo elgg_view('output/url', array(
                'href'  => "{$href}/view/".$file->id,
                'title' => $file->name,
                'text'  => $file->name));
            ?>
        </h4>
        <small class="show">
            <strong>
                PDF document
            </strong>
        </small>
        <p>
            <?php echo $file->description; ?>
        </p>
        <small class="show file-user-info">
            <i>Uploaded by
                <?php echo elgg_view('output/url', array(
                    'href'  => "profile/".$owner->login,
                    'title' => $owner->name,
                    'text'  => $owner->name));
                ?>
                <?php echo elgg_view('output/friendlytime', array('time' => $file->time_created));?>
            </i>
        </small>
    </td>
    <td style=" vertical-align: middle; text-align: center; " class="col-md-3">
        <div>
            <div style="width: 35px;display: inline-block;float: right;">
                <?php echo elgg_view('output/url', array(
                    'href'  => "{$href}/download/".$file->id,
                    'title' => $owner->name,
                    'class' => 'btn btn-default',
                    'style' => 'padding: 5px 10px;',
                    'text'  => '<i class="fa fa-download"></i>'));
                ?>
                <small class="show text-truncate" style="margin-top: 3px;">
                    <?php echo formatFileSize($file->size);?>
                </small>
            </div>
        </div>
    </td>
</tr>
<?php endforeach; ?>

</tbody>

</table>