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

                      {{-- <div class="form-group">
                        <label class="col-md-3 control-label">
                        Image :
                        </label>
                        <div class="col-sm-5" style="margin-top: 8px;">
                        <img alt="image name" src="{{ url('public/images/user/'.$getuser->image) }}" style="width:70px; height:70px;" />
                        </div>
                        </div> --}}


                        <div class="form-group">
                          <label class="col-md-3 control-label">
                          Image :
                          </label>
                          <div class="col-sm-5" style="margin-top: 8px;">
                        @empty($getuser->image)
                        {{-- <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" style="width:70px; height:70px;"> --}}
                        <img src="{{ url('public/images/blank-profile.png') }}" alt="Admin" class="rounded-circle" style="width:70px; height:70px;">
                        @else
                        <img alt="image name" src="{{ url('public/images/user/'.$getuser->image) }}" class="rounded-circle" style="width:70px; height:70px;" />
                        @endempty
                      </div>
                    </div>

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
                        Mobile :
                        </label>
                        <div class="col-sm-5" style="margin-top: 8px;">
                         {{ $getuser->mobile }}
                        </div>
                        </div>

                        <div class="form-group">
                          <label class="col-md-3 control-label">
                          DOB :
                          </label>
                          <div class="col-sm-5" style="margin-top: 8px;">
                           {{ $getuser->dob }}
                          </div>
                          </div>

                        <div class="form-group">
                          <label class="col-md-3 control-label">
                          Gender :
                          </label>
                          <div class="col-sm-5" style="margin-top: 8px;">
                            {{ $getuser->gender }}
                          </div>
                          </div>

                        {{-- <div class="form-group">
                          <label class="col-md-3 control-label">
                          Address :
                          </label>
                          <div class="col-sm-5" style="margin-top: 8px;">
                            {{ $getuser->address->address }} , {{ $getuser->address->city }},
                            {{ $getuser->address->state }},  {{ $getuser->address->contry }}, 
                            {{ $getuser->address->zip_code }}.
                          </div>
                          </div> --}}

                          <div class="form-group">
                            <label class="col-md-3 control-label">
                            Address :
                            </label>
                            <div class="col-sm-5" style="margin-top: 8px;">
                              {{-- @foreach ($getuser->address as $item) --}}
                              {{ $getuser->address }} , {{ $getuser->city }},
                              {{ $getuser->contry }}, {{ $getuser->state }},
                              {{ $getuser->zip_code }}.
                              {{-- @endforeach --}}
                            </div>
                            </div>
                     
                      <div class="form-group">
                        <label class="col-md-3 control-label">
                        User Type :
                        </label>
                        <div class="col-sm-5" style="margin-top: 8px;">
                          @if($getuser->is_admin == '1') Super Admin
                          @elseif($getuser->is_admin == '2') Admin
                          @endif
                        </div>
                        </div>

                     </div>
                     <div class="panel-footer">
                     <a class="btn btn-primary pull-right" href="{{ url('admin/user') }}">
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
