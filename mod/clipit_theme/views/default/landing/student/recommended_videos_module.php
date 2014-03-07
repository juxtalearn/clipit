<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 6/02/14
 * Time: 12:37
 * To change this template use File | Settings | File Templates.
 */
$content = '
<!-- foreach-->
<div class="wrapper separator">
    <a href=""><img src="http://img.youtube.com/vi/bQVoAWSP7k4/2.jpg" class="pull-left"></a>
    <div class="text">
        <h5 class="text-truncate"><a>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</a></h5>
        <small>12:00H, NOV 18, 2013</small>
        <div class="sbs">
            <p style="color: #00a99d;border-color: #00a99d;"><a>SB</a></p>
            <p style="color: #00a99d;border-color: #00a99d;"><a>Lorem ipsum</a></p>
            <a style="color: #00a99d;" class="more-sbs fa fa-plus"></a>
        </div>
    </div>
</div>
<!-- endforeach-->
<!-- foreach-->
<div class="wrapper separator">
    <a href=""><img src="http://b.vimeocdn.com/ts/432/509/432509421_640.jpg" class="pull-left"></a>
    <div class="text">
        <h5 class="text-truncate"><a>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</a></h5>
        <small>12:00H, NOV 18, 2013</small>
        <div class="sbs">
            <p style="color: #ed1e79;border-color: #ed1e79;"><a>SB</a></p>
            <p style="color: #ed1e79;border-color: #ed1e79;"><a>Lorem ipsum</a></p>
            <a style="color: #ed1e79;" class="more-sbs fa fa-plus"></a>
        </div>
    </div>
</div>
<!-- endforeach-->
<!-- foreach-->
<div class="wrapper separator">
    <a href=""><img src="http://b.vimeocdn.com/ts/457/585/457585184_640.jpg" class="pull-left"></a>
    <div class="text">
        <h5 class="text-truncate"><a>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</a></h5>
        <small>12:00H, NOV 18, 2013</small>
        <div class="sbs">
            <p style="color: #00a99d;border-color: #00a99d;"><a>SB</a></p>
            <p style="color: #00a99d;border-color: #00a99d;"><a>Lorem ipsum</a></p>
            <a style="color: #00a99d;" class="more-sbs fa fa-plus"></a>
        </div>
    </div>
</div>
<!-- endforeach-->';

$all_link = elgg_view('output/url', array(
    'href' => "linkHref",
    'text' => elgg_echo('link:view:all'),
    'is_trusted' => true,
));
echo elgg_view('landing/module', array(
    'name'      => "recommended_videos",
    'title'     => "Recommended Videos",
    'content'   => $content,
    'all_link'  => $all_link,
));
?>

