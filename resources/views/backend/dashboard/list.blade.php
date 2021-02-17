@extends('backend.layouts.app')
  @section('style')
    <style type="text/css">
      
    </style>
  @endsection 
@section('content')

        <ul class="breadcrumb">
            <li><a href="">Dashboard</a></li>
            <li><a href="">Dashboard List</a></li>
        </ul>
        
        <div class="page-title">                    
            <h2><span class="fa fa-arrow-circle-o-left"></span> Dashboard List</h2>
        </div>

         <div class="page-content-wrap">
            <div class="row">
                <div class="col-md-12">

                    {{-- start --}}
                    <img src="{{ url('public/img/dashboard.jpg') }}" style="display: block;margin-left: auto;margin-right: auto;max-height: 450px;" alt="">
                    {{-- End --}}
                    
                </div>
            </div>
        </div>
 
@endsection
  @section('script')
  <script type="text/javascript">
   
  </script>
@endsection





