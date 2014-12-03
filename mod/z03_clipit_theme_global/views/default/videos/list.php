<?php
//elgg_load_js('jquery:isotope');
$videos = elgg_extract('entities', $vars);
?>
<script src="http://masonry.desandro.com/js/masonry-docs.min.js"></script>
<script>
    $( function() {
        // init Isotope
       $('#isotope-demo').masonry({
            columnWidth: 10,
            itemSelector: '.element-item',
        });
    });
</script>
<style>

    /* ---- isotope ---- */

    /* clear fix */
    .isotope:after {
        content: '';
        display: block;
        clear: both;
    }

    /* ---- .element-item ---- */

    .element-item {
        position: relative;
        float: left;
        width: 100px;
        /*height: 100px;*/
        height: auto;
        margin: 5px;
        color: #262524;
    }
    .element-item { width: 35%; }
    .element-item.width2 { width: 60% !important; }
    /*.element-item.height2 { height: 210px; }*/
    .element-item.width3{width: 29%}
    /* Image size */
    .element-item.width3 > a{height: 133px;}
    .element-item.width2 > a{height: 276px;}
    .element-item.height2 > a{height: 160px;}
    .element-item.horizontal-view > a{height: 137px;}
    .element-item.width3 p{
        height: 110px;
    }
    .element-item > * {
        margin: 0;
        padding: 0;
        background: #fff;
    }

    .element-item .symbol {
        position: absolute;
        left: 10px;
        top: 0px;
        font-size: 42px;
        font-weight: bold;
        color: white;
    }
    .element-item h3{
        font-size: 16px;
        letter-spacing: 0.5px;
    }
    .element-item > div{
        padding: 10px;
        border: 1px solid #E6E6E6;
    }
    .element-item p{
        font-size: 12px;
        color: #666;
        letter-spacing: 0.5px;
        line-height: 18px;
    }
    .main-video p{
        color: #ffffff;
    }
</style>
<style>
    .container .content{
        background: transparent !important;
    }
    .main-video .tags{
        margin-top: 20px;
    }
    .main-video .tags a{
        background: transparent;
        border: 1px solid #fff;
        color: white;
    }
    .main-video h2{
        margin-bottom: 5px !important;
        color: white !important;
        letter-spacing: 1px;
    }
    .main-video .bg-play .fa-play-circle-o {
        font-size: 80px !important;
    }
    .main-video > div{
        background: #ff4343;
    }
    .main-video .bg-play>div {
        background: rgba(255, 67, 67, 0.5);
    }
    .main-video .date,
    .yellow-view .date{
        color: #E8E8E8;
    }
    .horizontal-view{
        padding: 0 !important;
        overflow: hidden;
    }
    .horizontal-view .thumb-video{
        float: left;
        width: 50%;
    }
    .horizontal-view > div{
        padding: 0;
        overflow: hidden;
    }
    .horizontal-view > div > div{
          padding: 10px;
          overflow: hidden;
    }
    .yellow-view > div{
        background: #d8ba05;
    }
    .yellow-view h3,
    .yellow-view p{
        color: white;
    }
    .yellow-view .tags a{
        background: transparent;
        border: 1px solid #fff;
        color: white;
    }
    .yellow-view .bg-play>div {
        background: rgba(216, 186, 5, 0.5);
    }
    .date{
        color: #9E9E9E;
    }
</style>
<div id="isotope-demo" class="isotope rainbowed">
    <?php
    $count = 1;
    foreach($videos as $video):
        $video_url = "video/".$video->id."/".elgg_get_friendly_title($video->name);
        $date = date("M d, Y H:i", $video->time_created);
        $class = "element-item height2";
        $text_color = "";
        $image = get_video_thumbnail($video->url, 'normal');
        $description = $video->description;
        switch($count){
            case 1:
                $image = get_video_thumbnail($video->url, 'large');
                break;
            case 3:
                $description = false;
                break;
            case 4:
            case 5:
                $class = "element-item width3";
                break;
            case 6:
                $class = "element-item width2 horizontal-view";
                $description = false;
                break;
            case 7:
                $class = "element-item height2 yellow-view";
                $count = 0;
                $restart_count++;
                break;
        }
