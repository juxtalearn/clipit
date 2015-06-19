<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   13/05/14
 * Last update:     13/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$video = elgg_extract("entity", $vars);
?>
    <div class="frame-container" style="width: 100%;">
        <?php if(get_video_url_embed($video->url)):?>
            <iframe src="<?php echo get_video_url_embed($video->url); ?>" frameborder="0"></iframe>
        <?php else:?>
            <video width="100%"  controls>
                <source src="<?php echo($video->url); ?>" type='video/webm; codecs="vp8, vorbis"' />
                Your browser does not support the video tag.
            </video>
        <?php endif;?>
    </div>
<?php if($video->id == 13226):?>
<style>
    .ui-slider-horizontal .ui-slider-handle span{
        background-color: #fff;
        padding: 0 5px;
        border: 1px solid #32b4e5;
        margin-left: -13px;
        top: -23px;
        border-radius: 4px;
        z-index: 2;
        display: none;
    }
    .ui-slider-horizontal .ui-slider-range{
        background-color: #76D5F9;
    }
    .video-element{
        background-color: rgb(236, 247, 252);
        color: #32b4e5;
        /*padding: 3px 10px;*/
        padding: 3px 0;
        border-radius: 4px;
        font-weight: bold;
        margin-right: 15px;
        position: relative;
        z-index: 10;
        border: 1px solid #B0D6E5;
        cursor: default;
    }
    .video-element.resizable,
    .video-element.selected-element {
        cursor: move;
    }
    .video-element.ui-resizable-resizing{
        opacity: 0.6;
        border: 1px dashed #B0D6E5;
    }
    .video-element .ui-resizable-handle{
        width: 7px;
        height: 100%;
        display: inline-block;
        position: absolute;
        top: 0;
        cursor: e-resize;
    }
    .video-element .ui-resizable-handle.ui-resizable-w{
        left: 0;
    }
    .video-element .ui-resizable-handle.ui-resizable-e{
        right: 0;
    }
    .video-element.active{
        background: #32b4e5;
        color: #fff;
        border: 1px solid #fff;
    }
    #bar-timeline{
        background: rgba(216, 186, 5, 0.4);
        position: absolute;
        z-index: 100;
        top: 18px;
        left: 0;
        margin-left: 19px;
        width: 2px;
        display: block;
        height: 100%;
    }
    #bar-timeline:after{
        content: "";
        position: absolute;
        bottom: -3px;
        left: -2px;
        width: 6px;
        height: 6px;
        border-radius: 6px;
        background-color: #d8ba05;
    }
    .video-element-title{
        border-bottom: 1px solid #32b4e5;
        padding-top: 8px;
        padding-bottom: 10px;
    }
    .video-element-title input{
        width: 100%;
    }
    .video-element-timeline{
        border-bottom: 1px dashed #bae6f6;
        padding: 5px 0;
        margin-bottom: 5px;
        position: relative;
        height: 45px;
    }
    .video-element-timeline .video-element{
        margin-right: 0;
    }
    .selected-element{
        margin-right: 0;
        background: #fff;
        left: 50%;
        top: 20%;
        padding: 10px;
        border: 1px solid #32b4e5;
    }
    .selected-element span{
        margin: 0;
    }
