{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-item title="Người dùng" icon="la la-user" :link="backpack_url('user')" />
<x-backpack::menu-item title="Sách" icon="la la-book" :link="backpack_url('book')" />
<x-backpack::menu-item title="Vai trò" icon="la la-project-diagram" :link="backpack_url('role')" />
<x-backpack::menu-item title="Phân quyền" icon="la la-layer-group" :link="backpack_url('permission')" />

