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
$video_ids = elgg_extract('videos', $vars);
$href = elgg_extract("href", $vars);
?>
<script>
    $(function(){
        $("#wrap").on("keyup", "#video-url", function(){
            var form = $(this).closest("form");
            var that = $(this);
            var query = form.serialize();
            var regex = /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;
            if(!regex.test($(this).val()))
                return false;
            form.find(".loading").show();
            form.find(".video-prev > i").removeClass("fa-play").addClass("fa-spinner fa-spin");
            form.find("#group-hide").hide();
            form.find("#link-favicon").hide();
            tinymce.activeEditor.setContent("");
            $.getJSON(elgg.config.wwwroot+"action/multimedia/videos/extract_data?"+query, function (data) {
                //call process to show the result
                if(data.id){
                    form.find(".video-prev > i").addClass("fa-play").removeClass("fa-spinner fa-spin").hide();
                    form.find(".loading").hide();
                    form.find("#link-favicon").show();
                    form.find("#group-hide").show();

                    form.find("#link-favicon").attr("src", data.favicon);
                    form.find("#video-title").val(data.title);
                    tinymce.activeEditor.setContent(data.description);
                    form.find(".video-prev > a").attr("href", that.val()).show();
                    form.find(".video-prev a > img").attr("src", data.preview).show();
                }
            });
            return false;
        });
    });
</script>
<?php if($vars['add_video']):?>
    <?php echo elgg_view_form('multimedia/videos/add', array('data-validate'=> "true" ), array('entity'  => $entity)); ?>
    <div class="block" style="margin-bottom: 20px;">
        <button type="button" data-toggle="modal" data-target="#add-video" class="btn btn-default">Add video</button>
    </div>
<?php endif; ?>

<ul class="video-list">
    <?php
    foreach($video_ids as $video_id):
        $video = array_pop(ClipitVideo::get_by_id(array($video_id)));
        $user = array_pop(ClipitUser::get_by_id(array($video->owner_id)));
        $description = trim(elgg_strip_tags($video->description));
        // Description truncate max length 280
        if(mb_strlen($description)>280){
            $description = substr($description, 0, 280)."...";
        }
        ?>
        <li class="video-item row list-item">
            <div class="col-lg-4">
                <a href="<?php echo elgg_get_site_url()."{$href}/view/{$video->id}"; ?>">
                    <div class="img-preview">
                        <?php if($rating):?>
                            <div class="ratings">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                        <?php endif; ?>
                        <img src="<?php echo $video->preview;?>">
                        <span class="duration label"><?php echo get_format_time($video->duration);?></span>
                    </div>
                </a>
            </div>
            <div class="col-lg-8">
                <?php echo elgg_view("multimedia/owner_options", array('entity' => $video, 'type' => 'video')); ?>
                <h4 class="text-truncate">
                    <?php echo elgg_view('output/url', array(
                        'href'  => "{$href}/view/".$video->id,
                        'title' => $video->name,
                        'text'  => $video->name));
                    ?>
                </h4>
                <div class="tags">
                    <span class="empty">no tags added</span>
                </div>
                <p>
                    <?php echo $description;?>
                </p>
                <small class="show">
                    <i>
                        Uploaded by
                        <?php echo elgg_view('output/url', array(
                            'href'  => "profile/".$user->login,
                            'title' => $user->name,
                            'text'  => $user->name));
                        ?>
                        <?php echo elgg_view('output/friendlytime', array('time' => $video->time_created));?>
                    </i>
                </small>
            </div>
        </li>
    <?php endforeach; ?>
</ul>