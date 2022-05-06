$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

const baseUrl = window.location.origin
    ? window.location.origin + '/'
    : window.location.protocol + '/' + window.location.host + '/';

$(document).ready(function () {

    $('#search').on('keyup', function () {

        const query = $(this).val();
        if (query === '') {
            $('#product_list').html('');
        }
        $.ajax({
            url: baseUrl + "search",
            type: "GET",
            data: {'name': query},
            success: function (data) {
                if (data != '') {
                    $('#product_list').html(data);
                }
            }

        })
        // end of ajax call
    });

    $("#search").focusin(function () {
        $('#product_list').addClass('show');
    });

    $("#search").focusout(function () {
        window.setTimeout(function () {
            $('#product_list').removeClass('show');
        }, 100);
    });

    function askForApproval(title, text, url) {
        if(Notification.permission === "granted") {
            createNotification(title, text, '/img/ripperoni-1.png', url);
        }
        else {
            Notification.requestPermission(permission => {
                if(permission === 'granted') {
                    createNotification(title, text, baseUrl + '/img/ripperoni-1.png', url)
                }
            });
        }
    }

    function createNotification(title, text, icon, url) {
        console.log('here');
        const noti = new Notification(title, {
            body: text,
            icon
        });

        noti.onclick = function() {
            if (url) {
                window.location.href = url;
            }
        }
    }

    // askForApproval('Once', 'Once');
    setInterval(function () {
        $.ajax({
            url: baseUrl + "notifications",
            type: "GET",
            success: function (data) {
                messages = JSON.parse(data)
                if (messages.length !== 0) {
                    messages.forEach(function(message) {
                        data = message.data;
                        console.log(message);
                        if (data.status) {
                            askForApproval('Order Status Updated', `Order n. ${data.order}: ${data.status}`, data.url);
                        }
                        if (data.type === 'forCustomer'){
                            askForApproval('Checkout Confirmed', `The new order it's added lo the list (id ${data.order})`, data.url);
                        }
                        if (data.type === 'forSeller'){
                            askForApproval('New Order Received', `n. ${data.order}`, data.url);
                        }
                    });
                    // askForApproval('10', 'ciao');
                }
            }
        })
    }, 1000);

});
