<?php
/**
 *
 * River addon river wire js
 *
 */

if (0) { ?><script><?php }

?>

elgg.provide('elgg.river_addon');

elgg.river_addon.init = function() {
	var form = $('form[name=elgg-wire]');
	form.find('input[type=submit]').live('click', elgg.river_addon.submit);
};

elgg.river_addon.submit = function(e) {
	var form = $(this).parents('form');
	var data = form.serialize();

	elgg.action('river_addon/add', {
		data: data,
		success: function(json) {

			var river = $('.elgg-list-river');
						
			if (river.length < 1) {
				river.append(json.output);
			} else {								
				$(json.output).find('li:first').hide().prependTo(river).slideDown(500);
			};
			
			form.find('textarea').val('');
			$("#thewire-characters-remaining span").html("140");
		}
	});
	e.preventDefault();
};
elgg.register_hook_handler('init', 'system', elgg.river_addon.init);
