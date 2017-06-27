$(function () {

	var app_menu = $('#appmenu');
	if (!app_menu.length)
		return;

	app_menu.css('opacity', '0');

	var mapMenu = function(parent, order) {
		available_apps = {};
		parent.find('li').each(function () {
			var id = $(this).find('a').attr('href');
			available_apps[id] = $(this);
		});
		$.each(order, function (order, value) {
			parent.prepend(available_apps[value]);
		});
	};

	// restore existing order
	$.get(OC.generateUrl('/apps/apporder/getOrder'), function (data) {
		var json = data.order;
		var order = [];
		try {
			order = JSON.parse(json).reverse();
		} catch (e) {
			order = [];
		}
		if (order.length === 0) {
			app_menu.show();
			return;
		}
		mapMenu($('#appmenu'), order);
		mapMenu($('#apps').find('ul'), order);
		$(window).trigger('resize');
		app_menu.css('opacity', '1');

	});

	// Sorting inside settings
	$("#appsorter").sortable({
		forcePlaceholderSize: true,
		placeholder: 'placeholder',
		stop: function (event, ui) {
			var items = [];
			var url;
			var type = $('#appsorter').data('type');
			if(type === 'admin') {
				url = OC.generateUrl('/apps/apporder/saveDefaultOrder');
			} else {
				url = OC.generateUrl('/apps/apporder/savePersonal');
			}
			$("#appsorter").children().each(function (i, el) {
				var item = $(el).find('p').data("url");
				items.push(item)
			});
			var json = JSON.stringify(items);
			$.post(url, {
				order: json
			}, function (data) {
				$(event.srcElement).effect("highlight", {}, 1000);
			});
		}
	});
});
