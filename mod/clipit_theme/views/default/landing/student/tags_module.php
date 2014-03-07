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
    <ul class="tag-cloud">
        <li><a style="color: #f7931e;border-color: #f7931e" href="#">Lorem</a></li>
        <li><a style="color: #ed1e79;border-color: #ed1e79" href="#">amet</a></li>
        <li><a style="color: #f7931e;border-color: #f7931e" href="#">sed do eiusmod</a></li>
        <li><a style="color: #00a99d;border-color: #00a99d" href="#">mollit</a></li>
        <li><a style="color: #ed1e79;border-color: #ed1e79" href="#">Lorem</a></li>
        <li><a style="color: #f7931e;border-color: #f7931e" href="#">Lorem</a></li>
        <li><a style="color: #ed1e79;border-color: #ed1e79" href="#">Lorem</a></li>
        <li><a style="color: #00a99d;border-color: #00a99d" href="#">Lorem</a></li>
        <li><a style="color: #f7931e;border-color: #f7931e" href="#">mollit</a></li>
        <li><a style="color: #ed1e79;border-color: #ed1e79" href="#">Lorem</a></li>
        <li><a style="color: #f7931e;border-color: #f7931e" href="#">voluptate velit </a></li>
        <li><a style="color: #f7931e;border-color: #f7931e" href="#">mollit</a></li>
        <li><a style="color: #ed1e79;border-color: #ed1e79" href="#">consequat</a></li>
        <li><a style="color: #ed1e79;border-color: #ed1e79" href="#">Lorem</a></li>
        <li><a style="color: #00a99d;border-color: #00a99d" href="#">mollit</a></li>
    </ul>
</div>
<!-- endforeach-->';

$all_link = elgg_view('output/url', array(
    'href' => "linkHref",
    'text' => elgg_echo('link:view:all'),
    'is_trusted' => true,
));
echo elgg_view('landing/module', array(
    'name'      => "tags",
    'title'     => "Tags",
    'content'   => $content,
    'all_link'  => $all_link,
));
