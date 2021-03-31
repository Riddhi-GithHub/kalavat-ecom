@extends('backend.layouts.app')
  @section('style')
    <style type="text/css">
      
    </style>
  @endsection 
@section('content')

        <ul class="breadcrumb">
            <li><a href="">Category</a></li>
            <li><a href="">View Category</a></li>
        </ul>
        
        <div class="page-title">                    
            <h2><span class="fa fa-arrow-circle-o-left"></span> View Category</h2>
        </div>

         <div class="page-content-wrap">
            <div class="row">
                <div class="col-md-12">

                  {{-- start --}}

                  <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">

                     <div class="panel panel-default">
                     <div class="panel-heading">
                     <h3 class="panel-title">View Category</h3>
                     </div>
                     <div class="panel-body">
                     <div class="form-group">
                     <label class="col-md-3 control-label">
                     Category ID :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                      {{ $getcategory->id }}
                     </div>
                     </div>
                     
                     <div class="form-group">
                     <label class="col-md-3 control-label">
                     Category Name :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                      {{ $getcategory->cat_name }}
                     </div>
                     </div>

                     <div class="form-group">
                      <label class="col-md-3 control-label">
                      Image :
                      </label>
                      <div class="col-sm-5" style="margin-top: 8px;">
                      <img alt="image name" src="{{ url('public/images/category/'.$getcategory->image) }}" style="width:70px; height:70px;" />
                       {{-- {{ $getcategory->cat_name }} --}}
                      </div>
                      </div>

                     <div class="panel-footer">
                     <a class="btn btn-primary pull-right" href="{{ url('admin/category') }}">
                      <i class="fa fa-arrow-left"></i>&nbsp;&nbsp;<span class="bold">Back</span></a>
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
