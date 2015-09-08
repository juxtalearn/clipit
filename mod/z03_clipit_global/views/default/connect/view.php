<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   24/10/2014
 * Last update:     24/10/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entities = elgg_extract('entities', $vars);
?>
<h1 style="opacity: 0.7;" class="margin-0"><?php echo elgg_echo('sites');?></h1>
<h3 class="margin-0 margin-bottom-10 margin-top-20"><?php echo elgg_echo('educational:centers');?></h3>
<hr class="margin-0" style="border-top: 1px solid #E2E2E2;margin-bottom: 10px;">
<div class="row">
    <ul>
    <?php
    foreach($entities as $edu):
    ?>
        <li class="list-item overflow-hidden col-md-6" style="padding-left: 10px;border-left:5px solid #ff4343">
        <div class="content-block">
            <div class="pull-right">
                <?php echo elgg_view('output/url', array(
                    'href' => $edu->url,
                    'class' => 'btn btn-xs btn-primary',
                    'text'  => elgg_echo('connect'),
                    'title' => elgg_echo('connect')
                ));
                ?>
            </div>
            <strong>
                <?php echo $edu->name;?>
            </strong>
            <div class="margin-top-5">
                <?php echo elgg_view('output/url', array(
                    'href' => "videos/".elgg_get_friendly_title($edu->name)."/".$edu->id,
                    'text'  => '<i class="fa fa-youtube-play"></i> '.elgg_echo('videos:view_all'),
                    'title' => elgg_echo('videos:view_all')
                ));
                ?>
            </div>
        </div>
        </li>
    <?php endforeach;?>
    </ul>
</div>