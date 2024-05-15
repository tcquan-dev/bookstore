<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ backpack_theme_config('html_direction') }}">

<head>
  <link rel="stylesheet" href="{{ url('css/form.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" />
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

    $('#submit-btn').click(function(event) {
      event.preventDefault();

      var formData = $('.address-form').serialize();

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
            $('#list-address').replaceWith(response.html);
            $('#list-address').removeClass('fade').addClass('show').fadeIn();
          } else {
            swal("Error", response.message, "error");
          }
        },
      });
    });

    $('.close-icon').click(function() {
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
  </script>
</body>

</html>
