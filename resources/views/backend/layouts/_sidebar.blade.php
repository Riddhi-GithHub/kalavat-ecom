  <div class="page-sidebar">

        <ul class="x-navigation">
            {{-- <li class="" style="background: #EC0E71; text-align: center;">
                <a style="font-size: 22px;" href="{{ url('admin/dashboard') }}"><b>Kalavat</b></a>
                <a href="#" class="x-navigation-control"></a>
            </li> --}}

            <li class="" style="background: #EC0E71; text-align: center;">
                <a href="{{ url('admin/dashboard') }}" style="font-size: 22px;"><span class="xn-text">Kalavat</span></a>
            </li>

            <li class="@if ( Request::segment(2)== 'dashboard') active @endif">
                <a href="{{ url('admin/dashboard') }}"><span class="fa fa-desktop"></span> <span class="xn-text">Dashboard</span></a>
           </li>

           <li class="@if ( Request::segment(2)== 'change_password') active @endif">
            <a href="{{ url('admin/setting/change_password/'.Auth::user()->id) }}"><span class="fa fa-gear"></span> <span class="xn-text">Account Setting</span></a>
           </li>

            @if(Auth::user()->is_admin == '1')
            <li class="@if ( Request::segment(2)== 'user') active @endif">
                <a href="{{ url('admin/user') }}"><span class="fa fa-user"></span> <span class="xn-text">User List</span></a>
            </li>

            <li class="@if ( Request::segment(2)== 'sale') active @endif">
                <a href="{{ url('admin/sale') }}"><span class="fa fa-gift"></span> <span class="xn-text">Sale List</span></a>
            </li>

            <li class="@if ( Request::segment(2)== 'category') active @endif">
                <a href="{{ url('admin/category') }}"><span class="fa fa-list"></span> <span class="xn-text">Category List</span></a>
            </li>

            <li class="@if ( Request::segment(2)== 'subcategory') active @endif">
                <a href="{{ url('admin/subcategory') }}"><span class="fa fa-bars"></span> <span class="xn-text">Sub Category List</span></a>
            </li>

            <li class="@if ( Request::segment(2)== 'product') active @endif">
                <a href="{{ url('admin/product') }}"><span class="fa fa-table"></span> <span class="xn-text">Product List</span></a>
            </li>

            <li class="@if ( Request::segment(2)== 'catalog') active @endif">
                <a href="{{ url('admin/catalog') }}"><span class="fa fa-film"></span> <span class="xn-text">Catalog List</span></a>
            </li>

            <li class="@if ( Request::segment(2)== 'favouriteitem') active @endif">
                <a href="{{ url('admin/favouriteitem') }}"><span class="fa fa-heart"></span> <span class="xn-text">Favourite Product List</span></a>
            </li>

            <li class="@if ( Request::segment(2)== 'cartitem') active @endif">
                <a href="{{ url('admin/cartitem') }}"><span class="fa fa-shopping-cart"></span> <span class="xn-text">Cart List</span></a>
            </li>

            <li class="@if ( Request::segment(2)== 'order') active @endif">
                <a href="{{ url('admin/order') }}"><span class="fa fa-tasks"></span> <span class="xn-text">Order List</span></a>
            </li>

            <li class="@if ( Request::segment(2)== 'versionsetting') active @endif">
                <a href="{{ url('admin/versionsetting') }}"><span class="fa fa-gear"></span> <span class="xn-text">Version Setting</span></a>
            </li>

            <li class="@if ( Request::segment(2)== 'slider') active @endif">
                <a href="{{ url('admin/slider') }}"><span class="fa fa-sliders"></span> <span class="xn-text">Slider List</span></a>
            </li>

            <li class="@if ( Request::segment(2)== 'contact_us') active @endif">
                <a href="{{ url('admin/contact_us') }}"><span class="fa fa-book"></span> <span class="xn-text">Contact Us List</span></a>
            </li>

            <li class="@if ( Request::segment(2)== 'notification') active @endif">
                <a href="{{ url('admin/notification') }}"><span class="fa fa-bell"></span> <span class="xn-text">Notification</span></a>
            </li>

            @endif

        </ul>
    </div>