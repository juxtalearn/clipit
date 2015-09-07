<?php
/**
 * Created by PhpStorm.
 * User: malzahn
 * Date: 26.08.2015
 * Time: 08:49
 */
extract($_GET);


$stumblingblock_lowerthreshold = intval(elgg_get_plugin_setting('stumblingblock_lowerthreshold', 'a04_la_dashboard'));
$stumblingblock_upperthreshold = intval(elgg_get_plugin_setting('stumblingblock_upperthreshold', 'a04_la_dashboard'));

if ($stumblingblock_lowerthreshold <= $stumblingblock_upperthreshold) {
    echo "<head>";
    foreach (elgg_get_loaded_css() as $css) {
        echo "<link rel=\"stylesheet\" href=\"$css\" type=\"text/css\" />";
    }
    echo "</head>";


    echo "<body style='background:none'>";

    if ($scale === ClipitActivity::SUBTYPE) {
        $stumbling_blocks = LADashboardHelper::getStumblingBlocksUsage($activity_id);
        $stumblingblock_upperthreshold *= count(ClipitActivity::get_groups($activity_id)) ;
    } else {
        $stumbling_blocks = LADashboardHelper::getStumblingBlocksUsage($activity_id, $group_id);
    }


    echo "<div class='tags '>";
    foreach ($stumbling_blocks as $blockname => $blockstats) {
        $blockcount = $blockstats['sum'];
        $blockid = $blockstats['id'];

        $link = elgg_view("output/url", array('href'=> elgg_get_site_url().'explore/search'. http_build_query(array('bytag','id'=>$blockid)),
                                            'class'=>null,
                                            'text'=>$blockname,
                                            'target'=>'_parent'));
        if ($blockcount <= $stumblingblock_lowerthreshold) {
            //red
            echo "<div class=\"label label-primary la_stumblingblock red\">$link</div>";
        } else if ($blockcount >= $stumblingblock_upperthreshold) {
            //green
            echo "<div class=\"label label-primary la_stumblingblock green\">$link</div>";

        } else {
            //yellow
            echo "<div class=\"label label-primary la_stumblingblock yellow\">$link</div>";
        }



    }
    echo "</div>";
    echo "</body>";
} else {
    echo elgg_echo('la:dashboard:stumblingblocks:notify_admin');
}

