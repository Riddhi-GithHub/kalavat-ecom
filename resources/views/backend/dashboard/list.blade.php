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
            <div class="widget-title">Total Users</div>
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
            <div class="widget-title">Total Category</div>
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
            <div class="widget-title">Total Subcategory</div>
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
            <div class="widget-title">Total Product</div>
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
            <div class="widget-title">Total Todays Order</div>
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
            <div class="widget-title">Total Order</div>
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