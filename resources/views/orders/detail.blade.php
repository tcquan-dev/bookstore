@extends('ui.layout')

@section('content')
    <div class="line"></div>
    <div class="address-group border shadow-sm mb-3 p-3">

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
            @if ($order->hasStatus('Pending'))
                <div class="btn btn-primary text-uppercase mx-3 px-3 py-2" data-bs-toggle="modal"
                    data-bs-target="#listAddress">
                    Change</div>
            @endif
        </div>

    </div>
    <div class="card flex-row shadow-sm my-3">
        <div class="card-body">
            <div class="d-flex flex-column justify-content-center">
                <span class="text-primary text-end text-uppercase my-3">{{ $order->status->name }}</span>
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center fw-bold" scope="col"></th>
                            <th class="text-center fw-bold" scope="col">Name</th>
                            <th class="text-center fw-bold" scope="col">Quantity</th>
                            <th class="text-center fw-bold" scope="col">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->books as $item)
                            <tr>
                                <td class="col-2 text-center align-middle">
                                    <img src="{{ isset($item->image_path) ? asset('storage/' . $item->image_path) : '' }}"
                                        alt="Book" class="img-fluid mx-auto">
                                </td>
                                <td class="col-5 text-center align-middle">
                                    <span class="card-title col-3">{{ $item->title }}</span>
                                </td>
                                <td class="col-2 text-center align-middle">{{ $item->pivot->quantity }}</td>
                                <td class="col-3 text-center align-middle">
                                    {{ number_format($item->price - $item->pivot->discount) }} VNĐ
                                    @if ($item->sale)
                                        <p class="text-decoration-line-through text-muted mb-0">
                                            {{ number_format($item->pivot->price) }} VNĐ
                                        </p>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-end">Total: <span class="text-primary fw-bold">{{ number_format($order->total_price) }}
                        VNĐ</span></div>
                @if ($order->hasStatus('Pending'))
                    <div class="text-end ml-3">
                        <button class="btn btn-danger my-3 px-3 py-2">Cancel</button>
                    </div>
                @endif
                @if ($order->hasStatus('Completed') && !$order->reviewed)
                    <div class="text-end ml-3">
                        <button class="btn btn-primary my-3 px-3 py-2">Review</button>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @include('orders.order_address')
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('js/order.js') }}"></script>
@endsection