</style>
<script>
function getISODate(seconds){
    var date = new Date(null);
    date.setSeconds(seconds); // specify value for SECONDS here
    return date.toISOString().substr(15, 4);
}
var YTplayer;
$(function(){
        function loadEditor(){
        var videoDuration = YTplayer.getDuration();
        console.log(videoDuration);
        var $elem = $('.player-slider');
        $(document).on('click', '.select-element', function(){
            var type = $(this).data('type'),
                data = {
                    'element': new Date().getTime()+Math.floor(Math.random(0, 5)),
                    'start': 0,
                    'end': videoDuration
                };
            switch (type){
                case 'text':
                    var clone = $(this).clone();
                    clone.find('.fa').remove();
                    clone
                        .attr({
                            'data-element': data.element,
                            'data-start': data.start,
                            'data-end': data.end
                        })
                        .addClass('selected-element').removeClass('select-element')
                        .draggable({
                            containment: 'parent',
                            scroll: false,
                            drag: function(event, ui){
                                $('#'+ $(event.target).data('element')).addClass('active');
                            },
                            stop: function(event, ui){
                                $('#'+ $(event.target).data('element')).removeClass('active');
                            }
                        })
                        .appendTo('#video-wrapper');
                    createElementTimeline(data);
                    break;
            }
        });
        $('.player-slider').each(function () {
            $(this).slider({
                range: 'min',
                value: $(this).find("input").val(),
                min: 0,
                max: videoDuration,
                step: 1,
                values: 1,
                create: function (event, ui) {
                    $(this).find("a").append($("<span/>").text(getISODate(0)));
                    var value = $(this).find("input").val();
                },
                slide: function (event, ui) {
                    YTplayer.seekTo(ui.value, true);
//                            YTplayer.pauseVideo();
                    $('#bar-timeline').css('left', $(ui.handle).css('left') );
                    $(this).find("a span").text(getISODate(ui.value)).fadeIn('fast');
//                        $(this).find("input").val(value);
//                        $(this).find(".ui-slider-range").removeClass().addClass("ui-slider-range");
                },
                change: function (event, ui) {
                    $('#bar-timeline').css('left', $(ui.handle).css('left'));
                },
                stop: function (event, ui) {
                    $(this).find("a span").text(getISODate(ui.value)).fadeOut('fast');
                    $('#bar-timeline').css('left', $(ui.handle).css('left') );
                }
            });
        });
        setInterval(checkVideoProperties, 500); //check status
    };
    $('.resizable').each(function () {
        $(this).draggable({ axis: "x", containment: "parent" }).resizable({
            handles: 'e, w',
            minWidth: 80,
            containment: "parent"
        });
    });

    var player = {
        playVideo: function(container, videoId) {
            if (typeof(YT) == 'undefined' || typeof(YT.Player) == 'undefined') {
                window.onYouTubeIframeAPIReady = function() {
                    player.loadPlayer(container, videoId);
                };

                $.getScript('//www.youtube.com/iframe_api');
            } else {
                player.loadPlayer(container, videoId);
            }
        },
        loadPlayer: function(container, videoId) {
            YTplayer = new YT.Player(container, {
                videoId: videoId,
                playerVars: {
                    disablekb: 1,
                    modestbranding: 1,
                    rel: 0,
                    showinfo: 0,
                    controls: 0
                },
                events: {
                    'onReady': loadEditor,
                    'onStateChange': onPlayerStateChange
                }
            });
        }
    };
    player.playVideo('video-player', 'yb8icchy4H4');


    function createElementTimeline(data){
        var videoDuration = YTplayer.getDuration(),
            start = data.start,
            end = ((data.end*1)/videoDuration)*100;
        var element =
            '<div class="video-element-timeline margin-right-20 margin-left-5">' +
                '<div class="inline-block video-element resizable text-truncate" ' +
                    'data-start="'+ data.start +'" data-end="'+ data.end +'"' +
                    'id="'+ data.element +'"' +
                    'style="left: '+ start +'px;width: '+ end +'%">' +
                '<i class="margin-left-10 fa fa-font"></i> <span class="margin-right-10">Texto</span>' +
            '</div>';

        var $element = $(element).appendTo('#video-timeline');
        $element.find('.resizable')
        .draggable({
            axis: "x",
            containment: "parent",
        })
        .resizable({
            handles: 'e, w',
            minWidth: 80,
            containment: "parent",
            resize: function(event, ui){
                $('[data-element="'+ data.element +'"]').data({
                    'start': (ui.position.left*videoDuration)/($element.width() - 1),
                    'end': (ui.size.width*videoDuration)/($element.width() - 1)
                });
            }
        });
    }
    function checkVideoProperties(){
        var currentTime = YTplayer.getCurrentTime();
        setTimeBar(currentTime);
        checkElements(currentTime);
    }
    function checkElements(currentTime){
        $('#video-wrapper').find('.selected-element').each(function(){
//            if(currentTime < $(this).data('start') && currentTime > $(this).data('end')){
            if(currentTime >= $(this).data('end')){
                $(this).fadeOut('fast');
            } else {
                $(this).fadeIn('fast');
            }
        });
    }
    function setTimeBar(currentTime){
        $('.player-slider')
            .slider('value', currentTime)
            .find('span')
            .fadeIn('fast').text(getISODate(currentTime));
    }
    function onPlayerStateChange(event){
        if (event.data == YT.PlayerState.PLAYING) {
//                    setTimeout(stopVideo, 6000);
            done = true;
//                    console.log(YT);
//                    $('.player-slider').slider('value', )
        }
    }
//        $elem.find(" a span" ).text(  $(this).find("input").val() );
});
</script>

    <div class="frame-container margin-top-20" style="width: 100%;">
        <div id="video-player"></div>
        <div id="video-wrapper" style="position: absolute;width: 100%;height: 100%;top: 0"></div>
    </div>
    <div class="video-editor margin-top-20" style="padding: 10px;background: #fff;">
        <div>
            <small class="show">Añadir elementos</small>
            <div class="inline-block video-element select-element" data-type="text">
                <i class="margin-left-10 fa fa-font"></i>
                <span class="margin-right-10">Texto</span>
            </div>
            <div class="inline-block video-element select-element" data-type="image">
                <i class="margin-left-10 fa fa-image"></i>
                <span class="margin-right-10">Imagen</span>
            </div>
            <div class="inline-block video-element select-element" data-type="test">
                <i class="margin-left-10 fa fa-pencil-square-o"></i>
                <span class="margin-right-10">Test</span>
            </div>
        </div>
        <div class="row margin-top-20">
            <div class="col-md-3">
                <a class="btn btn-sm btn-default" style="float: none;display: block;">Añadir capa</a>
                <?php for($i=0;$i<4;$i++):?>
                    <div class="video-element-title">
                        <?php echo elgg_view('input/text', array(
                            'name' => '',
                            'required' => true
                        ));
                        ?>
                    </div>
                <?php endfor;?>
            </div>
            <div class="col-md-9" style="position: relative" id="video-timeline">
                <div id="bar-timeline"></div>
                <div class="player-slider" style="margin: 10px 20px;margin-left: 0">
                    <?php echo elgg_view('input/hidden', array('class' => 'val_1')); ?>
                </div>
                <?php for($i=0;$i<4;$i++):?>
                    <div class="video-element-timeline margin-right-20 margin-left-5">
                        <div class="inline-block video-element resizable text-truncate">
                            <i class="margin-left-10 fa fa-font"></i> <span class="margin-right-10">Texto</span>
                        </div>
                    </div>
                <?php endfor;?>
            </div>
        </div>
    </div>
<?php endif;?>