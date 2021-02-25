@extends('backend.layouts.app')
@section('style')
<style type="text/css">

</style>
@endsection
@section('content')

<ul class="breadcrumb">
   <li><a href="">Sub Categoey</a></li>
   <li><a href="">Edit Sub Categoey</a></li>
</ul>

<div class="page-title">
   <h2><span class="fa fa-arrow-circle-o-left"></span> Edit Sub Categoey</h2>
</div>

<div class="page-content-wrap">
   <div class="row">
      <div class="col-md-12">
         {{-- start --}}
         <form class="form-horizontal" method="post" action="{{ route('subcategory.update',$getsubcategory->id) }}"
            enctype="multipart/form-data">
            {{ csrf_field() }}
            @method('put')
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-title"> Edit Sub Categoey</h3>
               </div>
               <div class="panel-body">
                  <div class="panel-body">
                     <div class="form-group">
                        <label class="col-md-2 col-xs-12 control-label">Category Name </span></label>
                        <div class="col-md-8 col-xs-12">
                           <div class="">
                              <select id="cat_id" name="cat_id" class="form-control">
                                 <option value="{{$getsubcategory->category->id}}">{{$getsubcategory->category->cat_name}}
                                 </option>
                                 @foreach($getcategory as $categoryData)
                                 <option value="{{$categoryData->id}}">{{$categoryData->cat_name}}</option>
                                 @endforeach
                              </select>
                           </div>
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="col-md-2 col-xs-12 control-label">Sub Category Name </span></label>
                        <div class="col-md-8 col-xs-12">
                           <div class="">
                              <input name="sub_cat_name" value="{{ $getsubcategory->sub_cat_name }}"
                                 placeholder="Sub Category Name" type="text" required class="form-control" />
                              <span style="color:red">{{ $errors->first('sub_cat_name') }}</span>
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