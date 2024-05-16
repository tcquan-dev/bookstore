<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    @include('ui.styles')
</head>

<body>
    @include('ui.main_header')
    @include('ui.preloader')
    <div class="container">
        @foreach ($books as $item)
        <div class="card shadow my-3">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="form-check col-1">
                        <input class="form-check-input mx-auto" type="checkbox" value="" id="flexCheckDefault">
                    </div>
                    <img src="{{ isset($item->image_path) ? asset('storage/'. $item->image_path) : ''}}" alt="Book" class="img-thumbnail col-1">
                    <h5 class="card-title col-3">{{ $item ->title }}</h5>
                    <span class="card-text col-3 mx-auto price">{{ number_format($item->price * $item->pivot->quantity) .' VNĐ' }}</span>
                    <div class="input-group col-1">
                        <input type="hidden" id="price-value" value="{{ $item->price }}">
                        <button class="btn btn-outline-secondary" type="button" id="button-minus">-</button>
                        <input type="text" class="form-control quantity-input text-center" value="{{ $item->pivot->quantity }}">
                        <button class="btn btn-outline-secondary" type="button" id="button-plus">+</button>
                    </div>
                    <span class="col-2 mx-auto total">{{ number_format($item->price * $item->pivot->quantity) .' VNĐ' }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @include('ui.main_footer')
    @include('ui.scripts')
</body>

</html>