//        if($count%1 == 1 || $count%8 == 1){
//            $image = get_video_thumbnail($video->url, 'large');
//        }
//        if($count%2 == 1){
//            $class = "element-item height2";
//        }
//        if($count%3 == 1){
//            $description = false;
//        }
//        if($count%4 == 1){
//            $class = "element-item width3";
//        }
//        if($count%5 == 1){
//            $class = "element-item width3";
//        }
//        if($count%6 == 1){
//            $class = "element-item width2 horizontal-view";
//            $description = false;
//        }
//        if($count%7 == 1){
//            $class = "element-item height2 yellow-view";
//        }
        $video_thumb = elgg_view('output/url', array(
            'href' => $video_url,
            'class' => 'thumb-video',
            'text'  => '<div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div>'.
                elgg_view('output/img',array('src' => $image, 'style' => 'width:100%;')),
            'title' => $video->name
        ));
    ?>
    <?php if($count == 1):?>
    <div class="main-video element-item width2">
        <?php echo $video_thumb;?>
        <div class="white">
                <h2 class="text-truncate margin-0 margin-bottom-10">
                    <?php
                    echo elgg_view('output/url', array(
                        'href' => $video_url,
                        'style' => 'color:white;',
                        'text'  => $video->name,
                        'title' => $video->name
                    ));
                    ?>
                </h2>
                <small class="date"><i><?php echo $date;?></i></small>
                <p class="margin-top-5"><?php echo $description;?></p>
                <div class="tags">
                    <a href="http://www.clipit.es/trials/dcm/explore/search?by=tag&amp;id=79" class="label label-primary" title="Learning Analytics">Learning Analytics</a>
                    <a href="http://www.clipit.es/trials/dcm/explore/search?by=tag&amp;id=79" class="label label-primary" title="Learning Analytics">Moocs</a>
                </div>
            </div>
        </div>
        <?php else:?>
        <div class="<?php echo $class;?>">
            <?php if($count == 6):?>
                <div>
            <?php endif;?>
            <?php echo $video_thumb;?>
            <div>
                <h3 class="margin-0 margin-bottom-5 text-truncate">
                    <?php
                    echo elgg_view('output/url', array(
                        'href' => $video_url,
                        'text'  => $video->name,
                        'style' => 'color: inherit;',
                        'title' => $video->name
                    ));
                    ?>
                </h3>
                <small class="date">
                    <i><?php echo $date;?></i>
                </small>
                <?php if($description):?>
                    <p class="margin-top-5">
                        <?php echo $description;?>
                    </p>
                <?php endif;?>
                <div class="tags">
                    <a href="http://www.clipit.es/trials/dcm/explore/search?by=tag&amp;id=79" class="label label-primary" title="Learning Analytics">Learning Analytics</a>
                    <a href="http://www.clipit.es/trials/dcm/explore/search?by=tag&amp;id=79" class="label label-primary" title="Learning Analytics">Moocs</a>
                </div>
            </div>
            <?php if($count == 6):?>
                </div>
            <?php endif;?>
        </div>
        <?php endif;?>
    <?php
        $count++;
    endforeach;
    ?>
