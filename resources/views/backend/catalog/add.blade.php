@extends('backend.layouts.app')
  @section('style')
    <style type="text/css">
      
    </style>
  @endsection 
@section('content')

        <ul class="breadcrumb">
            <li><a href="">Catalog</a></li>
            <li><a href="">Add Catalog</a></li>
        </ul>
        
        <div class="page-title">                    
            <h2><span class="fa fa-arrow-circle-o-left"></span> Add Catalog</h2>
        </div>

         <div class="page-content-wrap">
            <div class="row">
                <div class="col-md-12">

                  {{-- start --}}

         <form class="form-horizontal" method="post" action="{{ route('catalog.store') }}" enctype="multipart/form-data">
          {{ csrf_field() }}
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-title"> Add Catalog</h3>
               </div>
               <div class="panel-body">
                 
                  {{-- <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Select Category <span style="color:red">*</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <select id="category_id" name="category_id" class="form-control">
                                 <option selected disabled>Select Category</option>
                                 @foreach($category as $categoryData)
                                 <option value="{{$categoryData->id}}">{{$categoryData->cat_name}}</option>
                                 @endforeach
                              </select>
                              <span style="color:red">{{  $errors->first('category_id') }}</span>
                           </div>
                        </div>
                     </div> --}}

                     <div class="form-group">
                        <label class="col-md-2 col-xs-12 control-label">Select SubCategory <span style="color:red">*</span></label>
                        <div class="col-md-8 col-xs-12">
                           <div class="">
                              <select id="sub_category_id" name="sub_category_id" class="form-control">
                                    <option selected disabled>Select SubCategory</option>
                                    @foreach($subcategory as $categoryData)
                                    <option value="{{$categoryData->id}}">{{$categoryData->sub_cat_name}}</option>
                                    @endforeach
                                 </select>
                                 <span style="color:red">{{  $errors->first('sub_category_id') }}</span>
                              </div>
                           </div>
                        </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Catalog Title <span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="catalog_title" value="{{ old('catalog_title') }}" placeholder="Catalog Title" type="text" required class="form-control" />
                           <span style="color:red">{{  $errors->first('catalog_title') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Catalog Description <span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="catalog_description" value="{{ old('catalog_description') }}" placeholder="Catalog Description" type="text" required class="form-control" />
                           <span style="color:red">{{  $errors->first('catalog_description') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Catalog Amount <span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="catalog_amount" value="{{ old('catalog_amount') }}" placeholder="Catalog Amount" type="text" required class="form-control" />
                           <span style="color:red">{{  $errors->first('catalog_amount') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Catalog Size <span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="catalog_size" value="{{ old('catalog_size') }}" placeholder="Catalog Size" type="text" required class="form-control" />
                           <span style="color:red">{{  $errors->first('catalog_size') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Catalog Brand <span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="catalog_brand" value="{{ old('catalog_brand') }}" placeholder="Catalog Brand" type="text" required class="form-control" />
                           <span style="color:red">{{  $errors->first('catalog_brand') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Product Name <span style="color:red"> *</span></label>
                         <div class="col-md-8 col-xs-12">
                             <div class="">
                                <select class="form-control" name="product_id[]" required="" multiple="">
                                   @foreach($getproduct as $product)
                                   {{-- {{ dd($product->product_name) }} --}}
                                    <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                    @endforeach
                                </select>
                                <span style="color:red">{{  $errors->first('product_id') }}</span>
                             </div>
                         </div>
                     </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Catalog Image <span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           {{-- <input name="brand" value="{{ old('brand') }}" placeholder="Product" type="text" class="form-control" /> --}}
                           <input type="file" class="form-control" name="catalog_image"/>(can select only one image)
                           <span style="color:red">{{  $errors->first('catalog_image') }}</span>
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
