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
        data.context.find('.preview').each(function (index, elm) {
            var preview = data.files[index].preview;
                if(preview){
                    $(elm).append(preview);
                } else {
                    var icon = '';
                    var $icon = $('<i class="icon fa" style="font-size: 50px;"/>');
                        $icon = clipit.file.getIcon(data.files[index].type, $icon);
                    $(elm).append($icon);
                }
            });
    };
    var fileupload_setup = function(){
        $(".fileupload").each(function() {
            var that = $(this);
            $(this).fileupload({
                // Uncomment the following to send cross-domain cookies:
                //xhrFields: {withCredentials: true},
                maxFileSize: 500000000, // 500 MB
                url: elgg.config.wwwroot+'ajax/view/multimedia/file/attach_action',
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
                var form = $(data.form);
                var fileList = form.find(".upload-files-list");
                if(fileList.is(":hidden")){
                    fileList.show();
                }
            }).on('fileuploadstopped', function (e, data) {
                that.submit();
            });
        });
    };
    $(document).on("click", ".fileupload input[type=submit]", function(e){
        var form = $(this).closest("form");
        var file = form.find(".upload-files-list").find(".template-upload");
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
    fileupload_setup();
});
