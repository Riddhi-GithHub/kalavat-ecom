@extends('backend.layouts.app')
  @section('style')
    <style type="text/css">
      
    </style>
  @endsection 
@section('content')

        <ul class="breadcrumb">
            <li><a href="">User</a></li>
            <li><a href="">Edit User</a></li>
        </ul>
        
        <div class="page-title">                    
            <h2><span class="fa fa-arrow-circle-o-left"></span> Edit User</h2>
        </div>

         <div class="page-content-wrap">
            <div class="row">
                <div class="col-md-12">

                  {{-- start --}}

         <form class="form-horizontal" method="post" action="{{ url('admin/user/edit/'.$getuser->id) }}" enctype="multipart/form-data">
          {{ csrf_field() }}
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-title"> Edit User</h3>
               </div>
               <div class="panel-body">
                 
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Username <span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="fullname" readonly value="{{ $getuser->fullname }}" placeholder="Username" type="text" required class="form-control" />
                           <span style="color:red">{{  $errors->first('fullname') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Email <span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="email" readonly value="{{ $getuser->email }}" placeholder="Email" type="text" required class="form-control" />
                            <span style="color:red">{{  $errors->first('email') }}</span>
                        </div>
                     </div>
                  </div>

                   <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Password <span style="color:red"> *</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="password" value="" placeholder="Password" type="text" class="form-control" />
                             <span style="color:red">{{  $errors->first('password') }}</span>
                               (Leave blank if you are not changing the password)
                        </div>
                     </div>
                  </div>

                   <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">User Type <span style="color:red">*</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <select name="is_admin" class="form-control">
                              <option {{ ($getuser->is_admin == '1')?'selected':'' }} value="1">Super Admin</option>
                              <option {{ ($getuser->is_admin == '2')?'selected':'' }} value="2">Admin</option>
                           </select>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Status <span style="color:red">*</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <select name="status" class="form-control">
                              <option {{ ($getuser->status == '0')?'selected':'' }} value="0">Active</option>
                              <option {{ ($getuser->status == '1')?'selected':'' }} value="1">Inactive</option>
                           </select>
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
