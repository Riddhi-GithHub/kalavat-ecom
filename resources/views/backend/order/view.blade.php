@extends('backend.layouts.app')
@section('style')
<style type="text/css">

</style>
@endsection
@section('content')
<ul class="breadcrumb">
  <li><a href="">Order</a></li>
  <li><a href="">View Order</a></li>
</ul>
<div class="page-title">
  <h2><span class="fa fa-arrow-circle-o-left"></span> View Order</h2>
</div>
<div class="page-content-wrap">
  <div class="row">
    <div class="col-md-12">
      {{-- start --}}
      <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">View Order</h3>
          </div>
            
            <div class="form-group">
              <label class="col-md-3 control-label">
                Order ID :
              </label>
              <div class="col-sm-5" style="margin-top: 8px;">
                {{ $order_detail->order_detail_id }}
              </div>
            </div>
          <hr>
          <div class="panel-body">

            @foreach ($product_list as $getproduct)

            <div class="form-group">
              <label class="col-md-3 control-label">
                Product Name :
              </label>
              <div class="col-sm-5" style="margin-top: 8px;">
                {{ $getproduct->product_name }}
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label">
                Price :
              </label>
              <div class="col-sm-5" style="margin-top: 8px;">
                {{ $getproduct->price }}
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label">
                Image :
              </label>
              <div class="col-sm-5" style="margin-top: 8px;">
               <img alt="image name" src="{{ url('public/images/product/'.$getproduct->img) }}"
                    style="width:70px; height:70px;" />
              </div>
            </div>
            <hr>
            @endforeach

            <div class="panel-footer">
              <a class="btn btn-primary pull-right" href="{{ url('admin/order') }}">
                <i class="fa fa-arrow-left"></i>&nbsp;&nbsp;<span class="bold">Back</span></a>
            </div>
          </div>
      </form>

      {{-- End --}}
    </div>
  </div>
</div>

@endsection
@section('script')
<script type="text/javascript">

</script>
@endsection