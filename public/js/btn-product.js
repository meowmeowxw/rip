$("#btn-minus").click(function () {
    let quantity = parseInt($('#quantityCart').val());
    if (quantity > 1) {
        $('#quantityCart').val(quantity - 1);
    }
});

$("#btn-plus").click(function () {
    let quantity = parseInt($('#quantityCart').val());
    $('#quantityCart').val(quantity + 1);
});
