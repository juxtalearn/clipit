<?php
/**
 * Created by PhpStorm.
 * User: equipo
 * Date: 5/03/14
 * Time: 11:36
 */
$message = elgg_extract("entity", $vars);
$owner = new ElggUser($message->owner_id);
$user_loggedin_id = elgg_get_logged_in_user_guid();
$user_loggedin = new ElggUser($user_loggedin_id);
$total_replies = ClipitPost::get_count_by_destination(array($message->id));

// Owner options (edit/delete)
$owner_options = "";
if($message->owner_id == elgg_get_logged_in_user_guid()){
    $options = array(
        'entity' => $message,
        'edit' => array(
            "data-target" => "#edit-discussion-{$message->id}",
            "href" => elgg_get_site_url()."ajax/view/modal/group/discussion/edit?id={$message->id}",
            "data-toggle" => "modal"
        ),
        'remove' => array("href" => "action/group/discussion/remove?id={$message->id}"),
    );

    $owner_options = elgg_view("page/components/options_list", $options);
    // Remote modal, form content
    echo elgg_view("page/components/modal_remote", array('id'=> "edit-discussion-{$message->id}" ));
}
?>
<div class="discussion discussion-owner-msg">
    <div class="header-post">
        <?php echo $owner_options; ?>
        <img class="user-avatar" src="<?php echo $owner->getIconURL('small'); ?>" />
        <div class="block">
            <h2 class="title"><?php echo $message->name; ?></h2>
            <small class="show">
                <i>
                    Created by
                    <?php echo elgg_view('output/url', array(
                        'href'  => "profile/".$owner->login,
                        'title' => $owner->name,
                        'text'  => $owner->name));
                    ?>
                    <?php echo elgg_view('output/friendlytime', array('time' => $message->time_created));?>
                </i>
                <?php
                if($total_replies > 0):
                    $last_post_id = end(ClipitMessage::get_replies($message->id));
                    $last_post = array_pop(ClipitMessage::get_by_id(array($last_post_id)));
                    $author_last_post = array_pop(ClipitUser::get_by_id(array($last_post->owner_id)));
                    ?>
                    <i class="pull-right">
                        Last post by
                        <?php echo elgg_view('output/url', array(
                            'href'  => "profile/".$author_last_post->login,
                            'title' => $author_last_post->name,
                            'text'  => $author_last_post->name,
                        ));
                        ?> (<?php echo elgg_view('output/friendlytime', array('time' => $last_post->time_created));?>)</i>
                <?php endif; ?>
            </small>
        </div>
    </div>
    <div class="body-post"><?php echo $message->description; ?></div>
</div>

<!--<iframe id="someId"></iframe>-->
<!--<div style="background: #000;position: absolute;z-index:10000;padding: 20px; color: #fff" id="light">-->
<!--    <ul>-->
<!--        <li>Miguel Ángel</li>-->
<!--        <li>Jose Antonio</li>-->
<!--    </ul>-->
<!--</div>-->
<script>
$(function(){
    $(".quote-ref").click(function(){
        var quote_id = $(this).data("quote-ref");
        var parent = $(this).closest("div");
        var $obj = $(this);
        var quote_content = parent.find(".quote-content[data-quote-id="+quote_id+"]");

        if(quote_content.length == 0){
            $(this).addClass("active");
            $(this).after("<div class='quote-content' data-quote-id='"+quote_id+"'></div>");
            var quote_content = parent.find(".quote-content[data-quote-id="+quote_id+"]");
            quote_content.html("<a class='loading'><i class='fa fa-spinner fa-spin'></i> loading...</a>");
            $.ajax({
                url: elgg.config.wwwroot+"ajax/view/group/discussion/quote",
                type: "POST",
                data: { quote_id : quote_id, message_destination_id : <?php echo $message->id; ?>},
                success: function(html){
                    quote_content.html(html);
                    console.log(html);
                }
            });
        } else {
            parent.find(".quote-content[data-quote-id="+quote_id+"]").toggle(1,function(){
                $obj.toggleClass("active");
            });
        }
    });

});
</script>
<a name="replies"></a>
<?php
function text_reference($text_message){
    if(preg_match('/(^|[^a-z0-9_])#([0-9_]+)/i', $text_message)){
        $prex = '/#([0-9_]+)/i';
        preg_match_all($prex, $text_message, $string_regex, PREG_PATTERN_ORDER);
        $string_regexs = $string_regex[1];
        foreach($string_regexs as $string){
            $text_message = preg_replace(
                "/\#$string\b/",
                '<strong class="quote-ref" data-quote-ref="'.$string.'">
                    <a class="btn">#'.$string.'</a>
                </strong>',
                $text_message);
        }


    }

    if(preg_match('/(^|[^a-z0-9_])@([a-z0-9_]+)/i',$text_message)){
        $prex = '/@([a-z0-9_]+)/i';
        preg_match_all($prex, $text_message, $string_regex, PREG_PATTERN_ORDER);
        $string_regexs = $string_regex[1];
        foreach($string_regexs as $string){
            /// OLD: "/(^|[^a-z0-9_])@".$string."/i"
            $user = array_pop(ClipitUser::get_by_login(array($string)));
            if(!empty($user)){
                $url_link = elgg_view('output/url', array(
                    'href'  => "profile/".$user->login,
                    'title' => "@".$user->login,
                    'text'  => $user->name,
                    'style' => 'border-radius:3px; background: #bae6f6;padding: 1px 5px;font-weight: bold;',
                ));
                $text_message = preg_replace("/\@".$user->login."\b/",'$1'.$url_link, $text_message);
            }
        }
    }
    return $text_message;
}
$auto_id = 1;
foreach(array_pop(ClipitPost::get_by_destination(array($message->id))) as $reply_msg){
    echo elgg_view("group/discussion/reply", array('entity' => $reply_msg, 'auto_id' => $auto_id));
    $auto_id++;
}
?>

