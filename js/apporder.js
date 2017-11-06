$(function () {

	var app_menu = $('#appmenu');
	if (!app_menu.length)
		return;

	app_menu.css('opacity', '0');

	var mapMenu = function(parent, order, hidden) {
		available_apps = {};
		parent.find('li').each(function () {
			var id = $(this).find('a').attr('href');
			if(hidden.indexOf(id) > -1){
				$(this).remove(); 
			}
			available_apps[id] = $(this);
		});

		//Remove hidden from order array
		order = order.filter(function(e){ 
			return !(hidden.indexOf(e) > -1);
		})
		$.each(order, function (order, value) {
			parent.prepend(available_apps[value]);
		});
	};

	// restore existing order 
	$.get(OC.generateUrl('/apps/apporder/getOrder'),function(data){
		var order_json = data.order;
		var hidden_json = data.hidden;
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
			app_menu.css('opacity', '1');
			return;
		}

		mapMenu($('#appmenu'), order, hidden);
		mapMenu($('#apps').find('ul'), order, hidden);
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
				hiddenList.push($(el).siblings('p').attr('data-url'))
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
