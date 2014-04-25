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
?>
<script>
    $(function(){
//    $("#wrap").on("click", "#add-url", function(){
        $("#wrap").on("keyup", "#video-url", function(){
            var form = $(this).closest("form");
            //var query = form.find("input[name=web-url]").val();
            var query = form.serialize();
            var regex = /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;
            if(!regex.test($(this).val()))
                return false;
            form.find(".loading").show();
            form.find(".video-prev > i").removeClass("fa-play").addClass("fa-spinner fa-spin");
            form.find("#group-hide").hide();
            form.find("#link-favicon").hide();
            $.getJSON(elgg.config.wwwroot+"action/multimedia/links/extract_data?"+query, function (data) {
                //call process to show the result
                if(data.video_prev_url){
                    form.find(".video-prev > i").addClass("fa-play").removeClass("fa-spinner fa-spin").hide();
                    form.find(".loading").hide();
                    form.find("#link-favicon").show();
                    form.find("#group-hide").show();

                    form.find("#link-favicon").attr("src", data.favicon);
                    form.find("#video-title").val(data.title);
                    form.find(".video-prev > a").attr("href", data.url).show();
                    form.find(".video-prev a > img").attr("src", data.video_prev_url).show();
                }
            });
            return false;
        });
    });
</script>
<?php echo elgg_view_form('multimedia/videos/add', array('data-validate'=> "true" ), array('entity'  => $entity)); ?>
<div class="block" style="margin-bottom: 10px;">
    <button type="button" data-toggle="modal" data-target="#add-video" class="btn btn-default">Add video</button>
</div>
<style>
    .video_prev:hover  #video-hover {display: table !important;}
</style>
<div class="row">
    <div class="col-md-5 col-lg-4">
        <div class="video_prev">
            <div class="bg-video" style="background-image: url('http://b.vimeocdn.com/ts/450/621/450621782_640.jpg');">
                <div id="video-hover" style="
    display: table;
    width: 100%;
    height: 100%;
    background: rgba(186,230,246,0.9);
    cursor: pointer;
    display: none;
"><i class="fa fa-play" style="
    color: #fff;
    display: table-cell;
    text-align: center;     vertical-align: middle;
    font-size: 60px;
    opacity: 1;
"></i></div>
            </div>
            <div>
                <h4><a>Lorem ipsum dolor sit amet, consectetur adipiscing elit. </a></h4>
                <p class="date">
                    12:00H, Nov 18, 2013
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-5 col-lg-4">
        <div class="video_prev">
            <div class="bg-video" style="background-image: url('http://b.vimeocdn.com/ts/457/585/457585184_640.jpg');">
                <div id="video-hover" style="
    display: table;
    width: 100%;
    height: 100%;
    background: rgba(186,230,246,0.9);
    cursor: pointer;
    display: none;
"><i class="fa fa-play" style="
    color: #fff;
    display: table-cell;
    text-align: center;     vertical-align: middle;
    font-size: 60px;
    opacity: 1;
"></i></div>
            </div>
            <div>
                <h4><a>Lorem ipsum dolor sit amet, consectetur adipiscing elit. </a></h4>
                <p class="date">
                    12:00H, Nov 18, 2013
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-5 col-lg-4">
        <div class="video_prev">
            <div class="bg-video" style="background-image: url('http://b.vimeocdn.com/ts/432/509/432509421_640.jpg');">
                <div id="video-hover" style="
    display: table;
    width: 100%;
    height: 100%;
    background: rgba(186,230,246,0.9);
    cursor: pointer;
    display: none;
"><i class="fa fa-play" style="
    color: #fff;
    display: table-cell;
    text-align: center;     vertical-align: middle;
    font-size: 60px;
    opacity: 1;
"></i></div>
            </div>
            <div>
                <h4><a>Lorem ipsum dolor sit amet, consectetur adipiscing elit. </a></h4>
                <p class="date">
                    12:00H, Nov 18, 2013
                </p>
            </div>
        </div>
    </div>
</div>