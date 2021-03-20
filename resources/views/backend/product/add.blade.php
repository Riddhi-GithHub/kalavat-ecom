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
                           <span style="color:red">{{  $errors->first('cat_id') }}</span>
                        </div>
                     </div>
                  </div>
                  
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Select SubCategory <span style="color:red">*</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <select id="sub_cat_id" name="sub_cat_id" class="form-control">
                              <option selected disabled>Select SubCategory</option>
                              @foreach($subcategory as $subcategoryData)
                              <option value="{{$subcategoryData->id}}">{{$subcategoryData->sub_cat_name}}</option>
                              @endforeach
                           </select>
                           <span style="color:red">{{  $errors->first('sub_cat_id') }}</span>
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
                     <label class="col-md-2 col-xs-12 control-label">Long Description<span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="description" value="{{ old('description') }}" placeholder="Long Description" type="text" class="form-control" />
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
                           <input name="offer" value="{{ old('offer') }}" placeholder="Offer" type="number" class="form-control" />
                           <span style="color:red">{{  $errors->first('offer') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Short Description<span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="sort_desc" value="{{ old('sort_desc') }}" placeholder="Short Description" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('sort_desc') }}</span>
                        </div>
                     </div>
                  </div>

                  {{-- <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Color <span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="color" value="{{ old('color') }}" placeholder="Color" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('color') }}</span>
                        </div>
                     </div>
                  </div> --}}

                  {{-- <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Select Color <span style="color:red">*</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <select id="color" name="color" class="form-control">
                              <option selected disabled>Select Color</option>
                              <option value="red">Red</option>
                              <option value="blue">blue</option>
                              <option value="black">black</option>  
                              <option value="black">gray</option>  
                              <option value="black">pink</option>  
                           </select>
                        </div>
                     </div>
                  </div> --}}

                  {{-- <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Select Size <span style="color:red">*</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <select id="size" name="size" class="form-control">
                              <option selected disabled>Select Size</option>
                              <option value="s">S</option>
                              <option value="m">M</option>
                              <option value="l">L</option>
                              <option value="xl">XL</option>
                              <option value="xxl">XXL</option>
                           </select>
                        </div>
                     </div>
                  </div> --}}

                  {{-- <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Size <span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="size" value="{{ old('size') }}" placeholder="Size" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('size') }}</span>
                        </div>
                     </div>
                  </div> --}}

                  {{-- <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Brand <span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="brand" value="{{ old('brand') }}" placeholder="Brand" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('brand') }}</span>
                        </div>
                     </div>
                  </div> --}}

                  {{-- <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">More Description<span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="title_description[]" value="{{ old('title_description') }}" placeholder="More Description" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('title_description') }}</span>
                        </div>
                     </div>
                  </div> --}}

                  {{-- <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Item Model Num<span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="item_model_num" value="{{ old('item_model_num') }}" placeholder="Item Model Num" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('item_model_num') }}</span>
                        </div>
                     </div>
                  </div> --}}

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Manufacturing Address<span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="address" value="{{ old('address') }}" placeholder="Manufacturing Address" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('address') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Manufacturing City<span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="city" value="{{ old('city') }}" placeholder="Manufacturing City" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('city') }}</span>
                        </div>
                     </div>
                  </div>
                  
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Manufacturing Contry<span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="contry" value="{{ old('contry') }}" placeholder="Manufacturing Contry" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('contry') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Manufacturing State<span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="state" value="{{ old('state') }}" placeholder="Manufacturing State" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('state') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Manufacturing Zip-Code<span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="zip_code" value="{{ old('zip_code') }}" placeholder="Manufacturing Zip-Code" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('zip_code') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Manufacturing By<span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="manufacture_by" value="{{ old('manufacture_by') }}" placeholder="Manufacturing By" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('manufacture_by') }}</span>
                        </div>
                     </div>
                  </div>
                  
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Manufacturing Date<span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="manufacture_date" value="{{ old('manufacture_date') }}" placeholder="Manufacturing Date" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('manufacture_date') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Color <span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input class="form-check-input" style="margin: 5px 6px 0px" type="checkbox" value="Red" name="color[]">Red
                           <input class="form-check-input" style="margin: 5px 6px 0px"  type="checkbox" value="Blue" name="color[]">Blue
                           <input class="form-check-input" style="margin: 5px 6px 0px"  type="checkbox" value="Black" name="color[]">Black
                           <input class="form-check-input" style="margin: 5px 6px 0px"  type="checkbox" value="White" name="color[]">White
                           <input class="form-check-input" style="margin: 5px 6px 0px"  type="checkbox" value="Pink" name="color[]">Pink
                           <input class="form-check-input" style="margin: 5px 6px 0px"  type="checkbox" value="Yellow" name="color[]">Yellow
                           <input class="form-check-input" style="margin: 5px 6px 0px"  type="checkbox" value="Orange" name="color[]">Orange
                           <input class="form-check-input" style="margin: 5px 6px 0px"  type="checkbox" value="Green" name="color[]">Green
                           <span style="color:red">{{  $errors->first('color') }}</span>
                        </div>
                     </div>
                  </div> 

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Size <span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input class="form-check-input" style="margin: 5px 6px 0px" type="checkbox" value="S" name="size[]">S
                           <input class="form-check-input" style="margin: 5px 6px 0px"  type="checkbox" value="M" name="size[]">M
                           <input class="form-check-input" style="margin: 5px 6px 0px"  type="checkbox" value="L" name="size[]">L
                           <input class="form-check-input" style="margin: 5px 6px 0px"  type="checkbox" value="XL" name="size[]">XL
                           <input class="form-check-input" style="margin: 5px 6px 0px"  type="checkbox" value="XXL" name="size[]">XXL
                           <input class="form-check-input" style="margin: 5px 6px 0px"  type="checkbox" value="XXXL" name="size[]">XXXL
                           <span style="color:red">{{  $errors->first('size') }}</span>
                        </div>
                     </div>
                  </div> 

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Brand <span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input class="form-check-input" style="margin: 5px 6px 0px" type="checkbox" value="adidas" name="brand[]">adidas
                           <input class="form-check-input" style="margin: 5px 6px 0px"  type="checkbox" value="adidas1" name="brand[]">adidas1
                           <input class="form-check-input" style="margin: 5px 6px 0px"  type="checkbox" value="diesel" name="brand[]">diesel
                           <input class="form-check-input" style="margin: 5px 6px 0px"  type="checkbox" value="naf naf" name="brand[]">naf naf
                           <input class="form-check-input" style="margin: 5px 6px 0px"  type="checkbox" value="champian" name="brand[]">champian
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

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">More Description Title</label>
                     <div class="col-md-8 col-xs-12">
                        <table class="table">
                           <tr>
                              <th>Add Title</th>
                              <th>Action</th>
                           </tr>
                           <tr>
                              <td><input  class="form-control" placeholder="More Description title" name="option[100][title]" type="text"></td>
                              <td><a href="#" class="item_remove btn btn-danger" placeholder="More Description Title">Remove</a></td>
                           </tr>
                           <tr id="item_below_row100">
                              <td colspan="100%">
                                 <button type="button" id="100" class="btn btn-primary add_row">Add</button>
                              </td>
                           </tr>
                        </table>
                     </div>
                  </div>
                  <span id="getNewMainOption"></span>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">More Description</label>
                     <div class="col-md-8 col-xs-12">
                        <table class="table">
                           <tr>
                              <th>Add Description</th>
                              <th>Action</th>
                           </tr>
                           <tr>
                              <td><input  class="form-control" placeholder="More Description" name="optiondesc[200][title_description]" type="text"></td>
                              <td><a href="#" class="item_remove btn btn-danger" placeholder="More Description">Remove</a></td>
                           </tr>
                           <tr id="item_below_row200">
                              <td colspan="100%">
                                 <button type="button" id="200" class="btn btn-primary add_row_new">Add</button>
                              </td>
                              {{-- <td><a href="#" class="item_remove btn btn-danger">Remove</a></td> --}}
                           </tr>
                        </table>
                     </div>
                  </div>
                  <span id="getNewMainOption"></span>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Sub Option</label>
                     <div class="col-md-8 col-xs-12">
                        <table class="table">
                           <tr>
                              <th>Name</th>
                              <th>Price</th>
                              <th>Action</th>
                           </tr>
                           <tr>
                              <td><input  class="form-control"  name="option[100][main_option][1][option_name]" type="text"></td>
                              <td><input  class="form-control number" name="option[100][main_option][1][option_price]" type="text"></td>
                              <td><a href="#" class="item_remove btn btn-danger">Remove</a></td>
                           </tr>
                           <tr id="item_below_row100">
                              <td colspan="100%">
                                 <button type="button" id="100" class="btn btn-primary add_row">Add</button>
                              </td>
                           </tr>
                        </table>
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
  var item_row = 101;
   $("body").delegate(".add_row","click",function(e) {
      var id = $(this).attr('id');
      e.preventDefault();
      // var html = '';
      html    ='<tr><td><input  class="form-control" required name="option['+item_row+'][title]" type="text"></td>\n\
              <td><a href="#" class="item_remove btn btn-danger">Remove</a></td>\n\
              </tr>';
      $("#item_below_row"+id).before(html);
      item_row++;
   });
   $('body').delegate(".item_remove", "click", function(e){
    e.preventDefault();
    $(this).parent().parent().remove();
   });
  </script>

<script type="text/javascript">
   var item_row = 201;
    $("body").delegate(".add_row_new","click",function(e) {
       var id = $(this).attr('id');
       e.preventDefault();
       // var html = '';
       html    ='<tr><td><input  class="form-control" required name="optiondesc['+item_row+'][title_description]" type="text"></td>\n\
               <td><a href="#" class="item_remove btn btn-danger">Remove</a></td>\n\
               </tr>';
       $("#item_below_row"+id).before(html);
       item_row++;
    });
    $('body').delegate(".item_remove", "click", function(e){
     e.preventDefault();
     $(this).parent().parent().remove();
    });
   </script>

@endsection

