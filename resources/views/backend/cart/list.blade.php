@extends('backend.layouts.app')
@section('style')
<style type="text/css">

</style>
@endsection
@section('content')

<ul class="breadcrumb">
    <li><a href="">Cart </a></li>
    <li><a href="">Cart List</a></li>
</ul>

<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span> Cart List</h2>
</div>

<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            {{-- start --}}
            @include('message')
            {{-- Add Menu --}}
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Cart  Search</h3>
                </div>
                <div class="panel-body" style="overflow: auto;">
                    <form action="" method="get">
                        <div class="col-md-3">
                            <label>ID</label>
                            <input type="text" value="{{ Request()->cart_id }}" class="form-control" placeholder="ID"
                                name="cart_id">
                        </div>
                        {{-- <div class="col-md-3">
                            <label>User Name</label>
                            <input type="text" class="form-control" value="{{ Request()->fullname }}" placeholder="User Name"
                                name="fullname">
                        </div> --}}
                        <div class="col-md-3">
                            <label>Product Name</label>
                            <input type="text" class="form-control" value="{{ Request()->product_name }}"
                                placeholder="Product Name" name="product_name">
                        </div>
                        <div style="clear: both;"></div>
                        <br>
                        <div class="col-md-12">
                            <input type="submit" class="btn btn-primary" value="Search">
                            <a href="{{ url('admin/cartitem') }}" class="btn btn-success">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
            <!-- START BASIC TABLE SAMPLE -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Cart List</h3>
                </div>
                <div class="panel-body" style="overflow: auto;">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Size</th>
                                <th>Color</th>
                                <th>Total Price</th>
                                <th>Created Date</th>
                                {{-- <th>Action</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($getrecord as $value)
                            <tr>
                                <td> {{ $value->cart_id }}</td>
                                <td> {{ $value->user->fullname }}</td>
                                <td>{{ $value->product->product_name }}</td>
                                <td>{{ $value->quantity }}</td>
                                <td>{{ $value->size }}</td>
                                <td>{{ $value->color }}</td>
                                <td>{{ $value->sub_total_price }}</td>
                                <td> {{ $value->created_at->format('d-m-Y h:i A') }}</td>
                                {{-- <td>
                                     <form method="get" action="{{ route('cart.delete', $value->cart_id) }}"> 
                                        <button type="submit" class="btn btn-danger btn-rounded btn-sm"
                                            onclick="return confirm('Sure Want Delete?')"><span
                                                class="fa fa-trash-o"></span></button>
                                        <div class="modal" id="mdelete" role="dialog" aria-labelledby="moddelete">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="moddelete">Confirm Delete</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to delete?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="hidden" name="txtid" id="txtid" />
                                                        <input type="text" name="uid" id="uid" />
                                                        <button type="button" class="btn btn-danger "
                                                            data-dismiss="modal">No</button>
                                                        <span class="text-right">
                                                            <button type="button"
                                                                class="btn btn-primary btndelete">Yes</button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </td> --}}
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

</script>
@endsection