@extends('backend.layouts.app')
  @section('style')
    <style type="text/css">
      
    </style>
  @endsection 
@section('content')

        <ul class="breadcrumb">
            <li><a href="">Sale</a></li>
            <li><a href="">Edit Sale</a></li>
        </ul>
        
        <div class="page-title">                    
            <h2><span class="fa fa-arrow-circle-o-left"></span> Edit Sale</h2>
        </div>
         <div class="page-content-wrap">
            <div class="row">
                <div class="col-md-12">
                  {{-- start --}}

         <form class="form-horizontal" method="post" action="{{ route('sale.update',$getsale->id) }}" enctype="multipart/form-data">
          {{ csrf_field() }}
          @method('put')
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-title"> Edit Sale</h3>
               </div>
               <div class="panel-body">
                 
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Sale Title  </span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="sale_title" value="{{ $getsale->sale_title }}" placeholder="Sale Title" type="text" required class="form-control" />
                           <span style="color:red">{{  $errors->first('sale_title') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Sale Description  </span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="sale_description" value="{{ $getsale->sale_description }}" placeholder="Sale Description" type="text" required class="form-control" />
                           <span style="color:red">{{  $errors->first('sale_description') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Sale End Date  </span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="sale_end_date" value="{{ date('Y-m-d', strtotime($getsale->sale_end_date) ) }}" placeholder="Sale End Date" type="text" required class="form-control" />
                           <span style="color:red">{{  $errors->first('sale_end_date') }}</span>
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
