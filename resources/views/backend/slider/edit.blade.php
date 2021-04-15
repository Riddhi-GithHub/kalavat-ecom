@extends('backend.layouts.app')
  @section('style')
    <style type="text/css">
      
    </style>
  @endsection 
@section('content')

        <ul class="breadcrumb">
            <li><a href="">Slider</a></li>
            <li><a href="">Edit Slider</a></li>
        </ul>
        
        <div class="page-title">                    
            <h2><span class="fa fa-arrow-circle-o-left"></span> Edit Slider</h2>
        </div>

         <div class="page-content-wrap">
            <div class="row">
                <div class="col-md-12">

                  {{-- start --}}

         <form class="form-horizontal" method="post" action="{{ url('admin/slider/update/'.$getslider->id) }}" enctype="multipart/form-data">
          {{ csrf_field() }}
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-title"> Edit Slider</h3>
               </div>
               <div class="panel-body">
                 
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Slider Name </span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="slider_name" value="{{ $getslider->slider_name }}" placeholder="Slider Name" type="text" required class="form-control" />
                           <span style="color:red">{{  $errors->first('slider_name') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Offer</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="offer" value="{{ $getslider->offer }}" placeholder="Offer" min=1  max="99" oninput="validity.valid||(value='');" type="number" class="form-control" />
                           <span style="color:red">{{  $errors->first('offer') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Discount</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="discount" value="{{ $getslider->discount }}" placeholder="Discount" min=1  max="99" oninput="validity.valid||(value='');" type="number" class="form-control" />
                           <span style="color:red">{{  $errors->first('discount') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Slider Image </span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input type="file" class="form-control" name="slider_image"/>(You can change image)
                        <img alt="image name" src="{{ url('public/images/slider/'.$getslider->slider_image) }}" style="width:70px; height:70px;" />
                        </div>
                     </div>
                  </div>
                  
                  <div id="myRadioGroup">
    
                     <div class="form-group">
                        <label class="col-md-2 col-xs-12 control-label">Type</span></label>
                        <div class="col-md-8 col-xs-12">

                           {{-- {{ dd($getslider->type) }} --}}
                           <input type="radio" name="type" value="1" {{ $getslider->type == '1' ? 'checked' : ''}}/>Category
                           <input type="radio" name="type" value="2" {{ $getslider->type == '2' ? 'checked' : ''}}/>SubCategory
                           <input type="radio" name="type" value="3" {{ $getslider->type == '3' ? 'checked' : ''}}/>Product

                            {{-- <input type="radio" name="type" value="4"/>Brand  --}}
                            <div id="Type1" class="desc">
                              <select  name="type_id"  class="form-control">
                                 <option selected disabled>Select Category</option>
                                 @foreach($category as $categoryData)
                                 <option value="{{$categoryData->id}}">{{$categoryData->cat_name}}</option>
                                 @endforeach
                              </select>
                           <span style="color:red">{{  $errors->first('type_id') }}</span>
                           </div>

                           <div id="Type2" class="desc" style="display: none;">
                              <select  name="type_id" class="form-control">
                                 <option selected disabled>Select SubCategory</option>
                                 @foreach($subcategory as $subcategoryData)
                                 <option value="{{$subcategoryData->id}}">{{$subcategoryData->sub_cat_name}}</option>
                                 @endforeach
                              </select>
                           <span style="color:red">{{  $errors->first('type_id') }}</span>
                           </div>

                           <div id="Type3" class="desc" style="display: none;">
                              <select id="product_id" name="type_id" class="form-control">
                                 <option selected disabled>Select Product</option>
                                 @foreach($product as $productData)
                                 <option value="{{$productData->id}}">{{$productData->product_name}}</option>
                                 @endforeach
                              </select>
                           <span style="color:red">{{  $errors->first('type_id') }}</span>
                           </div>
                           {{-- <div id="Type4" class="desc" style="display: none;">
                              <select id="product_id" name="type_id" class="form-control">
                                 <option selected disabled>Select Product</option>
                                 @foreach($brand as $brandData)
                                 <option value="{{$brandData->id}}">{{$brandData}}</option>
                                 @endforeach
                              </select>
                           </div> --}}
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
   <script>
   $(document).ready(function() {
     $("input[name$='type']").click(function() {
         var test = $(this).val();
 
         $("div.desc").hide();
         $("#Type" + test).show();
     });
 });
  </script>
@endsection
