@extends('forms.layout')

@section('content')
<div class="row justify-content-center">
    <a class="text-center display-5 py-3" href="{{ route('home') }}" title="BookStore">
        <b>Book</b>Store
    </a>
    <div class="col-12 col-md-8 col-lg-4">
        <div class="card shadow">
            <ul class="nav nav-pills shadow-sm">
                <li class="nav-item">
                    <a class="nav-link py-3 active" data-toggle="pill" href="#profile" role="tab">Hồ sơ của tôi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-3" data-toggle="pill" href="#list-address" role="tab">Địa chỉ của tôi</a>
                </li>
            </ul>
            <div class="card-body">
                <div class="tab-content" id="pills-tabContent p-3">
                    <div class="tab-pane fade show active" id="profile">
                        <form class="col-md-12 p-t-10" role="form" method="POST" action="{{ route('profiles.update') }}" enctype="multipart/form-data">
                            {!! csrf_field() !!}

                            <div class="form-group d-flex flex-column">
                                <label class="control-label" for="avatar">Ảnh đại diện</label>
                                @if ($user->profile->avatar)
                                <div class="avatar-img d-flex">
                                    <img class="rounded-circle img-fluid w-50 mx-auto" id="avatar-preview" src="{{ asset('storage/' . $user->profile->avatar) }}" alt="Avatar">
                                    <input id="avatar-input" type="file" name="avatar" accept="image/*" class="form-control-file">
                                </div>
                                @else
                                <input type="file" name="avatar" accept="image/*" class="form-control-file">
                                @endif
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="name">{{ trans('backpack::base.name') }}</label>
                                <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $user->name }}">
                                @if ($errors->has('name'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="gender">Giới tính</label>
                                <select class="form-select form-control" name="gender">
                                    <option value="1" {{ $user->profile->gender == 1 ? 'selected' : '' }}>Nam
                                    </option>
                                    <option value="0" {{ $user->profile->gender == 0 ? 'selected' : '' }}>Nữ
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="phone_number">Số điện thoại</label>
                                <div>
                                    <input type="text" class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" name="phone_number" value="{{ $user->profile->phone_number }}">
                                    @if ($errors->has('phone_number'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="address">Địa chỉ</label>
                                <div>
                                    <input type="text" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" value="{{ $user->profile->address }}">
                                    @if ($errors->has('address'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="bio">Tiểu sử</label>
                                <div>
                                    <textarea type="text" class="form-control{{ $errors->has('bio') ? ' is-invalid' : '' }}" name="bio" value="{{ $user->profile->bio }}" rows="5"></textarea>
                                    @if ($errors->has('bio'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('bio') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-block btn-primary">
                                    Cập nhật
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="list-address">
                        @include('forms.address.list_address')
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
