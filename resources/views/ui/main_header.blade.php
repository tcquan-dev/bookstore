        <header id="header" class="site-header">

            <div class="top-info border-bottom d-none d-md-block ">
                <div class="container-fluid">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <p class="fs-6 my-2 text-center">Need any help? Call us <a href="#">112233344455</a>
                            </p>
                        </div>
                        <div class="col-md-4 border-start border-end">
                            <p class="fs-6 my-2 text-center">Summer sale discount off 50% off! <a
                                    class="text-decoration-underline" href="shop.html">Shop Now</a></p>
                        </div>
                        <div class="col-md-4">
                            <p class="fs-6 my-2 text-center">2-3 business days delivery & free returns</p>
                        </div>
                    </div>
                </div>
            </div>

            <nav id="header-nav" class="navbar navbar-expand-lg py-3">
                <div class="container">
                    <a class="text-primary display-6" href="{{ route('home') }}" title="BookStore">
                        <b>Book</b>Store
                    </a>
                    <button class="navbar-toggler d-flex d-lg-none order-3 p-2" type="button"
                        data-bs-toggle="offcanvas" data-bs-target="#bdNavbar" aria-controls="bdNavbar"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <svg class="navbar-icon">
                            <use xlink:href="#navbar-icon"></use>
                        </svg>
                    </button>
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="bdNavbar"
                        aria-labelledby="bdNavbarOffcanvasLabel">
                        <div class="offcanvas-header px-4 pb-0">
                            <a class="navbar-brand" href="{{ route('home') }}" title="BookStore">
                                <b>Book</b>Store
                            </a>
                            <button type="button" class="btn-close btn-close-black" data-bs-dismiss="offcanvas"
                                aria-label="Close" data-bs-target="#bdNavbar"></button>
                        </div>
                        <div class="offcanvas-body">
                            <ul id="navbar"
                                class="navbar-nav text-uppercase justify-content-start justify-content-lg-center align-items-start align-items-lg-center flex-grow-1">
                                <li class="nav-item">
                                    <a class="nav-link me-4 active" href="index.html">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link me-4" href="about.html">About</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link me-4" href="shop.html">Shop</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link me-4" href="blog.html">Blogs</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link me-4 dropdown-toggle" data-bs-toggle="dropdown" href="#"
                                        role="button" aria-expanded="false">Pages</a>
                                    <ul class="dropdown-menu animate slide border">
                                        <li>
                                            <a href="about.html" class="dropdown-item fw-light">About <span
                                                    class="badge bg-primary">Pro</span></a>
                                        </li>
                                        <li>
                                            <a href="shop.html" class="dropdown-item fw-light">Shop <span
                                                    class="badge bg-primary">Pro</span></a>
                                        </li>
                                        <li>
                                            <a href="single-product.html" class="dropdown-item fw-light">Single
                                                Product
                                                <span class="badge bg-primary">Pro</span></a>
                                        </li>
                                        <li>
                                            <a href="cart.html" class="dropdown-item fw-light">Cart <span
                                                    class="badge bg-primary">Pro</span></a>
                                        </li>
                                        <li>
                                            <a href="checkout.html" class="dropdown-item fw-light">Checkout <span
                                                    class="badge bg-primary">Pro</span></a>
                                        </li>
                                        <li>
                                            <a href="blog.html" class="dropdown-item fw-light">Blog <span
                                                    class="badge bg-primary">Pro</span></a>
                                        </li>
                                        <li>
                                            <a href="single-post.html" class="dropdown-item fw-light">Single Post
                                                <span class="badge bg-primary">Pro</span></a>
                                        </li>
                                        <li>
                                            <a href="contact.html" class="dropdown-item fw-light">Contact <span
                                                    class="badge bg-primary">Pro</span></a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link me-4" href="contact.html">Contact</a>
                                </li>
                            </ul>
                            <div class="user-items d-flex">
                                <ul class="d-flex justify-content-end align-items-center list-unstyled mb-0">
                                    <li class="search-item pe-3">
                                        <a href="#" class="search-button">
                                            <i class="fa-solid fa-magnifying-glass fa-lg"></i>
                                        </a>
                                    </li>

                                    <li class="cart-dropdown dropdown pe-3">
                                        <div class="dropdown-toggle" data-bs-toggle="dropdown" role="button"
                                            aria-expanded="false">
                                            <div class="cart-icon-container">
                                                <i class="fa-solid fa-shopping-cart fa-lg"></i>
                                                @if (isset($user->cart->books))
                                                    <span class="cart-item-count">{{ count($user->cart->books) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div
                                            class="dropdown-menu animate slide dropdown-menu-start dropdown-menu-lg-end p-3">
                                            <div class="d-flex flex-column">
                                                <h4 class="text-primary">Giỏ hàng của tôi</h4>
                                                @if (isset($user->cart->books))
                                                    <ul class="list-group mb-3">
                                                        @foreach ($user->cart->books as $item)
                                                            <li class="list-group-item">
                                                                <div class="d-flex">
                                                                    <img class="img-thumbnail w-25"
                                                                        src="{{ isset($item->image_path) ? asset('storage/' . $item->image_path) : '' }} "
                                                                        alt="Book">
                                                                    <a class="m-2" href="single-product.html">
                                                                        <h5>{{ $item->title }}</h5>
                                                                    </a>
                                                                </div>
                                                                <p class="text-primary text-end">
                                                                    {{ number_format($item->price) . ' VNĐ' }}</p>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                    <div class="d-flex justify-content-around">
                                                        <a href="{{ url('carts') }}" class="btn btn-primary"
                                                            type="submit">Xem
                                                            giỏ hàng</a>
                                                        <a href="checkout.html" class="btn btn-primary"
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
                                    <li class="pe-3">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle" href="#" role="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                @if ($user)
                                                    <img class="avatar rounded-circle"
                                                        src="{{ isset($user->profile->avatar) ? asset('storage/' . $user->profile->avatar) : '' }}"
                                                        alt="Avatar">
                                                @else
                                                    <i class="fa-regular fa-user"></i>
                                                @endif
                                            </a>
                                            <ul class="dropdown-menu animate slide dropdown-menu-end shadow">
                                                @if ($user)
                                                    <li>
                                                        <a class="dropdown-item py-2" href="{{ route('profiles') }}">
                                                            {{ $user->name }}
                                                        </a>
                                                    </li>
                                                    @if ($user->hasRole('admin') || $user->hasRole('staff'))
                                                        <li><a class="dropdown-item py-2"
                                                                href="{{ route('backpack.dashboard') }}">Dashboard</a>
                                                        </li>
                                                    @endif
                                                    <li><a class="dropdown-item py-2"
                                                            href="{{ route('backpack.auth.logout') }}">Đăng xuất</a>
                                                    </li>
                                                @else
                                                    <li><a class="dropdown-item py-2"
                                                            href="{{ route('backpack.auth.login') }}">Đăng nhập</a>
                                                    </li>
                                                    <li><a class="dropdown-item py-2"
                                                            href="{{ route('backpack.auth.register') }}">Đăng ký</a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

        </header>
