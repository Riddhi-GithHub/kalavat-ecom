@extends('backend.layouts.app')
@section('style')
<style type="text/css">
</style>
@endsection
@section('content')
<ul class="breadcrumb">
  <li><a href="">Dashboard</a></li>
  <li><a href="">Dashboard List</a></li>
</ul>
<div class="page-title">
  <h2><span class="fa fa-arrow-circle-o-left"></span> Dashboard List</h2>
</div>
<div class="page-content-wrap">
  <div class="row">
    <div class="col-md-12">
      <div class="col-md-3">
        <!-- START Total users-->
        <div class="widget widget-default widget-item-icon">
          <div class="widget-item-left">
            <span class="fa fa-user"></span>
          </div>
          <div class="widget-data">
            <div class="widget-int num-count">{{ $user }}</div>
            <a class="widget-title"  href="{{ url('admin/user') }}">Total Users</a>
            {{-- <a href="">mm</a> --}}
          </div>
          <div class="widget-controls">
          </div>
        </div>
        <!-- END Total users-->
      </div>

      <div class="col-md-3">
        <!-- START WIDGET MESSAGES -->
        <div class="widget widget-default widget-item-icon">
          <div class="widget-item-left">
            <span class="fa fa-check-circle-o"></span>
          </div>
          <div class="widget-data">
            <div class="widget-int num-count">{{ $category }}</div>
            <a class="widget-title" href="{{ url('admin/category') }}">Total Category</a>

            {{-- <a class="nav-link text-success " href="{{ route('admin.userlist') }}" aria-expanded="false"
                        data-target="#submenu-10" aria-controls="submenu-10"><i
                            class="fa fa-fw fa-arrow-up  icon-circle-small bg-success-light"></i>More</a> --}}
            {{-- <div class="widget-subtitle">In your mailbox</div> --}}
          </div>
          <div class="widget-controls">
            {{-- <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top"
              title="Remove Widget"><span class="fa fa-times"></span></a> --}}
          </div>
        </div>
        <!-- END WIDGET MESSAGES -->
      </div>

      <div class="col-md-3">
        <!-- START Total users-->
        <div class="widget widget-default widget-item-icon">
          <div class="widget-item-left">
            <span class="fa fa-check-circle"></span>
          </div>
          <div class="widget-data">
            <div class="widget-int num-count">{{ $subcategory }}</div>
            <a class="widget-title" href="{{ url('admin/subcategory') }}">Total Subcategory</a>
          </div>
          <div class="widget-controls">
          </div>
        </div>
        <!-- END Total users-->
      </div>

      <div class="col-md-3">
        <!-- START Total users-->
        <div class="widget widget-default widget-item-icon">
          <div class="widget-item-left">
            <span class="fa fa-bullseye"></span>
          </div>
          <div class="widget-data">
            <div class="widget-int num-count">{{ $product }}</div>
            <a class="widget-title" href="{{ url('admin/product') }}">Total Product</a>
          </div>
          <div class="widget-controls">
          </div>
        </div>
        <!-- END Total users-->
      </div>

      <div class="col-md-3">
        <!-- START Total users-->
        <div class="widget widget-default widget-item-icon">
          <div class="widget-item-left">
            <span class="fa fa-circle-o-notch"></span>
          </div>
          <div class="widget-data">
            <div class="widget-int num-count">{{ $todayorder }}</div>
            <a class="widget-title" href="{{ url('admin/order') }}">Total Todays Order</a>
          </div>
          <div class="widget-controls">
          </div>
        </div>
        <!-- END Total users-->
      </div>

      <div class="col-md-3">
        <!-- START Total users-->
        <div class="widget widget-default widget-item-icon">
          <div class="widget-item-left">
            <span class="fa fa fa-circle-o"></span>
          </div>
          <div class="widget-data">
            <div class="widget-int num-count">{{ $totalorder }}</div>
            <a class="widget-title" href="{{ url('admin/order') }}">Total Order</a>
          </div>
          <div class="widget-controls">
          </div>
        </div>
        <!-- END Total users-->
      </div>

    </div>
  </div>
</div>

@endsection
@section('script')
<script type="text/javascript">

</script>
@endsection