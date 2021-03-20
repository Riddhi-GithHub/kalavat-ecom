@extends('backend.layouts.app')
@section('style')
<style type="text/css">

</style>
@endsection
@section('content')
<ul class="breadcrumb">
  <li><a href="">Product</a></li>
  <li><a href="">View Product</a></li>
</ul>
<div class="page-title">
  <h2><span class="fa fa-arrow-circle-o-left"></span> View Product</h2>
</div>
<div class="page-content-wrap">
  <div class="row">
    <div class="col-md-12">
      {{-- start --}}
      <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">View Product</h3>
          </div>
          <div class="panel-body">
            <div class="form-group">
              <label class="col-md-3 control-label">
                Product ID :
              </label>
              <div class="col-sm-5" style="margin-top: 8px;">
                {{ $getdata->id }}
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label">
                Product Name :
              </label>
              <div class="col-sm-5" style="margin-top: 8px;">
                {{ $getdata->product_name }}
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label">
                Description :
              </label>
              <div class="col-sm-5" style="margin-top: 8px;">
                {{ $getdata->description }}
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label">
                Price :
              </label>
              <div class="col-sm-5" style="margin-top: 8px;">
                {{ $getdata->price }}
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label">
                Quantity:
              </label>
              <div class="col-sm-5" style="margin-top: 8px;">
                {{ $getdata->quantity }}
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label">
                Offer :
              </label>
              <div class="col-sm-5" style="margin-top: 8px;">
                {{ $getdata->offer }}
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label">
                Color :
              </label>
              <div class="col-sm-5" style="margin-top: 8px;">
                {{ $getdata->color }}
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label">
                Size :
              </label>
              <div class="col-sm-5" style="margin-top: 8px;">
                {{ $getdata->size }}
              </div>
            </div>


            <div class="form-group">
              <label class="col-md-3 control-label">
                Brand :
              </label>
              <div class="col-sm-5" style="margin-top: 8px;">
                {{ $getdata->brand }}
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label">
                Images :
              </label>
              <div class="col-sm-5" style="margin-top: 8px;">
                @foreach ($getdata->images as $item)
                  <img alt="image name" src="{{ url('public/images/product/'.$item->images) }}"
                  style="width:70px; height:70px;" />
                @endforeach
                {{-- <img alt="image name" src="{{ url('public/images/product/'.$getdata->img) }}"
                  style="width:70px; height:70px;" /> --}}
              </div>
            </div>


            <div class="panel-footer">
              <a class="btn btn-primary pull-right" href="{{ url('admin/product') }}">
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