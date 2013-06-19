<?php

	$tweetcount = elgg_get_plugin_setting('tweetcount', 'river_addon');

	$subtype = 'tweet';
	
echo "<div class=\"elgg-module elgg-module-aside\">";
	echo "<div class=\"elgg-head\"><h3>" . elgg_echo('river_addon:label:info') . "</h3></div>";
	echo "<div class='elgg-body'>";			
		echo "<div class='tickerclass'>";
			echo "<ul>";
			for($id = 1; $id <= $tweetcount; $id++) {
				echo "<li>";
				echo elgg_echo("river_addon:$subtype:$id");
				echo "</li>";
			}
			echo "</ul>";
		echo "</div>";
	echo "</div>";
echo "</div>";

?>

<script type="text/javascript">
$(document).ready(function(){	
	var sudoSlider = $(".tickerclass").sudoSlider({
		speed: 1000, 
        prevNext: false,
        fade: false,
		vertical:true,
        continuous:true,
        auto:true,
		pause: 10000
    });
});
</script>

