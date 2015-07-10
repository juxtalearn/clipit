<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   12/05/14
 * Last update:     12/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
?>
//<script>
$(function () {
    'use strict';
    $.blueimp.fileupload.prototype._renderPreviews = function (data) {
        // exec tinymce
        clipit.tinymce();
        data.context.find('.preview').each(function (index, elm) {
            var preview = data.files[index].preview;
                if(preview){
                    $(elm).append(preview);
                } else {
                    var $icon = $('<i class="icon fa" style="font-size: 50px;"/>');
                        $icon = clipit.file.getIcon(data.files[index].type, $icon);
                    $(elm).append($icon);
                }
            });
    },
    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload({
        maxFileSize: 1073741824, // 1 GB
//        url: elgg.config.wwwroot+'ajax/view/multimedia/file/upload',
        url: elgg.security.addToken($('#fileupload').attr('action')),
        previewMaxWidth: 140,
        previewMaxHeight: 140,
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewCrop: true
    }).on('fileuploadadd', function (e, data) {
        $('#add-file').modal('show');
        // exec tinymce
        clipit.tinymce();
    }).on('fileuploadstop', function (e, data) {
        $("#add-file .modal-body").html('<i class="fa fa-spinner fa-spin" style="font-size: 40px;color: #bae6f6"></i>');
        $("#add-file .modal-footer").html("");
        window.location.reload(false);
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
    });
    $('#fileupload').bind('fileuploadstopped', function (e, data) {
        data.context.remove();
    });
    $('#add-file').on('hidden.bs.modal', function (e) {
        $("#add-file .files").empty();
    })
});