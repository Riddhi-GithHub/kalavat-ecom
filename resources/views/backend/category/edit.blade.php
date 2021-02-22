@extends('backend.layouts.app')
  @section('style')
    <style type="text/css">
      
    </style>
  @endsection 
@section('content')

        <ul class="breadcrumb">
            <li><a href="">Categoey</a></li>
            <li><a href="">Edit Categoey</a></li>
        </ul>
        
        <div class="page-title">                    
            <h2><span class="fa fa-arrow-circle-o-left"></span> Edit Categoey</h2>
        </div>

         <div class="page-content-wrap">
            <div class="row">
                <div class="col-md-12">

                  {{-- start --}}

         <form class="form-horizontal" method="post" action="{{ route('category.update',$getcategory->id) }}" enctype="multipart/form-data">
          {{ csrf_field() }}
          @method('put')
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-title"> Edit Categoey</h3>
               </div>
               <div class="panel-body">
                 
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">CategoryName </span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="cat_name" value="{{ $getcategory->cat_name }}" placeholder="Category Name" type="text" required class="form-control" />
                           <span style="color:red">{{  $errors->first('cat_name') }}</span>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Image </span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input type="file" class="form-control" name="image"/>(You can change image)
                        <img alt="image name" src="{{ url('public/images/category/'.$getcategory->image) }}" style="width:70px; height:70px;" />
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