<!-- Reply form -->
<a name="create_reply"></a>
<h3 class="activity-module-title"><?php echo elgg_echo("reply:create"); ?></h3>
<div class="discussion discussion-reply-msg">
    <div class="user-reply">
        <img class="user-avatar" src="<?php echo $user_loggedin->getIconURL('small'); ?>"/>
    </div>
    <div class="block">
        <?php echo elgg_view_form("group/discussion/reply/create", array('data-validate'=> "true" ), array('entity'  => $message)); ?>
    </div>
</div>
<!-- Reply form end-->
<style>
.upload-files input[type=file]{
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    opacity: 0;
    -ms-filter: 'alpha(opacity=0)';
    direction: ltr;
    cursor: pointer;
}
.upload-files-list{
    background: #fff;
    padding: 10px;
    margin-top: 10px;
    border: 1px solid #bae6f6;
    border-radius: 3px;
}
.upload-files-list .file{
    margin-bottom: 10px;
    padding-bottom: 10px;
    overflow: hidden;
    border-bottom: 1px solid #bae6f6;
}
.upload-files-list .file:last-child{
    border-bottom: 0;
    margin-bottom: 0;
    padding-bottom: 0;
}
.upload-files-list .file img, .upload-files-list .file canvas{
    width: 60px;
    height: 40px;
    float: left;
    margin-right: 10px;
}
.upload-files-list .file .cancel{
    color: #ff4343;
    margin-left: 10px;
}
</style>
<!---------------------------------------->

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
        var url = window.location.hostname === 'blueimp.github.io' ?
                '//jquery-file-upload.appspot.com/' : 'server/php/',
            uploadButton = $('<button/>')
                .addClass('btn btn-primary')
                .prop('disabled', true)
                .text('Processing...')
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
            data.context = $('<div class="file"/>').appendTo('.upload-files-list');
            $.each(data.files, function (index, file) {
                var node = $('<div class="details"/>')
                    .append($('<small class="size pull-right"/>').text(formatFileSize(file.size)))
                    .append($('<div class="name"/>').text(file.name))
                    .append('<div id="progress" class="progress"><div class="progress-bar progress-bar-success"></div></div>');
//                if (!index) {
//                    node
//                        .append('<br>')
//                        .append(uploadButton.clone(true).data(data));
//                }
                node.appendTo(data.context);
            });
        }).on('fileuploadprocessalways', function (e, data) {
            var index = data.index,
                file = data.files[index],
                node = $(data.context.children()[index]);
//                node.find(".size").text(formatFileSize(file.size));
            console.log(formatFileSize(file.size))
            if (file.preview) {
                node
                    .before(file.preview)
                    .append("<div></div>");
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

<div style="
    background: #fff;
    padding: 10px;
    margin-top: 10px;
    border: 1px solid #bae6f6;  border-radius: 3px;
    display:none;
">
    <div style="
    margin-bottom: 10px;
    padding-bottom: 10px;
    overflow: hidden;
    border-bottom: 1px solid #bae6f6;

">
        <img src="http://www.ucci.urjc.es/wp-content/uploads/Juxtalearn-620x434.jpg" style="
    width: 60px;
    float: left;
    margin-right: 10px;
"><div style="
    overflow: hidden;
">
            <small class="pull-right">8.90 KB</small>
            <div>clipit-diagram.png</div><div id="progress" class="progress">
                <div class="progress-bar progress-bar-success"></div>
            </div>
        </div>
    </div><div style="
    overflow: hidden;
    padding-bottom: 10px;
">
        <img src="https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcTz_3Stt6EU0FOiFimoaAjKOteMcu-XW5VusMoXGTTmeE6JQQwHWw" style="
    width: 60px;
    float: left;
    margin-right: 10px;
    height: 40px;
"><div style="
    overflow: hidden;
">
            <small class="pull-right">8.90 KB</small>
            <div style="
">OhMyGob.jpg</div><div id="progress" class="progress">
                <div class="progress-bar progress-bar-success"></div>
            </div>
        </div>
    </div>
</div>
<!---------------------------------------->

<br>



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
        var url = window.location.hostname === 'blueimp.github.io' ?
                '//jquery-file-upload.appspot.com/' : 'server/php/',
            uploadButton = $('<button/>')
                .addClass('btn btn-primary')
                .prop('disabled', true)
                .text('Processing...')
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
        $('#fileupload').fileupload({
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
            data.context = $('<div/>').appendTo('.upload-files-list');
            $.each(data.files, function (index, file) {
                var node = $('<p/>')
                    .append($('<span/>').text(file.name));
                if (!index) {
                    node
                        .append('<br>')
                        .append(uploadButton.clone(true).data(data));
                }
                node.appendTo(data.context);
            });
        }).on('fileuploadprocessalways', function (e, data) {
            var index = data.index,
                file = data.files[index],
                node = $(data.context.children()[index]);

            console.log(formatFileSize(file.size))
            if (file.preview) {
                node
                    .prepend('<br>')
                    .prepend(file.preview)
                    .append("<div></div>");
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
