<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 6/02/14
 * Time: 12:37
 * To change this template use File | Settings | File Templates.
 */


/*$all_link = elgg_view('output/url', array(
    'href' => "linkHref",
    'text' => elgg_echo('link:view:all'),
    'is_trusted' => true,
));*/
$tags = ClipitTag::get_all(10);
$content = elgg_view("tricky_topic/tags/tag_cloud", array('tags' => $tags));
echo elgg_view('landing/module', array(
    'name'      => "tags",
    'title'     => "Tags",
    'content'   => $content,
    'all_link'  => $all_link,
));
