$(function () {

	var app_menu = $('#appmenu');
	if (!app_menu.length)
		return;

	app_menu.hide();

	var mapMenu = function(parent, order, hidden) {
		available_apps = {};
		parent.find('li').each(function () {
			var id = $(this).find('a').attr('href');
			if(hidden.includes(id)){
				$(this).hide();
			}
			available_apps[id] = $(this);
		});
		$.each(order, function (order, value) {
			parent.prepend(available_apps[value]);
		});
	};

	var order_request = $.get(OC.generateUrl('/apps/apporder/getOrder'));
	var hidden_request = $.get(OC.generateUrl('/apps/apporder/getHidden'));

	// restore existing order 
	$.when(order_request, hidden_request).done(function (order_data, hidden_data) {
		var order_json = order_data[0].order;
		var hidden_json = hidden_data[0].hidden;
		var order = [];
		var hidden = [];
		try {
			order = JSON.parse(order_json).reverse();
		} catch (e) {
			order = [];
		}
		try {
			hidden = JSON.parse(hidden_json);
		} catch (e) {
			hidden = [];
		}

		if (order.length === 0) {
			app_menu.show();
			return;
		}
		mapMenu($('#appmenu'), order, hidden);
		mapMenu($('#apps').find('ul'), order, hidden);
		app_menu.show();
	});

	// Sorting inside settings
	$("#appsorter").sortable({
		forcePlaceholderSize: true,
		placeholder: 'placeholder',
		stop: function (event, ui) {
			var items = [];
			var url;
			var type = $('#appsorter').data('type');
			console.log(type);
			if(type === 'admin') {
				url = OC.generateUrl('/apps/apporder/saveDefaultOrder');
			} else {
				url = OC.generateUrl('/apps/apporder/savePersonal');
			}
			$("#appsorter").children().each(function (i, el) {
				var item = $(el).find('a').attr('href');
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

	$(".apporderhidden").change(function(){
		var hiddenList = [];
		var url;
		var type = $("#appsorter").data("type");

		if(type === 'admin') {
			url = OC.generateUrl('/apps/apporder/saveDefaultHidden');
		} else {
			url = OC.generateUrl('/apps/apporder/savePersonalHidden');
		}

		$(".apporderhidden").each(function(i, el){
			if(!el.checked){
				hiddenList.push($(el).siblings('a').attr('href'))
			}
		});

		var json = JSON.stringify(hiddenList);
		$.post(url, {
			hidden: json
		}, function (data) {
			//$(event.srcElement).effect("highlight", {}, 1000);
		});
	});
});
