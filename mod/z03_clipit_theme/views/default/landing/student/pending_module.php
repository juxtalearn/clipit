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
<div class="separator wrapper">
    <span class="point" style="background: #00a99d;"></span>
    <a>Pending task 1</a>
    <small class="pull-right">12:00H, NOV 18, 2013</small>
</div>
<!-- endforeach-->
<!-- foreach-->
<div class="separator wrapper">
    <span class="point" style="background: #ed1e79;"></span>
    1/3 <a>PDF\'s uploaded</a>
    <small class="pull-right">12:00H, NOV 18, 2013</small>
</div>
<!-- endforeach-->
<!-- foreach-->
<div class="separator wrapper">
    <span class="point" style="background: #ed1e79;"></span>
    <a>Pending task 3</a>
    <small class="pull-right">12:00H, NOV 18, 2013</small>
</div>
<!-- endforeach-->
<!-- foreach-->
<div class="separator wrapper">
    <span class="point" style="background: #f7931e;"></span>
    <a>Pending task 4</a>
    <small class="pull-right">12:00H, NOV 18, 2013</small>
</div>
<!-- endforeach-->';

$all_link = elgg_view('output/url', array(
    'href' => "linkHref",
    'text' => elgg_echo('link:view:all'),
    'is_trusted' => true,
));
echo elgg_view('landing/module', array(
    'name'      => "pending",
    'title'     => "Pending",
    'content'   => $content,
    'all_link'  => $all_link,
));
?>

