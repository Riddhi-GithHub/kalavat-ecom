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
                  <label class="col-md-2 col-xs-12 control-label">Category Name </span></label>
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
                     <label class="col-md-2 col-xs-12 control-label">Product Name</label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="product_name" value="{{ $getproduct->product_name }}"
                              placeholder="Product Name" type="text" required class="form-control" />
                           <span style="color:red">{{ $errors->first('product_name') }}</span>
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
                           <input type="number" name="quantity" value="{{ $getproduct->quantity }}" class="form-control" placeholder="Quantity"  min=1 oninput="validity.valid||(value='');"/>
                           <span style="color:red">{{  $errors->first('quantity') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Offer </span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="offer" value="{{ $getproduct->offer }}" placeholder="Offer" type="number" class="form-control" />
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
                     <label class="col-md-2 col-xs-12 control-label">Short Description</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="sort_desc" value="{{ $getproduct->sort_desc }}" placeholder="Short Description" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('sort_desc') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Size And Fit</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="size_and_fit" value="{{ $getproduct->size_and_fit }}" placeholder="Size And Fit" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('size_and_fit') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Material And Care</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="material_and_care" value="{{ $getproduct->material_and_care }}" placeholder="Material And Care" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('material_and_care') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Style Note</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="style_note" value="{{ $getproduct->style_note }}" placeholder="Style Note" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('style_note') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Manufacturing Address</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                         @foreach ($getproduct->manufacturing as $item)
                           <input name="address" value="{{ $item->address }}" placeholder="Manufacturing Address" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('address') }}</span>
                        @endforeach
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Manufacturing City</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                         @foreach ($getproduct->manufacturing as $item)
                           <input name="city" value="{{  $item->city }}" placeholder="Manufacturing City" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('city') }}</span>
                           @endforeach
                        </div>
                     </div>
                  </div>
                  
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Manufacturing Contry</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                         @foreach ($getproduct->manufacturing as $item)
                           <input name="contry" value="{{  $item->contry }}" placeholder="Manufacturing Contry" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('contry') }}</span>
                           @endforeach
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Manufacturing State</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                         @foreach ($getproduct->manufacturing as $item)
                           <input name="state" value="{{  $item->state }}" placeholder="Manufacturing State" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('state') }}</span>
                           @endforeach
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Manufacturing Zip-Code</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                         @foreach ($getproduct->manufacturing as $item)
                           <input name="zip_code" value="{{  $item->zip_code }}" placeholder="Manufacturing Zip-Code" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('zip_code') }}</span>
                           @endforeach
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Manufacturing By</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                         @foreach ($getproduct->manufacturing as $item)
                           <input name="manufacture_by" value="{{  $item->manufacture_by }}" placeholder="Manufacturing By" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('manufacture_by') }}</span>
                           @endforeach
                        </div>
                     </div>
                  </div>
                  
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Manufacturing Date</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           @foreach ($getproduct->manufacturing as $item)
                           <input name="manufacture_date" value="{{  $item->manufacture_date }}" placeholder="Manufacturing Date" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('manufacture_date') }}</span>
                           @endforeach
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