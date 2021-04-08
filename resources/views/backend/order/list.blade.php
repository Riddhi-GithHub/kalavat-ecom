@extends('backend.layouts.app')
@section('style')
<style type="text/css">

</style>
@endsection
@section('content')

<ul class="breadcrumb">
    <li><a href="">Order </a></li>
    <li><a href="">Order List</a></li>
</ul>

<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span> Order List</h2>
</div>

<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            {{-- start --}}
            @include('message')
            {{-- Add Menu --}}
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Order  Search</h3>
                </div>
                <div class="panel-body" style="overflow: auto;">
                    <form action="" method="get">
                        <div class="col-md-3">
                            <label>ID</label>
                            <input type="text" value="{{ Request()->order_detail_id }}" class="form-control" placeholder="ID"
                                name="order_detail_id">
                        </div>
                        <div class="col-md-3">
                            <label>User Name</label>
                            <input type="text" class="form-control" value="{{ Request()->fullname }}" placeholder="User Name"
                                name="fullname">
                        </div>
                        {{-- <div class="col-md-3">
                            <label>Product Name</label>
                            <input type="text" class="form-control" value="{{ Request()->product_name }}"
                                placeholder="Product Name" name="product_name">
                        </div> --}}
                         <div class="col-md-3">
                            <label>Tracking Number</label>
                            <input type="text" class="form-control" value="{{ Request()->tracking_num }}"
                                placeholder="Tracking Number" name="tracking_num">
                        </div>

                        <div style="clear: both;"></div>
                        <br>
                        <div class="col-md-12">
                            <input type="submit" class="btn btn-primary" value="Search">
                            <a href="{{ url('admin/order') }}" class="btn btn-success">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
            <!-- START BASIC TABLE SAMPLE -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Order List</h3>
                </div>
                <div class="panel-body" style="overflow: auto;">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User Name</th>
                                {{-- <th>Product Name</th> --}}
                                <th>Tracking Number</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>Delivery Date</th>
                                <th>Status</th>
                                <th>Created Date</th>
                                {{-- <th>Action</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($getrecord as $value)
                            <tr>
                                <td> {{ $value->order_detail_id  }}</td>
                                {{-- <td> {{ $value->user->fullname }}</td> --}}
                                <td> {{ ($value->user->fullname ?  $value->user->fullname : '' ) }}</td>
                                {{-- <td>{{ $value->product->product_name }}</td> --}}
                                <td>{{ $value->tracking_num }}</td>
                                <td>{{ $value->total_quantity }}</td>
                                <td>{{ $value->total_price }}</td>
                                <td>{{ $value->delivery_date }}</td>
                                <td>
                                    <select class="form-control change_Status" id="{{ $value->order_detail_id }}">
                                      <option {{ ($value->status == '0' ? 'selected="selected"' : '' ) }} value="0">Processing</option>
                                      <option {{ ($value->status == '1' ? 'selected="selected"' : '' ) }} value="1">Deleiverd</option>
                                      <option {{ ($value->status == '2' ? 'selected="selected"' : '' ) }} value="2">Cancelled</option>
                                    </select>
                                </td>
                                <td> {{ $value->created_at->format('d-m-Y h:i A') }}</td>
                          
                            </tr>
                            @empty
                            <tr>
                                <td colspan="100%">Record not found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div style="float: right">
                        {{ $getrecord->appends(Illuminate\Support\Facades\Input::except('page'))->links() }}
                    </div>
                </div>
            </div>
            <!-- END BASIC TABLE SAMPLE -->
            {{-- End --}}
        </div>
    </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
  $(document).ready(function() {
    
    $('.change_Status').change(function(){
    var status_id = $(this).val();
    // alert(status_id);
    // die();
    var status_change_id = $(this).attr('id');
    // alert(status_change_id);
    // die();
     $.ajax({
           type:"GET",
           url: "{{ url('admin/changeStatus') }}",
           data: {status_id: status_id,status_change_id:status_change_id},
           dataType: 'JSON',
           success:function(data){
              // console.log(data.success)
              alert('Status successfully changed.');
           }
    });
 });
});

</script>
@endsection