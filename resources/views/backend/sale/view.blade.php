@extends('backend.layouts.app')
  @section('style')
    <style type="text/css">
      
    </style>
  @endsection 
@section('content')

        <ul class="breadcrumb">
            <li><a href="">Sale</a></li>
            <li><a href="">View Sale</a></li>
        </ul>
        
        <div class="page-title">                    
            <h2><span class="fa fa-arrow-circle-o-left"></span> View Sale</h2>
        </div>

         <div class="page-content-wrap">
            <div class="row">
                <div class="col-md-12">
                  {{-- start --}}
                  <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">

                     <div class="panel panel-default">
                     <div class="panel-heading">
                     <h3 class="panel-title">View Sale</h3>
                     </div>
                     <div class="panel-body">
                     <div class="form-group">
                     <label class="col-md-3 control-label">
                     Sale ID :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                      {{ $getsale->id }}
                     </div>
                     </div>
                     
                     <div class="form-group">
                     <label class="col-md-3 control-label">
                     Sale Title :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                      {{ $getsale->sale_title }}
                     </div>
                     </div>

                     <div class="form-group">
                      <label class="col-md-3 control-label">
                      Sale Description :
                      </label>
                      <div class="col-sm-5" style="margin-top: 8px;">
                        {{ $getsale->sale_description }}
                      </div>
                      </div>

                     <div class="panel-footer">
                     <a class="btn btn-primary pull-right" href="{{ url('admin/sale') }}">
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
