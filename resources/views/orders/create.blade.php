@extends('ui.layout')

@section('content')
    <form class="order-form" role="form">
        {!! csrf_field() !!}
        <input type="hidden" id="id" name="id" value="{{ $cart->id }}">
        <input type="hidden" id="address_id" name="address_id" value="{{ $address ? $address->id : '' }}">
        <input type="hidden" id="total_price" name="total_price" value="{{ $total }}">

        <div class="line"></div>
        <div class="address-group border shadow-sm mb-3 p-3">
            @if ($address)
                <div class="text-primary fw-bold">
                    <i class="fa-solid fa-location-dot"></i>
                    <span> Địa chỉ nhận hàng</span>
                </div>
                <div class="d-flex px-3 align-items-center" data-address-id="{{ $address->id }}">
                    <div class="address-title fw-bold">{{ $address->name }}
                        @if ($address->default)
                            <span class="badge bg-primary"> Default</span>
                        @endif
                        <p>{{ $address->phone_number }}</p>
                    </div>
                    <p class="address-text mx-auto">{{ $address->address }}</p>
                    <div class="btn btn-primary text-uppercase mx-3 px-3 py-2" data-bs-toggle="modal"
                        data-bs-target="#listAddress">Change</div>
                </div>
            @else
                <div class="btn btn-primary p-3 my-3" data-bs-toggle="modal" data-bs-target="#addressForm">
                    Add new address
                </div>
            @endif
        </div>
        <div class="border shadow-sm p-3">
            <div class="d-flex justify-content-center">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center fw-bold" scope="col"></th>
                            <th class="text-center fw-bold" scope="col">Name</th>
                            <th class="text-center fw-bold" scope="col">Price</th>
                            <th class="text-center fw-bold" scope="col">Quantity</th>
                            <th class="text-center fw-bold" scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart->books as $item)
                            <tr>
                                <td class="col-2 text-center align-middle">
                                    <img src="{{ isset($item->image_path) ? asset('storage/' . $item->image_path) : '' }}"
                                        alt="Book" class="img-fluid mx-auto">
                                </td>
                                <td class="col-3 text-center align-middle">
                                    <span class="card-title col-3">{{ $item->title }}</span>
                                </td>
                                <td class="col-3 text-center align-middle">
                                    {{ number_format($item->price - $item->discount) }} VNĐ
                                    @if ($item->sale)
                                        <p class="text-decoration-line-through text-muted mb-0">
                                            {{ number_format($item->price) }} VNĐ
                                        </p>
                                    @endif
                                </td>
                                <td class="col-2 text-center align-middle">{{ $item->quantity }}</td>
                                <td class="col-2 text-center align-middle">{{ number_format($item->total_price) }} VNĐ</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex align-items-center justify-content-end">
                <label class="mx-3" for="payment_method">Payment Method</label>
                <select class="form-select w-25" id="payment_method" name="payment_method">
                    <option value="1">Payment on delivery</option>
                    <option value="2">Transfer payment</option>
                </select>
            </div>
            <div class="d-flex align-items-center justify-content-end p-3">
                <div class="mx-3">Total: </div>
                <span class="text-primary fw-bold">{{ number_format($total) }} VNĐ</span>
                <button class="btn btn-success text-uppercase mx-3 px-3 py-2" id="order-submit-btn" type="button"
                    data-cart-id="{{ $cart->id }}">Order</button>
            </div>
        </div>
    </form>
    @include('orders.cart_address')
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('js/order.js') }}"></script>
@endsection
