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
                     <label class="col-md-2 col-xs-12 control-label">Sub Category Name </span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <select id="sub_cat_id" name="sub_cat_id" class="form-control">
                              <option value="{{$getproduct->subcategory->id}}">
                                 {{$getproduct->subcategory->sub_cat_name}}</option>
                              @foreach($getsubcategory as $subcategoryData)
                              <option value="{{$subcategoryData->id}}">{{$subcategoryData->sub_cat_name}}</option>
                              @endforeach
                           </select>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Sale Name </span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <select id="sale_id" name="sale_id" class="form-control">
                              @if(!@empty($getproduct->sale))
                              <option value="{{$getproduct->sale->id}}">{{$getproduct->sale->sale_title}}</option>
                              @endif
                              @foreach($getsale as $saleData)
                              <option value="{{$saleData->id}}">{{$saleData->sale_title}}</option>
                              @endforeach
                           </select>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Product Name</label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="product_name" value="{{ $getproduct->product_name }}" placeholder="Product Name"
                              type="text" required class="form-control" />
                           <span style="color:red">{{ $errors->first('product_name') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Description</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="description" value="{{ $getproduct->description }}" placeholder="Description"
                              type="text" class="form-control" />
                           <span style="color:red">{{ $errors->first('description') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Price </span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="price" value="{{ $getproduct->price }}" placeholder="Price" type="text"
                              class="form-control" />
                           <span style="color:red">{{ $errors->first('price') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Quantity </span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           {{-- <input name="number" value="{{ old('quantity') }}" placeholder="Product" type="text"
                              class="form-control" /> --}}
                           <input type="number" name="quantity" value="{{ $getproduct->quantity }}" class="form-control"
                              placeholder="Quantity" min=1 oninput="validity.valid||(value='');" />
                           <span style="color:red">{{ $errors->first('quantity') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Offer </span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="offer" value="{{ $getproduct->offer }}" placeholder="Offer" type="number"
                              class="form-control" min=1 max="99" oninput="validity.valid||(value='');" />
                           <span style="color:red">{{ $errors->first('offer') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Short Description</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="sort_desc" value="{{ $getproduct->sort_desc }}" placeholder="Short Description"
                              type="text" class="form-control" />
                           <span style="color:red">{{ $errors->first('sort_desc') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Manufacturing Address</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           @foreach ($getproduct->manufacturing as $item)
                           <input name="address" value="{{ $item->address }}" placeholder="Manufacturing Address"
                              type="text" class="form-control" />
                           <span style="color:red">{{ $errors->first('address') }}</span>
                           @endforeach
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Manufacturing City</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           @foreach ($getproduct->manufacturing as $item)
                           <input name="city" value="{{  $item->city }}" placeholder="Manufacturing City" type="text"
                              class="form-control" />
                           <span style="color:red">{{ $errors->first('city') }}</span>
                           @endforeach
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Manufacturing Contry</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           @foreach ($getproduct->manufacturing as $item)
                           <input name="contry" value="{{  $item->contry }}" placeholder="Manufacturing Contry"
                              type="text" class="form-control" />
                           <span style="color:red">{{ $errors->first('contry') }}</span>
                           @endforeach
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Manufacturing State</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           @foreach ($getproduct->manufacturing as $item)
                           <input name="state" value="{{  $item->state }}" placeholder="Manufacturing State" type="text"
                              class="form-control" />
                           <span style="color:red">{{ $errors->first('state') }}</span>
                           @endforeach
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Manufacturing Zip-Code</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           @foreach ($getproduct->manufacturing as $item)
                           <input name="zip_code" value="{{  $item->zip_code }}" placeholder="Manufacturing Zip-Code"
                              type="text" class="form-control" />
                           <span style="color:red">{{ $errors->first('zip_code') }}</span>
                           @endforeach
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Manufacturing By</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           @foreach ($getproduct->manufacturing as $item)
                           <input name="manufacture_by" value="{{  $item->manufacture_by }}"
                              placeholder="Manufacturing By" type="text" class="form-control" />
                           <span style="color:red">{{ $errors->first('manufacture_by') }}</span>
                           @endforeach
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Manufacturing Date</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           @foreach ($getproduct->manufacturing as $item)
                           <input name="manufacture_date" value="{{  $item->manufacture_date }}"
                              placeholder="Manufacturing Date" type="text" class="form-control" />
                           <span style="color:red">{{ $errors->first('manufacture_date') }}</span>
                           @endforeach
                        </div>
                     </div>
                  </div>


                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Color </span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           @foreach($getallcolor as $value)
                           {{-- {{ dd($value) }} --}}
                           @php
                           $selected = '';
                           @endphp
                           @if(!empty($getproduct))
                           @foreach($getcolor as $options)
                           {{-- {{ dd($value) }} --}}
                           @if($options->color == $value)
                           @php
                           $selected = 'checked';
                           @endphp
                           @endif
                           @endforeach
                           @endif
                           <input {{ $selected }} class="form-check-input" style="margin: 5px 6px 0px" type="checkbox"
                              value="{{  $value  }}" name="color[]">{{ $value }}
                           {{-- <option {{ $selected }} value="{{ $value->id }}">{{ $value->color }}</option> --}}
                           @endforeach
                           <span style="color:red">{{ $errors->first('color') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Size </span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           @foreach($getallsize as $value)
                           @php
                           $selected = '';
                           @endphp
                           @if(!empty($getproduct))
                           @foreach($getsize as $options)
                           @if($options->size == $value)
                           @php
                           $selected = 'checked';
                           @endphp
                           @endif
                           @endforeach
                           @endif
                           <input {{ $selected }} class="form-check-input" style="margin: 5px 6px 0px" type="checkbox"
                              value="{{  $value  }}" name="size[]">{{ $value }}
                           @endforeach
                           <span style="color:red">{{ $errors->first('size') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Brand </span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           @foreach($getallbrand as $value)
                           @php
                           $selected = '';
                           @endphp
                           @if(!empty($getproduct))
                           @foreach($getbrand as $options)
                           @if($options->brand == $value)
                           @php
                           $selected = 'checked';
                           @endphp
                           @endif
                           @endforeach
                           @endif
                           <input {{ $selected }} class="form-check-input" style="margin: 5px 6px 0px" type="checkbox"
                              value="{{  $value  }}" name="brand[]">{{ $value }}
                           @endforeach
                           <span style="color:red">{{ $errors->first('brand') }}</span>
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
                           {{-- <img alt="image name" src="{{ url('public/images/product/'.$getproduct->img) }}"
                              style="width:70px; height:70px;" /> --}}
                        </div>
                     </div>
                  </div>


                  {{-- <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Board Sub Option</label>
                     <div class="col-md-8 col-xs-12">
                        <table class="table">
                           <tr>
                              <th>STD Level</th>
                              <th>Action</th>
                           </tr>
                           <tr>
                              <td><input class="form-control" name="option[100][board_std_level_name]" type="text"></td>
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
                  <span id="getNewMainOption"></span> --}}

                  @if(!empty($getproduct))
       
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">More Description</label>
                     <div class="col-md-8 col-xs-12">
                        <table class="table">
                           <tr>
                              <th>Title</th>
                              <th>Description</th>
                              <th>Action</th>
                           </tr>
                             @php
                    $i = 0;
                    @endphp
                   @forelse($getproduct->productdetails as $option)
                   {{-- {{ dd($option) }} --}}
                            <tr>
                                 <input type="hidden" value="{{ $option->id }}" name="option[{{ $i }}][id]" class="form-control">
                               <td><input  class="form-control"  value="{{ $option->title }}" name="option[{{ $i }}][title]" type="text"></td>
                               <td><input  class="form-control"  value="{{ $option->title_description }}" name="option[{{ $i }}][title_description]" type="text">
                                  {{-- @if(!empty($option->board_std_level_image))
                             {{--    <img src="{{ url('upload/book/'.$option->board_std_level_image) }}" style="height:100px;"> --}}
                               {{-- <img src="{{ url($option->board_std_level_image) }}" style="height:100px;">  --}}
                                  {{-- @endif --}}
                               </td>
                               <td>
                                <a onclick="return confirm('Are you sure you want to delete this detail item?');" href="{{url('admin/product/product_detail_destroy/'.$option->id) }}" class="btn btn-danger">Remove</a>
                              </td>
                            </tr>
                           @php
                         $i++;
                         @endphp
                         @empty
                         @endforelse
                         </table>
                      </div>
                   </div>
                   @endif
          ​
          <div class="form-group">
            <label class="col-md-2 col-xs-12 control-label">More Description</label>
            <div class="col-md-8 col-xs-12">
               <table class="table">
                  <tr>
                     <th>Title</th>
                     <th>Description</th>
                     <th>Action</th>
                  </tr>
                  <tr>
                     {{-- <td><input  class="form-control"  placeholder="Title" name="option[100][main_option][1][title]" type="text"></td> 
                     <td><input  class="form-control" placeholder="Description" name="option[100][main_option][1][title_description]" type="text"></td> --}}
                     <td><input  class="form-control"  placeholder="Title" name="option[100][title]" type="text"></td>
                     <td><input  class="form-control number" placeholder="Description" name="option[100][title_description]" type="text"></td>
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
{{-- <script type="text/javascript">
   var item_row = 101;
   $("body").delegate(".add_row", "click", function (e) {
      var id = $(this).attr('id');
      e.preventDefault();
      // var html = '';
      html = '<tr><td><input  class="form-control" required name="option[' + item_row + '][board_std_level_name]" type="text"></td>\n\
              <td><a href="#" class="item_remove btn btn-danger">Remove</a></td>\n\
              </tr>';
      $("#item_below_row" + id).before(html);
      item_row++;
   });
   $('body').delegate(".item_remove", "click", function (e) {
      e.preventDefault();
      $(this).parent().parent().remove();
   });
</script> --}}


<script type="text/javascript">
   var item_row = 101;
    $("body").delegate(".add_row","click",function(e) {
       var id = $(this).attr('id');
       e.preventDefault();
       // var html = '';
       html    ='<tr><td><input  class="form-control" required name="option['+item_row+'][title]" placeholder="Title" type="text"></td>\n\
       <td><input  class="form-control" name="option['+item_row+'][title_description]"placeholder="Description" type="text"></td>\n\
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