<?php
/**
 * Created by PhpStorm.
 * User: malzahn
 * Date: 26.08.2015
 * Time: 08:49
 */
extract($_GET);


$stumbling_blocks = LADashboardHelper::getStumblingBlocksFromActivity($activity_id);

echo "<head>";
foreach(elgg_get_loaded_css() as $css) {
    echo "<link rel=\"stylesheet\" href=\"$css\" type=\"text/css\" />";
}
echo "</head>";


echo "<body style='background:none'>";

$stumbling_blocks = LADashboardHelper::getStumblingBlocksUsage($activity_id,$group_id);
echo "<div class='tags '>";
foreach ($stumbling_blocks as $blockname => $blockcount) {
    if ( $blockcount < 5) {
        //red
        echo "<div class=\"label label-primary la_stumblingblock red\">$blockname: $blockcount</div>";
    } else if ($blockcount < 9) {
        //yellow
        echo "<div class=\"label label-primary la_stumblingblock yellow\">$blockname: $blockcount</div>";
    } else if ($blockcount >8) {
        //green
        echo "<div class=\"label label-primary la_stumblingblock green\">$blockname: $blockcount</div>";
    }

}
echo "</div>";



echo "</body>";
