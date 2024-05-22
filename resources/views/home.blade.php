<!DOCTYPE html>

<head>
    <title>BookStore</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('ui.styles')
</head>

<body>
    <div class="container-fluid">
        <div class="search-popup">
            <div class="search-popup-container">

                <form role="search" method="get" class="search-form" action="">
                    <input type="search" id="search-form" class="search-field" placeholder="Type and press enter"
                        value="" name="s" />
                    <button type="submit" class="search-submit"><svg class="search">
                            <use xlink:href="#search"></use>
                        </svg></button>
                </form>

                <h5 class="cat-list-title">Browse Categories</h5>

                <ul class="cat-list">
                    <li class="cat-list-item">
                        <a href="#" title="Romance">Romance</a>
                    </li>
                    <li class="cat-list-item">
                        <a href="#" title="Thriller">Thriller</a>
                    </li>
                    <li class="cat-list-item">
                        <a href="#" title="Sci-fi">Sci-fi</a>
                    </li>
                    <li class="cat-list-item">
                        <a href="#" title="Cooking">Cooking</a>
                    </li>
                    <li class="cat-list-item">
                        <a href="#" title="Health">Health</a>
                    </li>
                    <li class="cat-list-item">
                        <a href="#" title="Lifestyle">Lifestyle</a>
                    </li>
                    <li class="cat-list-item">
                        <a href="#" title="Fiction">Fiction</a>
                    </li>
                </ul>

            </div>
        </div>

        @include('ui.main_header')
        <div class="owl-carousel banner-items">
            @foreach ($books->take(3) as $item)
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="banner-content">
                                <h2>{{ $item->title }}</h2>
                                <p>Best Offer Save 30%. Grab it now!</p>
                                <a href="{{ url('/sales') }}" class="btn mt-3">Shop Collection</a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="image-holder">
                                <img src="{{ asset('storage/' . $item->image_path) }}" class="img-fluid" alt="banner">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <section id="company-services" class="padding-large pb-0">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 pb-3 pb-lg-0">
                        <div class="icon-box d-flex">
                            <div class="icon-box-icon pe-3 pb-3">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </div>
                            <div class="icon-box-content">
                                <h4 class="card-title mb-1 text-capitalize text-dark">Free delivery</h4>
                                <p>Fastest and most convenient delivery.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 pb-3 pb-lg-0">
                        <div class="icon-box d-flex">
                            <div class="icon-box-icon pe-3 pb-3">
                                <i class="fa-solid fa-ranking-star"></i>
                            </div>
                            <div class="icon-box-content">
                                <h4 class="card-title mb-1 text-capitalize text-dark">Quality guarantee</h4>
                                <p>Guaranteeing absolute quality and reliability.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 pb-3 pb-lg-0">
                        <div class="icon-box d-flex">
                            <div class="icon-box-icon pe-3 pb-3">
                                <i class="fa-solid fa-tags"></i>
                            </div>
                            <div class="icon-box-content">
                                <h4 class="card-title mb-1 text-capitalize text-dark">Daily offers</h4>
                                <p>Many discount programs and promotions.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 pb-3 pb-lg-0">
                        <div class="icon-box d-flex">
                            <div class="icon-box-icon pe-3 pb-3">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>
                            <div class="icon-box-content">
                                <h4 class="card-title mb-1 text-capitalize text-dark">100% secure payment</h4>
                                <p>Payment method is safe and ensures high security.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="best-selling-items py-5">
            <div class="container">
                <div class="section-title d-md-flex justify-content-between align-items-center mb-4">
                    <h3 class="d-flex align-items-center">Best selling items</h3>
                    <a href="shop.html" class="btn">View All</a>
                </div>
                <div class="owl-carousel selling-items">
                    @foreach ($books->take(12) as $item)
                        <div class="card position-relative p-3 m-3 border rounded-3 shadow-sm">
                            <img src="{{ asset('storage/' . $item->image_path) }}" class="img-fluid" alt="book">
                            <h6 class="mt-4 mb-0 fw-bold"><a href="single-product.html">{{ $item->title }}</a>
                            </h6>
                            <div class="review-content d-flex">
                                <p class="my-2 me-2 fs-6 text-black-50">{{ $item->author->name ?? '' }}</p>
                            </div>
                            @if (isset($item->sale))
                                <div class="price text-primary fw-bold fs-5 d-flex align-items-center">
                                    {{ number_format($item->price - ($item->price * $item->sale->value) / 100) }}
                                    VNĐ
                                    <span class="discount-label">-{{ $item->sale->value }}%</span>
                                </div>
                                <p class="text-decoration-line-through text-muted mb-0">
                                    {{ number_format($item->price) }} VNĐ
                                </p>
                            @else
                                <span class="price text-primary fw-bold fs-5">{{ number_format($item->price) }}
                                    VNĐ</span>
                            @endif
                            <div class="rating text-warning d-flex align-items-center mb-3">
                                @php
                                    $fullStars = floor($item->rate);
                                    $halfStar = $item->rate - $fullStars;
                                @endphp

                                @for ($i = 0; $i < $fullStars; $i++)
                                    <i class="fa-solid fa-star"></i>
                                @endfor

                                @if ($halfStar >= 0.5)
                                    <i class="fa-solid fa-star-half-stroke"></i>
                                    @for ($i = 0; $i < 4 - $fullStars; $i++)
                                        <i class="fa-regular fa-star"></i>
                                    @endfor
                                @else
                                    @for ($i = 0; $i < 5 - $fullStars; $i++)
                                        <i class="fa-regular fa-star"></i>
                                    @endfor
                                @endif
                                <span class="amount px-1">({{ $item->reviews->count() ?? 0 }})</span>
                            </div>
                            <div class="card-group">
                                <button class="btn cart-btn" data-book-id="{{ $item->id }}">
                                    <span class="add-to-cart">
                                        <i class="fa-solid fa-cart-plus fa-2xl"></i>
                                    </span>
                                    <span class="added">Added</span>
                                    <i class="fas fa-shopping-cart"></i>
                                    <i class="fas fa-box"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="limited-offer py-5">
            <div class="container">
                <div class="row d-flex align-items-center">
                    <div class="col-md-6 text-center">
                        <div class="image-holder">
                            <img src="{{ asset('storage/' . $sale->image_path) }}" class="img-fluid" alt="banner">
                        </div>
                    </div>
                    <div class="col-md-5 offset-md-1 mt-5 mt-md-0 text-center text-md-start">
                        <h2>{{ $sale->name }}</h2>
                        <div id="countdown-clock" data-expiration-date="{{ $sale->expiration_date }}"
                            class="text-dark d-flex align-items-center my-3">
                            <div class="time d-grid pe-3">
                                <span class="days fs-1 fw-normal"></span>
                                <small>Days</small>
                            </div>
                            <span class="fs-1 text-primary">:</span>
                            <div class="time d-grid pe-3 ps-3">
                                <span class="hours fs-1 fw-normal"></span>
                                <small>Hrs</small>
                            </div>
                            <span class="fs-1 text-primary">:</span>
                            <div class="time d-grid pe-3 ps-3">
                                <span class="minutes fs-1 fw-normal"></span>
                                <small>Min</small>
                            </div>
                            <span class="fs-1 text-primary">:</span>
                            <div class="time d-grid ps-3">
                                <span class="seconds fs-1 fw-normal"></span>
                                <small>Sec</small>
                            </div>
                        </div>
                        <a href="{{ url('/sales') }}" class="btn mt-3">Shop Collection</a>
                    </div>
                </div>
            </div>
    </div>
    </section>

    <section class="items-listing py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-3">
                    <div class="featured border p-3">
                        <div class="section-title overflow-hidden mb-5 mt-2">
                            <h3 class="d-flex flex-column mb-0">Featured</h3>
                        </div>

                        <div class="items-lists">
                            @foreach ($books->where('featured', true)->take(3) as $item)
                                <div class="item my-3 p-3 d-flex flex-column border rounded shadow">
                                    <div class="book-group py-3 d-flex align-items-center">
                                        <img src="{{ asset('storage/' . $item->image_path) }}" class="img-fluid"
                                            alt="product item">
                                        <div class="book-content mx-auto">
                                            <h5 class="fw-bold"><a href="single-product.html">{{ $item->title }}</a>
                                            </h5>
                                            <p class="my-2 fs-6 text-black-50">{{ $item->author->name ?? '' }}</p>
                                        </div>
                                    </div>
                                    <div class="item-content">
                                        @if (isset($item->sale->value))
                                            <span
                                                class="price text-primary fw-bold fs-5">{{ number_format($item->price - ($item->price * $item->sale->value) / 100) }}
                                                VNĐ<p class="text-decoration-line-through text-muted mb-0">
                                                    {{ number_format($item->price) }} VNĐ
                                                </p></span>
                                        @else
                                            <span
                                                class="price text-primary fw-bold fs-5">{{ number_format($item->price) }}
                                                VNĐ</span>
                                        @endif
                                        <div class="rating text-warning d-flex align-items-center my-1">
                                            @php
                                                $fullStars = floor($item->rate);
                                                $halfStar = $item->rate - $fullStars;
                                            @endphp

                                            @for ($i = 0; $i < $fullStars; $i++)
                                                <i class="fa-solid fa-star"></i>
                                            @endfor

                                            @if ($halfStar >= 0.5)
                                                <i class="fa-solid fa-star-half-stroke"></i>
                                                @for ($i = 0; $i < 4 - $fullStars; $i++)
                                                    <i class="fa-regular fa-star"></i>
                                                @endfor
                                            @else
                                                @for ($i = 0; $i < 5 - $fullStars; $i++)
                                                    <i class="fa-regular fa-star"></i>
                                                @endfor
                                            @endif
                                            <span class="amount px-1">({{ $item->reviews->count() ?? 0 }})</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="featured border p-3">
                        <div class="section-title overflow-hidden mb-5 mt-2">
                            <h3 class="d-flex flex-column mb-0">Latest</h3>
                        </div>

                        <div class="items-lists">
                            @foreach ($books->take(3) as $item)
                                <div class="item my-3 p-3 d-flex flex-column border rounded shadow">
                                    <div class="book-group py-3 d-flex align-items-center">
                                        <img src="{{ asset('storage/' . $item->image_path) }}" class="img-fluid"
                                            alt="product item">
                                        <div class="book-content mx-auto">
                                            <h5 class="fw-bold"><a href="single-product.html">{{ $item->title }}</a>
                                            </h5>
                                            <p class="my-2 fs-6 text-black-50">{{ $item->author->name ?? '' }}</p>
                                        </div>
                                    </div>
                                    <div class="item-content">
                                        <span
                                            class="price text-primary fw-bold fs-5">{{ number_format($item->price - ($item->price * 10) / 100) }}
                                            VNĐ<p class="text-decoration-line-through text-muted mb-0">
                                                {{ number_format($item->price) }} VNĐ
                                            </p></span>
                                        <div class="rating text-warning d-flex align-items-center my-1">
                                            @php
                                                $fullStars = floor($item->rate);
                                                $halfStar = $item->rate - $fullStars;
                                            @endphp

                                            @for ($i = 0; $i < $fullStars; $i++)
                                                <i class="fa-solid fa-star"></i>
                                            @endfor

                                            @if ($halfStar >= 0.5)
                                                <i class="fa-solid fa-star-half-stroke"></i>
                                                @for ($i = 0; $i < 4 - $fullStars; $i++)
                                                    <i class="fa-regular fa-star"></i>
                                                @endfor
                                            @else
                                                @for ($i = 0; $i < 5 - $fullStars; $i++)
                                                    <i class="fa-regular fa-star"></i>
                                                @endfor
                                            @endif
                                            <span class="amount px-1">({{ $item->reviews->count() ?? 0 }})</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="featured border p-3">
                        <div class="section-title overflow-hidden mb-5 mt-2">
                            <h3 class="d-flex flex-column mb-0">Best reviewed</h3>
                        </div>

                        <div class="items-lists">
                            @foreach ($books->where('rate', '>=', '4,5')->take(3) as $item)
                                <div class="item my-3 p-3 d-flex flex-column border rounded shadow">
                                    <div class="book-group py-3 d-flex align-items-center">
                                        <img src="{{ asset('storage/' . $item->image_path) }}" class="img-fluid"
                                            alt="product item">
                                        <div class="book-content mx-auto">
                                            <h5 class="fw-bold"><a href="single-product.html">{{ $item->title }}</a>
                                            </h5>
                                            <p class="my-2 fs-6 text-black-50">{{ $item->author->name ?? '' }}</p>
                                        </div>
                                    </div>
                                    <div class="item-content">
                                        <span
                                            class="price text-primary fw-bold fs-5">{{ number_format($item->price - ($item->price * 10) / 100) }}
                                            VNĐ<p class="text-decoration-line-through text-muted mb-0">
                                                {{ number_format($item->price) }} VNĐ
                                            </p></span>
                                        <div class="rating text-warning d-flex align-items-center my-1">
                                            @php
                                                $fullStars = floor($item->rate);
                                                $halfStar = $item->rate - $fullStars;
                                            @endphp

                                            @for ($i = 0; $i < $fullStars; $i++)
                                                <i class="fa-solid fa-star"></i>
                                            @endfor

                                            @if ($halfStar >= 0.5)
                                                <i class="fa-solid fa-star-half-stroke"></i>
                                                @for ($i = 0; $i < 4 - $fullStars; $i++)
                                                    <i class="fa-regular fa-star"></i>
                                                @endfor
                                            @else
                                                @for ($i = 0; $i < 5 - $fullStars; $i++)
                                                    <i class="fa-regular fa-star"></i>
                                                @endfor
                                            @endif
                                            <span class="amount px-1">({{ $item->reviews->count() ?? 0 }})</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="featured border p-3">
                        <div class="section-title overflow-hidden mb-5 mt-2">
                            <h3 class="d-flex flex-column mb-0">On sale</h3>
                        </div>

                        <div class="items-lists">
                            @foreach ($books->take(3) as $item)
                                <div class="item my-3 p-3 d-flex flex-column border rounded shadow">
                                    <div class="book-group py-3 d-flex align-items-center">
                                        <img src="{{ asset('storage/' . $item->image_path) }}" class="img-fluid"
                                            alt="product item">
                                        <div class="book-content mx-auto">
                                            <h5 class="fw-bold"><a href="single-product.html">{{ $item->title }}</a>
                                            </h5>
                                            <p class="my-2 fs-6 text-black-50">{{ $item->author->name ?? '' }}</p>
                                        </div>
                                    </div>
                                    <div class="item-content">
                                        <span
                                            class="price text-primary fw-bold fs-5">{{ number_format($item->price - ($item->price * 10) / 100) }}
                                            VNĐ<p class="text-decoration-line-through text-muted mb-0">
                                                {{ number_format($item->price) }} VNĐ
                                            </p></span>
                                        <div class="rating text-warning d-flex align-items-center my-1">
                                            @php
                                                $fullStars = floor($item->rate);
                                                $halfStar = $item->rate - $fullStars;
                                            @endphp

                                            @for ($i = 0; $i < $fullStars; $i++)
                                                <i class="fa-solid fa-star"></i>
                                            @endfor

                                            @if ($halfStar >= 0.5)
                                                <i class="fa-solid fa-star-half-stroke"></i>
                                                @for ($i = 0; $i < 4 - $fullStars; $i++)
                                                    <i class="fa-regular fa-star"></i>
                                                @endfor
                                            @else
                                                @for ($i = 0; $i < 5 - $fullStars; $i++)
                                                    <i class="fa-regular fa-star"></i>
                                                @endfor
                                            @endif
                                            <span class="amount px-1">({{ $item->reviews->count() }})</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="categories py-5">
        <div class="container">
            <div class="section-title overflow-hidden mb-4">
                <h3 class="d-flex align-items-center">Categories</h3>
            </div>
            <div class="row">
                @foreach ($categories->take(3) as $item)
                    <div class="col-md-4">
                        <div class="card mb-4 border-0 rounded-3 position-relative">
                            <a href="shop.html">
                                <img src="{{ asset('storage/' . $item->image_path) }}" class="img-fluid rounded-3"
                                    alt="cart item">
                                <h6 class=" position-absolute bottom-0 bg-primary m-4 py-2 px-3 rounded-3"><a
                                        href="shop.html" class="text-white">{{ $item->name }}</a></h6>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="customers-reviews py-5">
        <div class="container">
            <div class="section-title my-5 text-center">
                <h3>Customers reviews</h3>
            </div>
            <div class="owl-carousel review-items">
                <div class="card p-3 border rounded shadow mx-3">
                    <p class="text-justify">"I stumbled upon this bookstore while visiting the city, and it instantly
                        became
                        my favorite spot. The cozy atmosphere, friendly staff, and wide selection of books make
                        every visit a delight!"</p>
                    <div class="rating text-warning d-flex align-items-center mb-3">
                        <i class="fa-regular fa-star"></i>
                        <i class="fa-regular fa-star"></i>
                        <i class="fa-regular fa-star"></i>
                        <i class="fa-regular fa-star"></i>
                        <i class="fa-regular fa-star"></i>
                    </div>
                    <h5>Emma Chamberlin</h5>
                </div>
                <div class="card p-3 border rounded shadow mx-3">
                    <p class="text-justify">"As an avid reader, I'm always on the lookout for new releases, and this
                        bookstore never disappoints. They always have the latest titles, and their
                        recommendations have introduced me to some incredible reads!"</p>
                    <div class="rating text-warning d-flex align-items-center mb-3">
                        <i class="fa-regular fa-star"></i>
                        <i class="fa-regular fa-star"></i>
                        <i class="fa-regular fa-star"></i>
                        <i class="fa-regular fa-star"></i>
                        <i class="fa-regular fa-star"></i>
                    </div>
                    <h5>Thomas John</h5>
                </div>
                <div class="card p-3 border rounded shadow mx-3">
                    <p class="text-justify">"I ordered a few books online from this store, and I was impressed by the
                        quick
                        delivery and careful packaging. It's clear that they prioritize customer satisfaction,
                        and I'll definitely be shopping here again!"</p>
                    <div class="rating text-warning d-flex align-items-center mb-3">
                        <i class="fa-regular fa-star"></i>
                        <i class="fa-regular fa-star"></i>
                        <i class="fa-regular fa-star"></i>
                        <i class="fa-regular fa-star"></i>
                        <i class="fa-regular fa-star"></i>
                    </div>
                    <h5>Kevin Bryan</h5>
                </div>
                <div class="card p-3 border rounded shadow mx-3">
                    <p class="text-justify">“I stumbled upon this tech store while searching for a new laptop, and I
                        couldn't be happier
                        with my experience! The staff was incredibly knowledgeable and guided me through the
                        process of choosing
                        the perfect device for my needs. Highly recommended!”</p>
                    <div class="rating text-warning d-flex align-items-center mb-3">
                        <i class="fa-regular fa-star"></i>
                        <i class="fa-regular fa-star"></i>
                        <i class="fa-regular fa-star"></i>
                        <i class="fa-regular fa-star"></i>
                        <i class="fa-regular fa-star"></i>
                    </div>
                    <h5>Roman</h5>
                </div>
                <div class="card p-3 border rounded shadow mx-3">
                    <p class="text-justify">“I stumbled upon this tech store while searching for a new laptop, and I
                        couldn't be happier
                        with my experience! The staff was incredibly knowledgeable and guided me through the
                        process of choosing
                        the perfect device for my needs. Highly recommended!”</p>
                    <div class="rating text-warning d-flex align-items-center mb-3">
                        <i class="fa-regular fa-star"></i>
                        <i class="fa-regular fa-star"></i>
                        <i class="fa-regular fa-star"></i>
                        <i class="fa-regular fa-star"></i>
                        <i class="fa-regular fa-star"></i>
                    </div>
                    <h5>Stevin</h5>
                </div>
            </div>
    </section>

    @include('ui.main_footer')
    @include('ui.scripts')
</body>

</html>
