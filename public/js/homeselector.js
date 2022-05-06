/*
$(".selectcategory").click(function () {
    $(this).parent().find("a.active").removeClass('active');
    $(this).addClass('active');
    let cat = $(this).text();
    if (cat === "All") {
        $(".filterDiv").show();
    } else {
        $(".filterDiv").hide().filter('.' + cat).show();
    }
});
*/


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(".selectcategory").click(function () {

    $(this).parent().find("a.active").removeClass('active');
    $(this).addClass('active');

    let query = $(this).text();

    if (query === "All") {
        query = null;
    } else {
        $.ajax({
            url: baseUrl,
            type: "GET",
            data: {'category': query},
            success: function (data) {
                if (data != '') {
                    $('.filterDiv').html(data);
                }
            }

        })
    }
    // end of ajax call
});
