@extends('ui.layout')

@section('content')
    <div class="row justify-content-center">
        @foreach ($books as $item)
            <div class="card col-3 p-3 m-3 border rounded-3 shadow-sm">
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
@endsection
