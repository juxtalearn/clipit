//<script>

$(document).ready(function() {

	var target = $("#target");

	$("#select-context").multiselect({
		noneSelectedText: "<?php echo elgg_echo("river_addon:select:context"); ?>",
		selectedText: '# <?php echo elgg_echo("river_addon:select:selected"); ?>',
		checkAllText: "<?php echo elgg_echo("river_addon:select:check"); ?>",
		uncheckAllText: "<?php echo elgg_echo("river_addon:select:uncheck"); ?>",
		selectedList: 2	  
	})
	
	$("#select-context").multiselect().bind("multiselectclick multiselectcheckall multiselectuncheckall", 
	function( event, ui ){
		var checkedValues = $.map($(this).multiselect("getChecked"), function( input ){			
			return input.value;
		});
		elgg.action('river_addon/context', {
			dataType:'json',
			data:{
				selected: checkedValues.join(',')
			}
		});
		if (checkedValues.length) {
			target.addClass("sidebar").html(checkedValues.join(', '));
		} else {
			target.removeClass("sidebar").html("<?php echo elgg_echo("river_addon:select:none"); ?>");
		}
	}).triggerHandler("multiselectclick");
});

elgg.provide('elgg.river_addon.settings');

elgg.river_addon.settings.init = function () {

	$('#elgg-module-list').sortable({
		items:		'li',
		handle:		'.elgg-handle',
		opacity:	0.6,
		revert: 	400,
		update:		elgg.river_addon.settings.movemodule
	});
}
 
elgg.river_addon.settings.movemodule = function(event, ui) {

	var postData = $('#elgg-module-list').sortable('toArray');
	var postStr = postData.join(',');

	elgg.action('river_addon/reorder', {
		moduleorder: postStr
	});
	
}
elgg.register_hook_handler('init', 'system', elgg.river_addon.settings.init, 1000);