<!--    <div class="element-item height2">-->
<!--        <a class="thumb-video" href="javascript:;">-->
<!--            <div class="bg-play">-->
<!--                <div>-->
<!--                    <i class="fa fa-play-circle-o"></i>-->
<!--                </div>-->
<!--            </div>-->
<!--            <img src="http://img.youtube.com/vi/1aIpoLfotCE/mqdefault.jpg" style="width: 100%;">-->
<!--        </a>-->
<!--        <div>-->
<!--            <h3 class="margin-0 margin-bottom-5 text-truncate">Lorem ipsum dolor sit amet, consectetur adipiscin</h3>-->
<!--            <small class="date">-->
<!--                <i>Nov 18, 2014 12:00</i>-->
<!--            </small>-->
<!--            <p class="margin-top-5">-->
<!--                Lorem ipsum dolor sit amet, consectetur adipiscing elit.-->
<!--                Vivamus ut tortor id leo porttitor aliquam eget at diam. Duis consequat-->
<!--                malesuada orci, eget convallis augue bibendum at.-->
<!--            </p>-->
<!--            <div class="tags">-->
<!--                <a href="http://www.clipit.es/trials/dcm/explore/search?by=tag&amp;id=79" class="label label-primary" title="Learning Analytics">Learning Analytics</a>-->
<!--                <a href="http://www.clipit.es/trials/dcm/explore/search?by=tag&amp;id=79" class="label label-primary" title="Learning Analytics">Moocs</a>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="element-item height2">-->
<!--        <a class="thumb-video" href="javascript:;">-->
<!--            <div class="bg-play">-->
<!--                <div>-->
<!--                    <i class="fa fa-play-circle-o"></i>-->
<!--                </div>-->
<!--            </div>-->
<!--            <img src="http://img.youtube.com/vi/OZod4BGHKv0/mqdefault.jpg" style="width: 100%;">-->
<!--        </a>-->
<!--        <div style="padding: 10px;">-->
<!--            <h3 class="margin-0 margin-bottom-5 text-truncate">Lorem ipsum dolor sit amet, consectetur adipiscin</h3>-->
<!--            <small class="date">-->
<!--                <i>Nov 18, 2014 12:00</i>-->
<!--            </small>-->
<!--            <div class="tags">-->
<!--                <a href="http://www.clipit.es/trials/dcm/explore/search?by=tag&amp;id=79" class="label label-primary" title="Learning Analytics">Learning Analytics</a>-->
<!--                <a href="http://www.clipit.es/trials/dcm/explore/search?by=tag&amp;id=79" class="label label-primary" title="Learning Analytics">Moocs</a>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="element-item height2" style="width: 29%;">-->
<!--        <a class="thumb-video" href="javascript:;">-->
<!--            <div class="bg-play">-->
<!--                <div>-->
<!--                    <i class="fa fa-play-circle-o"></i>-->
<!--                </div>-->
<!--            </div>-->
<!--            <img src="http://img.youtube.com/vi/PjCs6ncn9-M/mqdefault.jpg" style="width: 100%;">-->
<!--        </a>-->
<!--        <div>-->
<!--            <h3 class="margin-0 margin-bottom-5 text-truncate">Lorem ipsum dolor sit amet, consectetur adipiscin</h3>-->
<!--            <small class="date">-->
<!--                <i>Nov 18, 2014 12:00</i>-->
<!--            </small>-->
<!--            <p class="margin-top-5">-->
<!--                Lorem ipsum dolor sit amet, consectetur adipiscing elit.-->
<!--                Vivamus ut tortor id leo porttitor aliquam eget at diam. Duis consequat-->
<!--                malesuada orci, eget convallis augue bibendum at.-->
<!--            </p>-->
<!--            <div class="tags">-->
<!--                <a href="http://www.clipit.es/trials/dcm/explore/search?by=tag&amp;id=79" class="label label-primary" title="Learning Analytics">Learning Analytics</a>-->
<!--                <a href="http://www.clipit.es/trials/dcm/explore/search?by=tag&amp;id=79" class="label label-primary" title="Learning Analytics">Moocs</a>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="element-item height2" style="width: 29%;">-->
<!--        <a class="thumb-video" href="javascript:;">-->
<!--            <div class="bg-play">-->
<!--                <div>-->
<!--                    <i class="fa fa-play-circle-o"></i>-->
<!--                </div>-->
<!--            </div>-->
<!--            <img src="http://img.youtube.com/vi/93S1p4hXzow/mqdefault.jpg" style="width: 100%;">-->
<!--        </a>-->
<!--        <div>-->
<!--            <h3 class="margin-0 margin-bottom-5 text-truncate">Lorem ipsum dolor sit amet, consectetur adipiscin</h3>-->
<!--            <small class="date">-->
<!--                <i>Nov 18, 2014 12:00</i>-->
<!--            </small>-->
<!--            <p class="margin-top-5">-->
<!--                Lorem ipsum dolor sit amet, consectetur adipiscing elit.-->
<!--                Vivamus ut tortor id leo porttitor aliquam eget at diam. Duis consequat-->
<!--                malesuada orci, eget convallis augue bibendum at.-->
<!--            </p>-->
<!--            <div class="tags">-->
<!--                <a href="http://www.clipit.es/trials/dcm/explore/search?by=tag&amp;id=79" class="label label-primary" title="Learning Analytics">Learning Analytics</a>-->
<!--                <a href="http://www.clipit.es/trials/dcm/explore/search?by=tag&amp;id=79" class="label label-primary" title="Learning Analytics">Moocs</a>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="element-item height2 yellow-view">-->
<!--        <a class="thumb-video" href="javascript:;">-->
<!--            <div class="bg-play">-->
<!--                <div>-->
<!--                    <i class="fa fa-play-circle-o"></i>-->
<!--                </div>-->
<!--            </div>-->
<!--            <img src="http://img.youtube.com/vi/WzPCLQauVyY/mqdefault.jpg" style="width: 100%;">-->
<!--        </a>-->
<!--        <div>-->
<!--            <h3 class="margin-0 margin-bottom-5 text-truncate">Lorem ipsum dolor sit amet, consectetur adipiscin</h3>-->
<!--            <small class="date">-->
<!--                <i>Nov 18, 2014 12:00</i>-->
<!--            </small>-->
<!--            <p class="margin-top-5">-->
<!--                Lorem ipsum dolor sit amet, consectetur adipiscing elit.-->
<!--                Vivamus ut tortor id leo porttitor aliquam eget at diam. Duis consequat-->
<!--                malesuada orci, eget convallis augue bibendum at.-->
<!--            </p>-->
<!--            <div class="tags">-->
<!--                <a href="http://www.clipit.es/trials/dcm/explore/search?by=tag&amp;id=79" class="label label-primary" title="Learning Analytics">Learning Analytics</a>-->
<!--                <a href="http://www.clipit.es/trials/dcm/explore/search?by=tag&amp;id=79" class="label label-primary" title="Learning Analytics">Moocs</a>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="element-item width2">-->
<!--        <div class="horizontal-view">-->
<!---->
<!--            <a class="thumb-video" href="javascript:;" style="float: left;width: 50%;">-->
<!--                <div class="bg-play">-->
<!--                    <div>-->
<!--                        <i class="fa fa-play-circle-o"></i>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <img src="http://img.youtube.com/vi/61qqwT1Bk7M/maxresdefault.jpg" style="width: 100%;">-->
<!--            </a>-->
<!--            <div style="padding: 10px;overflow: hidden;">-->
<!--                <h3 class="margin-0 margin-bottom-5 text-truncate">Lorem ipsum dolor sit amet, consectetur adipiscin</h3>-->
<!--                <small class="date">-->
<!--                    <i>Nov 18, 2014 12:00</i>-->
<!--                </small>-->
<!--                <div class="tags">-->
<!--                    <a href="http://www.clipit.es/trials/dcm/explore/search?by=tag&amp;id=79" class="label label-primary" title="Learning Analytics">Learning Analytics</a>-->
<!--                    <a href="http://www.clipit.es/trials/dcm/explore/search?by=tag&amp;id=79" class="label label-primary" title="Learning Analytics">Moocs</a>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
</div>
