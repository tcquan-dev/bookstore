{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-item title="Book" icon="la la-book" :link="backpack_url('book')" />
<x-backpack::menu-item title="Cart" icon="la la-shopping-cart" :link="backpack_url('cart')" />
<x-backpack::menu-item title="Delivery Address" icon="la la-address-book" :link="backpack_url('delivery-address')" />
<x-backpack::menu-item title="Permission" icon="la la-question" :link="backpack_url('permission')" />
<x-backpack::menu-item title="Profile" icon="la la-question" :link="backpack_url('profile')" />
<x-backpack::menu-item title="Role" icon="la la-question" :link="backpack_url('role')" />
<x-backpack::menu-item title="User" icon="la la-user" :link="backpack_url('user')" />
<x-backpack::menu-item title="Verification" icon="la la-question" :link="backpack_url('verification')" />