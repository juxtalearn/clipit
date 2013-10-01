<?php /* Piwik plugin for the Elgg social network engine. */ ?>

<?php
$data = elgg_get_entities(array("types"=>"object", "subtypes"=>"modpiwik", "owner_guids"=> '0' , "order_by"=>"","limit"=>0));
if(isset($data[0])) {
	$entity = $data[0];
	if($entity->showga) {
?>
<script type="text/javascript">
var pkBaseURL = (("https:" == document.location.protocol) ? "https://<?php echo $entity->trackurl; ?>/" : "http://<?php echo $entity->trackurl; ?>/");
document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
</script><script type="text/javascript">
try {
var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", <?php echo $entity->trackid; ?>);

<?php if (get_input('q')){?>
<?php 
$category = false;
if (get_input('entity_subtype', false)){
	$category = get_input('entity_subtype');
}else{
	if (get_input('entity_type', false)){
		$category = get_input('entity_type');
	}		
}
?>
piwikTracker.trackSiteSearch(
		"<?php echo get_input('q')?>", // Search keyword searched for
		<?php if ($category){ ?>"<?php echo $category;?>"<?php }else{?>false<?php }?>, // Search category selected in your search engine. If you do not need this, set to false
		false // Number of results on the Search results page. Zero indicates a 'No Result Search Keyword'. Set to false if you don't know
		);
<?php }else{?>
piwikTracker.setCustomVariable(1, "UserName", "<?php echo (get_loggedin_user()->username); ?>", "page");
piwikTracker.setCustomVariable(2, "UserId", "<?php echo (get_loggedin_user()->guid); ?>", "page");
piwikTracker.trackPageView();
<?php }?>



piwikTracker.enableLinkTracking();
} catch( err ) { }
</script>
<noscript><p><img src="http://<?php echo $entity->trackurl; ?>/piwik.php?idsite=<?php echo $entity->trackid; ?>" style="border:0" alt=""/></p></noscript>
<?php }
	} else {
		if ($_SESSION['user']->admin || $_SESSION['user']->siteadmin) {
			system_message("You've installed the Piwik plugin but you still need to go to the Piwik section from within the admin panel.");
		}
	}
?>
