<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   23/02/2015
 * Last update:     23/02/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$videos = elgg_extract('entities', $vars);
?>
<div class="row" style="display: none;">
    <div class="col-md-8">
        <div class="row hm">
            <?php for($i=0; $i<15; $i++):?>
                <div class="col-md-12 margin-bottom-10 xs">
                    <div style="background: #ccc;height: 390px;"></div>
                </div>
                <div class="col-md-6">
                    <div style="background: #ccc;height: 325px;"></div>
                </div>
                <div class="col-md-6">
                    <div style="background: #ccc;height: 325px;"></div>
                </div>
                <div class="col-md-12 margin-top-10">
                    <div style="background: #ccc;height: 139px;"></div>
                </div>
            <?php endfor;?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="row sec">
            <?php for($i=0; $i<15; $i++):?>
                <div class="col-md-12 margin-bottom-10">
                    <div style="background: #ccc;height: 257px;"></div>
                </div>
                <div class="col-md-12 margin-bottom-10">
                    <div style="background: #ccc;height: 257px;"></div>
                </div>
                <div class="col-md-12 margin-bottom-10">
                    <div style="background: #ccc;height: 257px;"></div>
                </div>
                <div class="col-md-12 margin-bottom-10">
                    <div style="background: #ccc;height: 257px;"></div>
                </div>
            <?php endfor;?>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('.structure').each(function(){
            num = $(this).data('num');
            $element = $(this);
            $col_main = $element.closest('.video-list').find('.col-main .row');
            $col_secondary = $element.closest('.video-list').find('.col-secondary .row');
            switch(num){
                case 1:
                    if($element.hasClass('first')) {
                        $element.wrap('<div class="col-md-8 col-main"><div class="row"></div></div>');
                        $element.addClass('col-md-12 margin-bottom-10');
                    } else {
                        $col_main.append(
                            $element.addClass('col-md-12 margin-bottom-10')
                        );
                    }
                    break;
                case 2:
                    if($element.hasClass('first')) {
                        $element.wrap('<div class="col-md-4 col-secondary"><div class="row"></div></div>');
                        $element.addClass('col-md-12 margin-bottom-10');
                    } else {
                        $col_secondary.append(
                            $element.addClass('col-md-12 margin-bottom-10')
                        );
                    }
                    break;
                case 3:
                case 4:
                    $col_main.append(
                        $element.addClass('col-md-6 margin-bottom-10')
                    );
                    break;
                case 5:
                case 6:
                    $col_secondary.append(
                        $element.addClass('col-md-12 margin-bottom-10')
                    );
                    break;
                case 7:
                    $col_main.append(
                        $element.addClass('col-md-12 margin-bottom-10')
                    );
                    break;
                case 8:
                    $col_secondary.append(
                        $element.addClass('col-md-12 margin-bottom-10')
                    );
                    break;
                default:
                    $element.hide();
            }
        });
    });
</script>
<div class="row video-list">
    <?php
    $count = 1;
    $restart_count = false;
    foreach($videos as $video):
        $video_url = "video/".elgg_get_friendly_title($video->name)."/".$video->id;
        $remote_site = ClipitRemoteSite::get_by_id(array($video->remote_site));
        $date = date("M d, Y H:i", $video->time_created);
        $class = "element-item height2";
        $text_color = "";
        $image = get_video_thumbnail($video->url, 'normal');
        $description = $video->description;
        if(strlen($description)>350){
            $description = substr($description, 0, 350)."...";
        }
        $title = '<h3 class="margin-0 margin-bottom-5 text-truncate">
                '.elgg_view('output/url', array(
                'href' => $video_url,
                'style' => 'color:inherit;',
                'text'  => $video->name,
                'title' => $video->name
            )).'
            </h3>';
        $limit = 2;
        switch($count){
            case 1:
                $limit = 3;
                $class = "bg-color";
                $image = get_video_thumbnail($video->url, 'large');
                $title = '<h2 class="text-truncate margin-0 margin-bottom-10">
                        '.elgg_view('output/url', array(
                        'href' => $video_url,
                        'style' => 'color:white;',
                        'text'  => $video->name,
                        'title' => $video->name
                    )).'
                    </h2>';
                break;
            case 2:

                break;
            case 3:
            case 4:
                if(strlen($description)>150){
                    $description = substr($description, 0, 150)."...";
                }
                break;
            case 5:
                $class = "element-item width2 horizontal-view";
//            $description = false;
                $bg_img = elgg_view('output/img', array('src' =>  $image, 'style' => 'width: 100%'));
                break;
            case 6:
                $class = "";
                break;
            case 7:
                break;
            case 8:
//            $description = false;
                break;
            case 9:
                $limit = 3;
                $class = "bg-color";
                $image = get_video_thumbnail($video->url, 'large');
                $title = '<h2 class="text-truncate margin-0 margin-bottom-10">
                        '.elgg_view('output/url', array(
                        'href' => $video_url,
                        'style' => 'color:white;',
                        'text'  => $video->name,
                        'title' => $video->name
                    )).'
                    </h2>';
                $count = 1;
                $restart_count = true;
                break;
        }
        $bg_img = '<div class="bg-thumb" style="background-image: url(\''.$image.'\')"></div>';
        $video_thumb = elgg_view('output/url', array(
            'href' => $video_url,
            'class' => 'thumb-video',
            'text'  => '<div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div>'.$bg_img,
            'title' => $video->name
        ));
        ?>
        <div data-num="<?php echo $count;?>" class="structure <?php echo $restart_count ? '':'first';?>">
            <div class="video-wrapper <?php echo $class;?>">
                <div class="video-block">
                    <div class="video-preview" style="background-image: url('<?php echo $image;?>');">
                        <?php echo $video_thumb;?>
                    </div>
                </div>
                <div class="video-details">
                    <?php echo $title;?>
                    <div>
                        <?php
                        echo elgg_view('output/url', array(
                            'href' => "videos/".elgg_get_friendly_title($remote_site->name)."/".$remote_site->id,
                            'class' => 'text-truncate site-name',
                            'text'  => $edu->name,
                            'title' => $edu->name,
                        ));
                        ?>
                    </div>
                    <small class="date" style="margin-top: 2px;">
                        <i><?php echo $date;?></i>
                    </small>
                    <?php if($description):?>
                        <p class="margin-top-5">
                            <?php echo elgg_strip_tags($description);?>
                        </p>
                    <?php endif;?>
                    <?php echo elgg_view("global/tags/view", array('tags' => $video->tag_array, 'limit' => $limit)); ?>
                </div>
            </div>
        </div>

        <?php
        $count++;
    endforeach;

    ?>
</div>
<style>
    .tags{
        display: block;
    }
</style>