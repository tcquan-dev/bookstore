<div class="modal fade py-5" id="listAddress" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">List of delivery addresses</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @foreach ($addresses as $item)
                    <div class="card flex-row shadow-sm cursor-pointer align-items-center my-3"
                        data-address-id="{{ $item->id }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->name }}
                                @if ($item->default)
                                    <span class="badge bg-primary"> Default</span>
                                @endif
                            </h5>
                            <span>{{ $item->phone_number }}</span>
                            <p class="card-text">{{ $item->address }}</p>
                        </div>
                        <label class="custom-radio mx-3 p-3">
                            <input id="address_id" type="radio" name="address_id" value="{{ $item->id }}"
                                {{ $item->id == $cart->address_id ? 'checked' : '' }}>
                            <span class="checkmark"></span>
                        </label>
                    </div>
                @endforeach
                <div class="d-flex justify-content-center my-3">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addressForm">
                        Add new address
                    </button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="button" class="btn btn-primary" id="cart-address-btn"
                    data-cart-id="{{ $cart->id }}">
                    Save changes
                </button>
            </div>
        </div>
    </div>
</div>
@include('orders.form')
