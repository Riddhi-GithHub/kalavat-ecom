@extends('backend.layouts.app')
  @section('style')
    <style type="text/css">
      
    </style>
  @endsection 
@section('content')

        <ul class="breadcrumb">
            <li><a href="">User</a></li>
            <li><a href="">View User</a></li>
        </ul>
        
        <div class="page-title">                    
            <h2><span class="fa fa-arrow-circle-o-left"></span> View User</h2>
        </div>

         <div class="page-content-wrap">
            <div class="row">
                <div class="col-md-12">

                  {{-- start --}}

                  <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">

                     <div class="panel panel-default">
                     <div class="panel-heading">
                     <h3 class="panel-title">View User</h3>
                     </div>
                     <div class="panel-body">
                     <div class="form-group">
                     <label class="col-md-3 control-label">
                     User ID :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                      {{ $getuser->id }}
                     </div>
                     </div>
                     
                     <div class="form-group">
                     <label class="col-md-3 control-label">
                     Username :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                      {{ $getuser->username }}
                     </div>
                     </div>

                     <div class="form-group">
                      <label class="col-md-3 control-label">
                      Email :
                      </label>
                      <div class="col-sm-5" style="margin-top: 8px;">
                       {{ $getuser->email }}
                      </div>
                      </div>
                     
                      <div class="form-group">
                        <label class="col-md-3 control-label">
                        Is_admin :
                        </label>
                        <div class="col-sm-5" style="margin-top: 8px;">
                          @if($getuser->is_admin == '1') Super Admin
                          @elseif($getuser->is_admin == '2') Admin
                          @endif
                        </div>
                        </div>
                     </div>
                     <div class="panel-footer">
                     <a class="btn btn-primary pull-right" href="{{ url('admin/user') }}">Back</a>
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
