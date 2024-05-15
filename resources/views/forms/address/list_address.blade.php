<div id="content-toggle">
    @if (count($addresses) > 0)
        @foreach ($addresses as $item)
            <div class="card flex-row shadow-sm cursor-pointer" data-address-id="{{ $item->id }}">
                <div class="card-body" id="update-btn" data-bs-toggle="modal" data-bs-target="#addressModal">
                    <h5 class="card-title">{{ $item->name }}
                        @if ($item->default)
                            <span class="badge badge-primary"> Mặc định</span>
                        @endif
                    </h5>
                    <span>{{ $item->phone_number }}</span>
                    <p class="card-text">{{ $item->address }}</p>
                </div>
                <div class="delete-btn p-1 m-2 d-flex align-items-center justify-content-center">
                    <i class="fa-solid fa-xmark"></i>
                </div>
            </div>
        @endforeach
    @else
        <p>Hiện tại chưa có địa chỉ nào.</p>
    @endif
    @include('forms.address.address_form')
    <button class="btn btn-block btn-primary" data-bs-toggle="modal" data-bs-target="#addressModal">
        Thêm địa chỉ
    </button>
</div>
