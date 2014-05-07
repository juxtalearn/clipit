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
<?php //echo elgg_view_form('multimedia/files/upload', array('data-validate'=> "true", 'enctype' => 'multipart/form-data'), array('entity'  => $entity)); ?>
</div>
<div class="block" style="margin-bottom: 10px;">
    <?php echo elgg_view_form('multimedia/files/upload_', array('id' => 'fileupload', 'enctype' => 'multipart/form-data'), array('entity'  => $entity)); ?>
</div>
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
<div class="row template-upload fade">
    <?php echo elgg_view("input/hidden", array(
        'name' => 'entity-id',
        'value' => $entity->id,
    ));?>
    <div class="col-md-3">
        <div class="file-info">
            <div class="img-prev"><div class="preview"></div></div>
            <div class="text-truncate">
                <small class="size pull-right">Processing...</small>
                <div class="text-truncate"><a title="{%=file.name%}">{%=file.name%}</a></div>
            </div>
            <strong class="error text-danger"></strong>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
            <a class="cancel btn" style="
    color: #ff1a1a;
    margin-top: 5px;
    display: block;
    text-transform: uppercase;
    border: 1px solid #ff1a1a;
">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Delete</span>
                </a>
        </div>
    </div>
    <button class="btn btn-primary start" style="display:none;" disabled>
        <span>Start</span>
    </button>
    <div class="col-md-8">
        <div class="form-group">
            <label for="file-name"><?php echo elgg_echo("multimedia:file:description");?></label>
            <?php echo elgg_view("input/plaintext", array(
            'name' => 'file-text',
            'class' => 'form-control mceEditor',
            'rows'  => 3,
        )); ?>
        </div>
    </div>
</div>
{% } %}

</script>
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <div class="template-download fade" style="display:none;">
    </div>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
</script>
<script src="http://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
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
<script src="http://blueimp.github.io/jQuery-File-Upload/js/jquery.fileupload-ui.js"></script>


<script>
    $(function () {
        'use strict';
        $.blueimp.fileupload.prototype._renderPreviews = function (data) {
            // exec tinymce
            tinymce_setup();
            data.context.find('.preview').each(function (index, elm) {
                var preview = data.files[index].preview;
                if(preview){
                    $(elm).append(preview);
                } else {
                    $(elm).append('<i class="icon fa fa-file-o" style="color: #C9C9C9;font-size: 50px;"></i>');
                }
            });
        },
        // Initialize the jQuery File Upload widget:
        $('#fileupload').fileupload({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            maxFileSize: 500000000, // 500 MB
            //url: '<?php echo elgg_add_action_tokens_to_url(elgg_normalize_url(elgg_get_site_url()."action/multimedia/files/upload"), true);?>'
            url: '<?php echo elgg_get_site_url()."ajax/view/multimedia/upload";?>',
            previewMaxWidth: 140,
            previewMaxHeight: 140,
            disableImageResize: /Android(?!.*Chrome)|Opera/
                .test(window.navigator.userAgent),
            previewCrop: true
        }).on('fileuploadadd', function (e, data) {
            $('#add-file').modal('show');
            // exec tinymce
            tinymce_setup();
        }).on('fileuploadstop', function (e, data) {
               $("#add-file .modal-body").html('<i class="fa fa-spinner fa-spin" style="font-size: 40px;color: #bae6f6"></i>');
                $("#add-file .modal-footer").html("");
                window.location.reload(false);
//            $(".file-info .progress-bar-success").parent(".progress").hide();
            //$("#fileupload").submit();
        });

        // Enable iframe cross-domain access via redirect option:
        $('#fileupload').fileupload(
            'option',
            'redirect',
            window.location.href.replace(
                /\/[^\/]*$/,
                '/cors/result.html?%s'
            )
        );
        $('#fileupload').bind('fileuploadsubmit', function (e, data) {
            var inputs = data.context.find(':input');
            if (inputs.filter(function () {
                return !this.value && $(this).prop('required');
            }).first().focus().length) {
                data.context.find('button').prop('disabled', false);
                return false;
            }
            var textarea = data.context.find("textarea");
            textarea.val(tinyMCE.get(textarea.attr("id")).getContent());
            var total = data.context.find(':input, textarea');
            data.formData = total.serializeArray();
            //console.log(data.formData);
        });
        $('#fileupload').bind('fileuploadstopped', function (e, data) {
            data.context.remove();
        });
        $('#add-file').on('hidden.bs.modal', function (e) {
            $("#add-file .files").empty();
        })
//        $(document).on("change", "#uploadfilebutton",function(e){
//            e.preventDefault();
//            var fileList = $("#add-file .files");
//            console.log(fileList.find("div").length);
//            if(fileList.find("div").length > 0){
//                fileList.empty();
//            }
//        });
    });

</script>
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
                .attr("type", "button")
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
            $("#add-file .modal-body").html("")
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
        }).on('fileuploadsubmit', function (e, data) {
//            console.log(data);
//            $.each(data.files, function (index, file) {
//                console.log(file);
//            });
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
                console.log(file);
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
    .files .template-upload{
         border-bottom: 1px solid #bae6f6;
         margin-bottom: 10px;
         padding-bottom: 10px;
     }
    .files .template-upload:last-child{
        border-bottom: 0;
    }
    .progress-extended{
        text-align: left;
    }
    /*.files .fade {
        opacity: 1;
    }
    .files .fade .progress-striped[aria-valuenow=100]{
        display: none;
    }*/
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
//echo elgg_view("page/components/modal",
//    array(
//        "dialog_class"     => "modal-lg add-files-list",
//        "target"    => "add-file",
//        "title"     => elgg_echo("multimedia:files:add"),
//        "form"      => true,
//        "body"      => $body,
//        "cancel_button" => true,
//        "ok_button" => elgg_view('input/submit',
//            array(
//                'value' => elgg_echo('add'),
//                'class' => "btn btn-primary"
//            ))
//    ));

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

    $file_description = trim(elgg_strip_tags($file->description));
    // text truncate max length 165
    if(mb_strlen($file_description)>165){
        $file_description = substr($file_description, 0, 165)."...";
    }
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
?>
<tr>
    <td>
        <input type="checkbox">
    </td>
    <td class="text-center">
        <div class="file-preview">
        <?php echo elgg_view('output/url', array(
            'href'  => "{$href}/view/".$file->id,
            'title' => $file->name,
            'text'  => elgg_view("multimedia/file/preview", array('file'  => $file))));
        ?>
        </div>
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
                <?php echo elgg_echo("file:" . $file->mime_type['short']);?>
            </strong>
        </small>
        <div>
            <?php echo $file_description; ?>
        </div>
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
    <td style=" vertical-align: middle;" class="col-md-3">
        <div>
            <div style="width: 35px;display: inline-block;float: right;text-align: center;">
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
            <?php echo $owner_options; ?>
        </div>
    </td>
</tr>
<?php endforeach; ?>

</tbody>

</table>