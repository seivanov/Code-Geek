$().ready(function(){

    console.log('start');

    function pjax_clients_filter(data) {
        $.pjax({
            type: 'POST',
            url: '/admin',
            container: '#gridpjax',
            push: true,
            data: data,
            replace: false,
            timeout: 10000,
            scrollTo: true
        });
    }

    $('.clients').click(function(){
        pjax_clients_filter({ 'ClientsSearch[status]':$(this).attr('status') });
    });

    $('.sort_last_order').click(function(){
        if($(this).attr('sort') == 1) {
            $(this).attr('sort', 0);
            pjax_clients_filter({'ClientsSearch[sortlastorder]': '0'});
        } else {
            $(this).attr('sort', 1);
            pjax_clients_filter({'ClientsSearch[sortlastorder]': '1'});
        }
    });

    $('.search').click(function(){
        pjax_clients_filter({
            'ClientsSearch[fio]':$('.clients_name').val(),
            'ClientsSearch[fromcount]':$('.last_order_from').val(),
            'ClientsSearch[tocount]':$('.last_order_to').val()
        });
    });

});