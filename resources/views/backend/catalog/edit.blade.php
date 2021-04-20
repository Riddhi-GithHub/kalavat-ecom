@extends('backend.layouts.app')
  @section('style')
    <style type="text/css">
      
    </style>
  @endsection 
@section('content')

        <ul class="breadcrumb">
            <li><a href="">Catalog</a></li>
            <li><a href="">Edit Catalog</a></li>
        </ul>
        
        <div class="page-title">                    
            <h2><span class="fa fa-arrow-circle-o-left"></span> Edit Catalog</h2>
        </div>

         <div class="page-content-wrap">
            <div class="row">
                <div class="col-md-12">

                  {{-- start --}}

         <form class="form-horizontal" method="post" action="{{ route('catalog.update',$getcatalog->id) }}" enctype="multipart/form-data">
          {{ csrf_field() }}
          @method('put')
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-title"> Edit Catalog</h3>
               </div>
               <div class="panel-body">

                  {{-- <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Category Name </span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <select id="category_id" name="category_id" class="form-control">
                              <option value="{{$getcatalog->category->id}}">{{$getcatalog->category->cat_name}}</option>
                              @foreach($getcategory as $categoryData)
                              <option value="{{$categoryData->id}}">{{$categoryData->cat_name}}</option>
                              @endforeach
                           </select>
                           <span style="color:red">{{  $errors->first('category_id') }}</span>
                        </div>
                     </div>
                  </div> --}}
                 
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">SubCategory Name </span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <select id="sub_category_id" name="sub_category_id" class="form-control">
                              <option value="{{$getcatalog->category->id}}">{{$getcatalog->subcategory->sub_cat_name}}</option>
                              @foreach($getsubcategory as $categoryData)
                              <option value="{{$categoryData->id}}">{{$categoryData->sub_cat_name}}</option>
                              @endforeach
                           </select>
                           <span style="color:red">{{  $errors->first('sub_category_id') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Catalog Title </span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="catalog_title" value="{{ $getcatalog->catalog_title }}" placeholder="Catalog Title" type="text" required class="form-control" />
                           <span style="color:red">{{  $errors->first('catalog_title') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Catalog Description </span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="catalog_description" value="{{ $getcatalog->catalog_description }}" placeholder="Catalog Description" type="text" required class="form-control" />
                           <span style="color:red">{{  $errors->first('catalog_description') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Catalog Amount <span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="catalog_amount" value="{{ $getcatalog->catalog_amount }}" placeholder="Catalog Amount" type="text" required class="form-control" />
                           <span style="color:red">{{  $errors->first('catalog_amount') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Catalog Size <span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="catalog_size" value="{{ $getcatalog->catalog_size }}" placeholder="Catalog Size" type="text" required class="form-control" />
                           <span style="color:red">{{  $errors->first('catalog_size') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Catalog Brand <span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="catalog_brand" value="{{ $getcatalog->catalog_brand }}" placeholder="Catalog Brand" type="text" required class="form-control" />
                           <span style="color:red">{{  $errors->first('catalog_brand') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Product Name<span style="color:red"> *</span></label>
                         <div class="col-md-8 col-xs-12">
                             <div class="">
                                <select class="form-control" name="product_id[]" required="" multiple="">
                                   @foreach($getproduct as $value)
                                @php
                                $selected = '';
                                @endphp
                              @if(!empty($getcatalog))
                                @foreach($productdata as $options)
                              @if($options->id == $value->id)
                                    @php
                                    $selected = 'selected';
                                    @endphp
                              @endif
                                @endforeach
                              @endif
                                <option {{ $selected }} value="{{ $value->id }}">{{ $value->product_name }}</option>
                             @endforeach
                                </select>
                             </div>
                         </div>
                  </div>


                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Image </span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input type="file" class="form-control" name="catalog_image"/>(You can change image)
                        <img alt="image name" src="{{ url('public/images/catalog/'.$getcatalog->catalog_image) }}" style="width:70px; height:70px;" />
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
