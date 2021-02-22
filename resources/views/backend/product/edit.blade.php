@extends('backend.layouts.app')
@section('style')
<style type="text/css">

</style>
@endsection
@section('content')

<ul class="breadcrumb">
   <li><a href="">Product</a></li>
   <li><a href="">Edit Product</a></li>
</ul>

<div class="page-title">
   <h2><span class="fa fa-arrow-circle-o-left"></span> Edit Product</h2>
</div>

<div class="page-content-wrap">
   <div class="row">
      <div class="col-md-12">
         {{-- start --}}

         <form class="form-horizontal" method="post" action="{{ route('product.update',$getproduct->id) }}"
            enctype="multipart/form-data">
            {{ csrf_field() }}
            @method('put')
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-title">Edit Product</h3>
               </div>

               <div class="panel-body">
                 <div class="form-group">
                  <label class="col-md-2 col-xs-12 control-label">Category </span></label>
                  <div class="col-md-8 col-xs-12">
                     <div class="">
                        <select id="cat_id" name="cat_id" class="form-control">
                           <option value="{{$getproduct->category->id}}">{{$getproduct->category->cat_name}}</option>
                           @foreach($getcategory as $categoryData)
                           <option value="{{$categoryData->id}}">{{$categoryData->cat_name}}</option>
                           @endforeach
                        </select>
                     </div>
                  </div>
               </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Productname </label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="product_name" value="{{ $getproduct->product_name }}"
                              placeholder="Productname" type="text" required class="form-control" />
                           <span style="color:red">{{ $errors->first('username') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Description</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="description" value="{{ $getproduct->description }}" placeholder="Description" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('description') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Price </span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="price" value="{{ $getproduct->price }}" placeholder="Price" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('price') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Quantity </span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           {{-- <input name="number" value="{{ old('quantity') }}" placeholder="Product" type="text" class="form-control" /> --}}
                           <input type="number" name="quantity" value="{{ $getproduct->quantity }}" class="form-control" placeholder="quantity"  min=1 oninput="validity.valid||(value='');"/>
                           <span style="color:red">{{  $errors->first('quantity') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Offer </span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="offer" value="{{ $getproduct->offer }}" placeholder="Offer" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('offer') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Color </span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="color" value="{{ $getproduct->color }}" placeholder="Color" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('color') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Size </span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="size" value="{{ $getproduct->size }}" placeholder="Size" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('size') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Brand </span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="brand" value="{{ $getproduct->brand }}" placeholder="Brand" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('brand') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Images </span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input type="file" class="form-control" name="images[]" multiple />(You can change image)
                           @foreach ($getimages as $item)
                           <img alt="image name" src="{{ url('public/images/product/'.$item->images) }}"
                           style="width:70px; height:70px;" />
                         @endforeach
                        {{-- <img alt="image name" src="{{ url('public/images/product/'.$getproduct->img) }}" style="width:70px; height:70px;" /> --}}
                        </div>
                     </div>
                  </div>

               </div>
               <div class="panel-footer">
                  <button class="btn btn-primary pull-right">Update</button>
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