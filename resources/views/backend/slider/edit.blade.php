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
