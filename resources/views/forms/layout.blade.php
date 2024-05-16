<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ backpack_theme_config('html_direction') }}">

<head>
    <link rel="stylesheet" href="{{ url('css/form.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    @include(backpack_view('inc.head'))
</head>

<body class="app flex-row align-items-center">

    @yield('header')

    <div class="container">
        @yield('content')
    </div>

    @include(backpack_view('inc.scripts'))
    @include(backpack_view('inc.theme_scripts'))
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script>
        var csrfToken = "{{ csrf_token() }}";

        $(document).on('click', '#submit-btn', function() {
            var formData = $('.address-form').serialize();
            var checked = $('#default').is(':checked');

            formData += '&default=' + (checked ? 1 : 0);

            $.ajax({
                url: '/addresses',
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    if (response.success) {
                        swal("Success", response.message, "success");
                        $('#addressModal').modal('hide');
                        $('#content-toggle').html(response.html);
                        $('#list-address').removeClass('fade').addClass('show').fadeIn();
                    } else {
                        swal("Error", response.message, "error");
                    }
                }
            });
        });

        $(document).on('click', '.delete-btn', function() {
            var card = $(this).closest('.card');
            var addressId = card.data('address-id');

            swal({
                title: 'Bạn có chắc chắn muốn xóa?',
                text: 'Hành động này không thể hoàn tác!',
                icon: 'warning',
                buttons: {
                    cancel: "Hủy",
                    confirm: "Có"
                }
            }).then((result) => {
                if (result) {
                    $.ajax({
                        url: '/addresses/' + addressId,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function(response) {
                            if (response.success) {
                                swal("Success", response.message, "success");
                                card.remove();
                            } else {
                                swal("Error", response.message, "error");
                            }
                        }
                    });
                }
            });
        });

        $(document).on('click', '#update-btn', function() {
            var card = $(this).closest('.card');
            var addressId = card.data('address-id');

            $.ajax({
                url: '/addresses/' + addressId,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    if (response.success) {
                        $('#addressModal .modal-content').html(response.form);
                    } else {
                        swal("Error", response.message, "error");
                    }
                }
            });
        });

        $(document).on('click', '#update-submit-btn', function() {
            var addressId = $(this).data('address-id');
            var formData = $('.address-form').serialize();
            var checked = $('#default').is(':checked');

            formData += '&default=' + (checked ? 1 : 0);

            $.ajax({
                url: '/addresses/' + addressId,
                type: 'PUT',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    if (response.success) {
                        swal("Success", response.message, "success");
                        $('#addressModal').modal('hide');
                        $('#content-toggle').html(response.html);
                        $('#list-address').removeClass('fade').addClass('show').fadeIn();
                    } else {
                        swal("Error", response.message, "error");
                    }
                }
            });
        });

        document.getElementById('avatar-input').addEventListener('change', function() {
            var file = this.files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar-preview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        });
    </script>
</body>

</html>
