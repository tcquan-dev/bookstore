{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="fa-solid fa-house nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-item title="Người dùng" icon="fa-solid fa-user" :link="backpack_url('user')" />
<x-backpack::menu-item title="Sách" icon="fa-solid fa-book" :link="backpack_url('book')" />
<x-backpack::menu-item title="Vai trò" icon="fa-solid fa-project-diagram" :link="backpack_url('role')" />
<x-backpack::menu-item title="Phân quyền" icon="fa-solid fa-layer-group" :link="backpack_url('permission')" />
<x-backpack::menu-item title="Tác giả" icon="fa-solid fa-user-pen" :link="backpack_url('author')" />
<x-backpack::menu-item title="Thể loại" icon="fa-solid fa-list" :link="backpack_url('category')" />
<x-backpack::menu-item title="Chương trình giảm giá" icon="fa-solid fa-tags" :link="backpack_url('sale')" />