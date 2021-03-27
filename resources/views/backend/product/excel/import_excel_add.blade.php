@extends('backend.layouts.app')
  @section('style')
    <style type="text/css">
      
    </style>
  @endsection 
@section('content')
        <ul class="breadcrumb">
            <li><a href="">Product Import Excel</a></li>
            <li><a href="">Add Product Import Excel</a></li>
        </ul>
        <div class="page-title">                    
            <h2><span class="fa fa-arrow-circle-o-left"></span> Add Product Import Excel</h2>
        </div>
         <div class="page-content-wrap">
            <div class="row">
                <div class="col-md-12">
                  {{-- start --}}
                  @include('message')
                  <a href="{{ url('admin/product') }}" class="btn btn-primary" title="Add Back"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;<span class="bold"> Back</span></a>
  
         <form class="form-horizontal" method="post" action="{{ route('product.import_store') }}" enctype="multipart/form-data">
          {{ csrf_field() }}
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-title"> Add Import Excel</h3>
               </div>
               <div class="panel-body">

               
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Product Import Excel <span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input type="file" class="form-control" name="file"/>
                           <span style="color:red">{{  $errors->first('file') }}</span>
                        </div>
                        <br>
                                      <a href="{{ url('public/excel/demo.csv') }}">Download demo file [ xlsx and csv ] Upload file</a>
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

