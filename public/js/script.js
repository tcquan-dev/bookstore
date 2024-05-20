$(document).ready(function () {
    "use strict";

    var searchPopup = function () {
        // open search box
        $("#header-nav").on("click", ".search-button", function (e) {
            $(".search-popup").toggleClass("is-visible");
        });

        $("#header-nav").on("click", ".btn-close-search", function (e) {
            $(".search-popup").toggleClass("is-visible");
        });

        $(".search-popup-trigger").on("click", function (b) {
            b.preventDefault();
            $(".search-popup").addClass("is-visible"),
                setTimeout(function () {
                    $(".search-popup").find("#search-popup").focus();
                }, 350);
        }),
            $(".search-popup").on("click", function (b) {
                ($(b.target).is(".search-popup-close") ||
                    $(b.target).is(".search-popup-close svg") ||
                    $(b.target).is(".search-popup-close path") ||
                    $(b.target).is(".search-popup")) &&
                    (b.preventDefault(), $(this).removeClass("is-visible"));
            }),
            $(document).keyup(function (b) {
                "27" === b.which &&
                    $(".search-popup").removeClass("is-visible");
            });
    };

    var countdownTimer = function () {
        function getTimeRemaining(endtime) {
            const total = Date.parse(endtime) - Date.parse(new Date());
            const seconds = Math.floor((total / 1000) % 60);
            const minutes = Math.floor((total / 1000 / 60) % 60);
            const hours = Math.floor((total / (1000 * 60 * 60)) % 24);
            const days = Math.floor(total / (1000 * 60 * 60 * 24));
            return {
                total,
                days,
                hours,
                minutes,
                seconds,
            };
        }

        function initializeClock(id, endtime) {
            const clock = document.getElementById(id);
            const daysSpan = clock.querySelector(".days");
            const hoursSpan = clock.querySelector(".hours");
            const minutesSpan = clock.querySelector(".minutes");
            const secondsSpan = clock.querySelector(".seconds");

            function updateClock() {
                const t = getTimeRemaining(endtime);
                daysSpan.innerHTML = t.days;
                hoursSpan.innerHTML = ("0" + t.hours).slice(-2);
                minutesSpan.innerHTML = ("0" + t.minutes).slice(-2);
                secondsSpan.innerHTML = ("0" + t.seconds).slice(-2);
                if (t.total <= 0) {
                    clearInterval(timeinterval);
                }
            }
            updateClock();
            const timeinterval = setInterval(updateClock, 1000);
        }

        $("#countdown-clock").each(function () {
            const deadline = new Date(
                Date.parse(new Date()) + 28 * 24 * 60 * 60 * 1000
            );
            initializeClock("countdown-clock", deadline);
        });
    };

    $(document).on("click", "#button-plus", function () {
        var $parent = $(this).closest(".row.align-items-center");
        var price = parseFloat($parent.find("#price-value").val());
        var $quantityInput = $parent.find(".quantity-input");
        var quantity = parseInt($quantityInput.val());

        quantity++;
        $quantityInput.val(quantity);

        var total = price * quantity;
        $parent.find(".total").text(numberWithCommas(total) + " VNĐ");
    });

    $(document).on("click", "#button-minus", function () {
        let card = $(this).closest(".card");
        let $parent = $(this).closest(".row.align-items-center");
        let price = parseFloat($parent.find("#price-value").val());
        let $quantityInput = $parent.find(".quantity-input");
        let quantity = parseInt($quantityInput.val());

        if (quantity > 1) {
            quantity--;
            $quantityInput.val(quantity);

            let total = price * quantity;
            $parent.find(".total").text(numberWithCommas(total) + " VNĐ");
        } else {
            swal({
                title: "Bạn chắc chắn muốn bỏ sản phẩm này?",
                text: "Hành động này không thể hoàn tác!",
                icon: "warning",
                buttons: {
                    cancel: "Hủy",
                    confirm: "Có",
                },
            }).then((result) => {
                if (result) {
                    card.remove();
                }
            });
        }
    });

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    $(document).on("click", "#submit-btn", function () {
        let formData = $(".address-form").serialize();
        let checked = $("#default").is(":checked");

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
                    swal("Success", response.message, "success");
                    $("#addressModal").modal("hide");
                    $("#content-toggle").html(response.html);
                    $("#list-address")
                        .removeClass("fade")
                        .addClass("show")
                        .fadeIn();
                } else {
                    swal("Error", response.message, "error");
                }
            },
        });
    });

    $(document).on("click", ".delete-btn", function () {
        let card = $(this).closest(".card");
        let addressId = card.data("address-id");

        swal({
            title: "Bạn có chắc chắn muốn xóa?",
            text: "Hành động này không thể hoàn tác!",
            icon: "warning",
            buttons: {
                cancel: "Hủy",
                confirm: "Có",
            },
        }).then((result) => {
            if (result) {
                $.ajax({
                    url: "/addresses/" + addressId,
                    type: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    success: function (response) {
                        if (response.success) {
                            swal("Success", response.message, "success");
                            card.remove();
                        } else {
                            swal("Error", response.message, "error");
                        }
                    },
                });
            }
        });
    });

    $(document).on("click", "#update-btn", function () {
        let card = $(this).closest(".card");
        let addressId = card.data("address-id");

        $.ajax({
            url: "/addresses/" + addressId,
            type: "GET",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                if (response.success) {
                    $("#addressModal .modal-content").html(response.form);
                } else {
                    swal("Error", response.message, "error");
                }
            },
        });
    });

    $(document).on("click", "#update-submit-btn", function () {
        let addressId = $(this).data("address-id");
        let formData = $(".address-form").serialize();
        let checked = $("#default").is(":checked");

        formData += "&default=" + (checked ? 1 : 0);

        $.ajax({
            url: "/addresses/" + addressId,
            type: "PUT",
            data: formData,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                if (response.success) {
                    swal("Success", response.message, "success");
                    $("#addressModal").modal("hide");
                    $("#content-toggle").html(response.html);
                    $("#list-address")
                        .removeClass("fade")
                        .addClass("show")
                        .fadeIn();
                } else {
                    swal("Error", response.message, "error");
                }
            },
        });
    });

    $(document).on("change", "#avatar-input", function () {
        let file = this.files[0];
        let reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById("avatar-preview").src = e.target.result;
        };
        reader.readAsDataURL(file);
    });

    $(".banner-items").owlCarousel({
        items: 1,
        loop: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
    });

    $(".selling-items").owlCarousel({
        items: 3,
        loop: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
    });

    $(".review-items").owlCarousel({
        items: 3,
        loop: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
    });

    searchPopup();
    countdownTimer();
});
