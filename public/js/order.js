$(document).on("click", "#form-submit-btn", function () {
    let formData = $(".address-form").serialize();
    let checked = $("#default").is(":checked");
    let cartId = $(this).data("cart-id");

    formData += "&default=" + (checked ? 1 : 0);

    $.ajax({
        url: "/addresses",
        type: "POST",
        data: formData,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            if (response.success) {
                $.ajax({
                    url: "/carts/" + cartId,
                    type: "PUT",
                    data: {
                        address_id: response.address_id,
                    },
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    success: function (response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            swal("Error", response.message, "error");
                        }
                    },
                });
            } else {
                swal("Error", response.message, "error");
            }
        },
    });
});

$(document).on("click", "#order-submit-btn", function () {
    let formData = $(".order-form").serialize();
    let cartId = $(this).data("cart-id");
    console.log(cartId);

    $.ajax({
        url: "/orders",
        type: "POST",
        data: formData,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            if (response.success) {
                swal("Success", response.message, "success").then((result) => {
                    if (result) {
                        window.location.href = "/orders";
                    }
                });
            } else {
                swal("Error", response.message, "error");
            }
        },
    });
});

$(document).on("click", "#address-submit-btn", function () {
    let addressId = $("input[name='address_id']:checked").val();
    let cartId = $(this).data("cart-id");

    $.ajax({
        url: "/carts/" + cartId,
        type: "PUT",
        data: {
            address_id: addressId,
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            if (response.success) {
                location.reload();
            } else {
                swal("Error", response.message, "error");
            }
        },
    });
});
