                                    <li class="cart-dropdown dropdown pe-3">
                                        <div class="dropdown-toggle" data-bs-toggle="dropdown" role="button"
                                            aria-expanded="false">
                                            <div class="cart-icon-container">
                                                <i class="fa-solid fa-shopping-cart fa-lg"></i>
                                                @if (isset($cart->books))
                                                    <span class="cart-item-count">{{ count($cart->books) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div
                                            class="dropdown-menu animate slide dropdown-menu-start dropdown-menu-lg-end p-3">
                                            <div class="d-flex flex-column">
                                                <h4 class="text-primary">Giỏ hàng của tôi</h4>
                                                @if (isset($cart->books))
                                                    <ul class="list-group mb-3">
                                                        @foreach ($cart->books as $item)
                                                            <li class="list-group-item">
                                                                <div class="d-flex">
                                                                    <img class="img-thumbnail w-25"
                                                                        src="{{ isset($item->image_path) ? asset('storage/' . $item->image_path) : '' }} "
                                                                        alt="Book">
                                                                    <a class="m-2" href="single-product.html">
                                                                        <h5>{{ $item->title }}</h5>
                                                                    </a>
                                                                </div>
                                                                @if (isset($item->sale))
                                                                    <div class="text-primary text-end">
                                                                        {{ number_format($item->price - ($item->price * $item->sale->value) / 100) }}
                                                                        VNĐ
                                                                    </div>
                                                                    <p
                                                                        class="text-decoration-line-through text-muted mb-0 text-end">
                                                                        {{ number_format($item->price) }} VNĐ
                                                                    </p>
                                                                @else
                                                                    <p class="text-primary text-end">
                                                                        {{ number_format($item->price) }}
                                                                        VNĐ</p>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                    <div class="d-flex justify-content-around">
                                                        <a href="{{ url('/orders/create') }}" class="btn btn-primary"
                                                            type="submit">Thanh toán</a>
                                                    </div>
                                                @else
                                                    <img class="img-fluid w-50 mx-auto"
                                                        src="https://cdni.iconscout.com/illustration/premium/thumb/empty-cart-7359557-6024626.png"
                                                        alt="Cart">
                                                    <p class="text-center">Chưa có sản phẩm trong giỏ hàng.</p>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
