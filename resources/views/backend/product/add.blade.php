@extends('backend.layouts.app')
  @section('style')
    <style type="text/css">
      
    </style>
  @endsection 
@section('content')
        <ul class="breadcrumb">
            <li><a href="">Product</a></li>
            <li><a href="">Add Product</a></li>
        </ul>
        <div class="page-title">                    
            <h2><span class="fa fa-arrow-circle-o-left"></span> Add Product</h2>
        </div>
         <div class="page-content-wrap">
            <div class="row">
                <div class="col-md-12">
                  {{-- start --}}
         <form class="form-horizontal" method="post" action="{{ route('product.store') }}" enctype="multipart/form-data">
          {{ csrf_field() }}
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-title"> Add Product</h3>
               </div>
               <div class="panel-body">

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Select Category <span style="color:red">*</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <select id="cat_id" name="cat_id" class="form-control">
                              {{-- <select class="custom-select form-control" id="cat_id" name="cat_id"> --}}
                              <option selected disabled>Select Category</option>
                              @foreach($category as $categoryData)
                              <option value="{{$categoryData->id}}">{{$categoryData->cat_name}}</option>
                              @endforeach
                           </select>
                        </div>
                     </div>
                  </div>
                 
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Product Name <span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="product_name" value="{{ old('product_name') }}" placeholder="Product Name" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('product_name') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Description<span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="description" value="{{ old('description') }}" placeholder="Description" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('description') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Price <span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="price" value="{{ old('price') }}" placeholder="Price" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('price') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Quantity <span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           {{-- <input name="number" value="{{ old('quantity') }}" placeholder="Product" type="text" class="form-control" /> --}}
                           <input type="number" name="quantity" class="form-control" placeholder="Quantity"  min=1 oninput="validity.valid||(value='');"/>
                           <span style="color:red">{{  $errors->first('quantity') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Offer <span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="offer" value="{{ old('offer') }}" placeholder="Offer" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('offer') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Color <span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="color" value="{{ old('color') }}" placeholder="Color" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('color') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Size <span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="size" value="{{ old('size') }}" placeholder="Size" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('size') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Brand <span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="brand" value="{{ old('brand') }}" placeholder="Brand" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('brand') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Image <span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           {{-- <input name="brand" value="{{ old('brand') }}" placeholder="Product" type="text" class="form-control" /> --}}
                           <input type="file" class="form-control" name="images[]" multiple />(can select more than one)
                           <span style="color:red">{{  $errors->first('images') }}</span>
                        </div>
                     </div>
                  </div>

                </div>
               <div class="panel-footer">
                  <button class="btn btn-primary pull-right">Submit</button>
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
