<div class="modal fade py-5" id="addressForm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tạo địa chỉ giao hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="address-form" role="form">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label class="control-label" for="name">Họ và tên</label>
                        <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                            name="name" id="name" />
                        @if ($errors->has('name'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="phone_number">Số điện thoại</label>
                        <input type="text"
                            class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}"
                            name="phone_number" id="phone_number" />
                        @if ($errors->has('phone_number'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('phone_number') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="address">Địa chỉ</label>
                        <input type="text" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                            name="address" id="address" />
                        @if ($errors->has('address'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <div class="form-check my-3 pl-4">
                            <input class="form-check-input" type="checkbox" id="default" />
                            <label class="control-label" for="default">Chọn làm mặc định</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="button" class="btn btn-primary" id="cart-form-btn" data-cart-id="{{ $cart->id }}">
                    Save changes
                </button>
            </div>
        </div>
    </div>
</div>
