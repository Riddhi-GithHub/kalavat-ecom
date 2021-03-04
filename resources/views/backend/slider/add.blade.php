@extends('backend.layouts.app')
  @section('style')
    <style type="text/css">
      
    </style>
  @endsection 
@section('content')

        <ul class="breadcrumb">
            <li><a href="">Slider</a></li>
            <li><a href="">Add Slider</a></li>
        </ul>
        
        <div class="page-title">                    
            <h2><span class="fa fa-arrow-circle-o-left"></span> Add Slider</h2>
        </div>

         <div class="page-content-wrap">
            <div class="row">
                <div class="col-md-12">

                  {{-- start --}}


         <form class="form-horizontal" method="post" action="{{ url('admin/slider/add') }}" enctype="multipart/form-data">
          {{ csrf_field() }}
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-title"> Add Slider</h3>
               </div>
               <div class="panel-body">
                 
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Slider Name <span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="slider_name" value="{{ old('slider_name') }}" placeholder="Slider Name" type="text" required class="form-control" />
                           <span style="color:red">{{  $errors->first('slider_name') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Slider Image <span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           {{-- <input name="brand" value="{{ old('brand') }}" placeholder="Product" type="text" class="form-control" /> --}}
                           <input type="file" class="form-control" name="slider_image"/>(can select only one image)
                           <span style="color:red">{{  $errors->first('slider_image') }}</span>
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
