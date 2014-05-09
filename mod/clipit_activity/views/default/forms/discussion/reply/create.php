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
$message = elgg_extract('entity', $vars);

echo elgg_view("input/hidden", array(
    'name' => 'message-id',
    'value' => $message->id,
));
echo elgg_view("input/plaintext", array(
    'name' => 'message-reply',
    'class' => 'form-control mceEditor',
    'id'    => 'mceEditor',
    'rows'  => 6,
    'style' => "width: 100%;"
));
echo elgg_view('input/submit', array(
    'value' => elgg_echo('create'),
    'class' => "btn btn-primary pull-right",
    'style' => "margin-top: 20px;"
));
?>
<div class="upload-files col-md-10">
    <a style="position: relative;overflow: hidden">
        <strong>
        <i class="fa fa-paperclip"></i> Attach file
        <input type="file" multiple name="files">
        </strong>
    </a>
    <div class="upload-files-list files" style="display:none;float: left; width: 100%;"></div>
</div>

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
<!-- The File Upload validation plugin -->
<script src="http://blueimp.github.io/jQuery-File-Upload/js/jquery.fileupload-validate.js"></script>
<script src="http://blueimp.github.io/jQuery-File-Upload/js/jquery.fileupload-ui.js"></script>
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
<div class="template-upload fade file">
    <div class="preview"></div>
    <div class="details">
        <div class="pull-right">
            <small class="size">Processing...</small>
            <a class="cancel" style="color: #ff1a1a;display: inline-block;" href="javascript:;">
                <i class="fa fa-times"></i>
            </a>
        </div>
        <div class="name">{%=file.name%}</div>
        <strong class="error text-danger"></strong>
        <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" style=" height: 15px; border-radius: 0; margin-top: 5px; ">
            <div class="progress-bar progress-bar-success" style="width:0%;"></div>
        </div>
    </div>
    <button class="btn btn-primary start" style="display:none;" disabled>
        <span>Start</span>
    </button>
</div>
{% } %}
</script>
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
<div class="template-download fade file">
    <input type="hidden" name="file-id[]" value="{%=file.id%}" />
    <div class="details">
        <span class="size pull-right">{%=o.formatFileSize(file.size)%}</span>
        <div>
            {% if (!file.error) { %}
            <a target="_blank" href="{%=file.download_url%}" >{%=file.name%}</a>
            {% } else { %}
            <span>{%=file.name%}</span>
            {% } %}
        </div>
        {% if (file.error) { %}
        <strong class="error text-danger">{%=file.error%}</strong>
        {% } %}
    </div>
</div>
{% } %}
</script>
<script>
    $(function () {
        'use strict';
        $.blueimp.fileupload.prototype._renderPreviews = function (data) {
            data.context.find('.preview').each(function (index, elm) {
                var preview = data.files[index].preview;
                if(preview){
                    $(elm).append(preview);
                } else {
                    $(elm).append('<i class="icon fa fa-file-o" style="color: #C9C9C9;font-size: 50px;"></i>');
                }
            });
        };
        $("#fileupload input[type=submit]").on("click", function(e){
            var file = $(".upload-files-list").find(".file");
            if(file.length > 0){
                file.each(function(index){
                    // upload starting
                    $(this).find('.start').click();
                });
                return false;
            }
            return true;
        });
            // Initialize the jQuery File Upload widget:
            $('#fileupload').fileupload({
                // Uncomment the following to send cross-domain cookies:
                //xhrFields: {withCredentials: true},
                maxFileSize: 500000000, // 500 MB
                url: '<?php echo elgg_get_site_url()."ajax/view/multimedia/upload_simple";?>',
                autoUpload: false,
                previewMaxWidth: 60,
                previewMaxHeight: 40,
                disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
                previewCrop: true
            }).on('fileuploadfail', function (e, data) {
                var fileList = $(".upload-files-list");
                if(fileList.find(".file").length == 1){
                    fileList.hide();
                }
            }).on('fileuploadadd', function (e, data) {
                var fileList = $(".upload-files-list");
                if(fileList.is(":hidden")){
                    fileList.show();
                }
            }).on('fileuploadstopped', function (e, data) {
                $("#fileupload").submit();
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