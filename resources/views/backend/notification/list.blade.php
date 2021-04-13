@extends('backend.layouts.app')
​
@section('style')
	<style type="text/css">
		
	</style>
@endsection
​
@section('content')
​
  <ul class="breadcrumb">
            <li><a href="">Notification</a></li>
            <li><a href="">Send Notification </a></li>
        </ul>
        
        <div class="page-title">                    
            <h2><span class="fa fa-arrow-circle-o-left"></span> Send Notification </h2>
        </div>
​
         <div class="page-content-wrap">
            <div class="row">
                <div class="col-md-12">
​
  				{{-- Section Start --}}
  				  @include('message')
​
  				  <form class="form-horizontal" method="post" action="{{ url('admin/notification') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"> Send Notification</h3>
                                </div>
                                <div class="panel-body">
                                
                                 <div class="form-group">
                                  <label class="col-md-3 col-xs-12 control-label">Title <span style="color:red"> *</span></label>
                                      <div class="col-md-7 col-xs-12">
                                          <div class="">
                                              <input name="title" placeholder="Title" type="text" required class="form-control" />
                                              <span style="color:red">{{  $errors->first('title') }}</span>
                                          </div>
                                      </div>
                                  </div>
​
                                  <div class="form-group">
                                  <label class="col-md-3 col-xs-12 control-label">Notification <span style="color:red"> *</span></label>
                                      <div class="col-md-7 col-xs-12">
                                          <div class="">
                                              <textarea name="message" required placeholder="Notification" type="text" class="form-control" /></textarea>
                                              
                                          </div>
                                      </div>
                                  </div>
                                  
                                </div>
                                <div class="panel-footer">
                                    <button class="btn btn-primary pull-right">Submit</button>
                                </div>
                            </div>
                        </form>
​
                {{-- Section End --}}
                    
                </div>
            </div>
        </div>
​
​
@endsection
  @section('script')
  <script type="text/javascript">
  
  </script>
@endsection