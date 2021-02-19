  <div class="page-sidebar">

        <ul class="x-navigation">
            <li class="" style="background: #EC0E71; text-align: center;">
                <a style="font-size: 22px;" href="{{ url('admin/dashboard') }}"><b>Kalavat</b></a>
                <a href="#" class="x-navigation-control"></a>
            </li>

            <li class="@if ( Request::segment(2)== 'dashboard') active @endif">
                <a href="{{ url('admin/dashboard') }}"><span class="fa fa-desktop"></span> <span class="xn-text">Dashboard</span></a>
           </li>

            @if(Auth::user()->is_admin == '1')
            <li class="@if ( Request::segment(2)== 'user') active @endif">
                <a href="{{ url('admin/user') }}"><span class="fa fa-user"></span> <span class="xn-text">User List</span></a>
            </li>

            <li class="@if ( Request::segment(2)== 'category') active @endif">
                <a href="{{ url('admin/category') }}"><span class="fa fa-list"></span> <span class="xn-text">Category List</span></a>
            </li>

            <li class="@if ( Request::segment(2)== 'product') active @endif">
                <a href="{{ url('product') }}"><span class="fa fa-user"></span> <span class="xn-text">Product List</span></a>
            </li>

            <li class="@if ( Request::segment(2)== 'user') active @endif">
                <a href="{{ url('admin/user') }}"><span class="fa fa-user"></span> <span class="xn-text">FavouriteProduct List</span></a>
            </li>
            <li class="@if ( Request::segment(2)== 'contact_us') active @endif">
                <a href="{{ url('admin/contact_us') }}"><span class="fa fa-book"></span> <span class="xn-text">Contact Us List</span></a>
            </li>

            @endif
            

        </ul>
    </div>