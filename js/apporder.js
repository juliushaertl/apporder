$(function() {

    var app_menu = $('#apps ul');
    if(!app_menu.length)
        return;
    app_menu.hide();

    // restore existing order
    $.get( "/apps/apporder/ajax/order.php", { requesttoken: oc_requesttoken}, function(data) {
        var json = data.order;
        try {
            var order = JSON.parse( json ).reverse();
        } catch (e) {
            var order = []
        }
        if (order.length==0)
            return;

        available_apps = {};
        app_menu.find('li').each(function() {
            var id =  $(this).find('a').attr('href');
            available_apps[id] = $(this);
        });
        $.each(order,function(order,value) {
            app_menu.prepend(available_apps[value]);
        })
        app_menu.show();
    });

    // make app menu sortable
    $( "#apps ul" ).sortable({
        handle: 'img',
        stop: function( event, ui ) {
            var items = [];
            $("#apps ul").children().each(function(i,el){
                var item = $(el).find('a').attr('href');
                items.push(item)
            })

            var json = JSON.stringify(items);
            localStorage.setItem("apporder-order", json);
            $.get("/apps/apporder/ajax/personal.php", { order: json, requesttoken: oc_requesttoken}, function(data) {});
        }
    });

    // Sorting inside settings
    $( "#appsorter" ).sortable({
        stop: function( event, ui ) {
            var items = []
                $("#appsorter").children().each(function(i,el){
                    var item = $(el).find('a').attr('href');
                    items.push(item)
                })

            var json = JSON.stringify(items);
            $.get( "/apps/apporder/ajax/admin.php", { order: json, requesttoken: oc_requesttoken}, function(data) {});
        }
    });
});
