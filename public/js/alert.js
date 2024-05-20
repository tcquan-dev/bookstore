$(document).on("click", ".btn-delete", function (event) {
    let route = $(this).attr("data-route");
    let entry = $(this).closest("tr");
    swal({
        title: "Are you sure you want to delete this item?",
        icon: "warning",
        buttons: {
            cancel: "Cancel",
            confirm: "Yes",
        },
    }).then((result) => {
        if (result) {
            $.ajax({
                url: route,
                type: "DELETE",
                success: function (response) {
                    if (response) {
                        swal({
                            title: "The item has been deleted!",
                            icon: "success",
                        });
                        entry.remove();
                    } else {
                        swal({
                            title: "Something went wrong!",
                            icon: "error",
                        });
                    }
                },
            });
        }
    });
});
