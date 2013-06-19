//<script>

elgg.provide('elgg.river');

elgg.river.init = function() {

	var riverList = $('.elgg-sync.elgg-list-river');
	var time = 20000;
	if (!window.rivertimer) {
		window.rivertimer = true;
		var refresh_river = window.setTimeout(function(){
			elgg.river.timedRefresh(riverList);
		}, time);
	}
};

elgg.river.timedRefresh = function(object) {
	var first = $('li.elgg-item:first', object);
	if (!first.length) {
		first = object;
	}
	var time = first.data('timestamp');

	elgg.getJSON('activity', {
		data : {
			sync : 'new',
			time : time,
			options : object.data('options')
		},
		success : function(output) {
			if (output) {
				$.each(output, function(key, val) {
					var new_item = $(val).hide();
					object.prepend(new_item.fadeIn(1000));
				});
			}
			window.rivertimer = false;
			elgg.trigger_hook('success', 'elgg:river:ajax');
		}
	});
}
elgg.register_hook_handler('init', 'system', elgg.river.init);
elgg.register_hook_handler('success', 'elgg:river:ajax', elgg.river.init, 500);
