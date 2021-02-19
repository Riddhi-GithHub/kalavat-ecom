@extends('backend.layouts.app')
@section('style')
<style type="text/css">

</style>
@endsection
@section('content')

<ul class="breadcrumb">
    <li><a href="">Product</a></li>
    <li><a href="">Product List</a></li>
</ul>

<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span> Product List</h2>
</div>

<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            {{-- start --}}
            @include('message')

            <a href="{{ route('product.create') }}" class="btn btn-primary" title="Add New Product"><i
                    class="fa fa-plus"></i>&nbsp;&nbsp;<span class="bold">Add New Product</span></a>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Product Search</h3>
                </div>

                <div class="panel-body" style="overflow: auto;">
                    <form action="" method="get">
                        <div class="col-md-3">
                            <label>ID</label>
                            <input type="text" value="{{ Request()->id }}" class="form-control" placeholder="ID"
                                name="id">
                        </div>
                        <div class="col-md-3">
                            <label>CategoryName</label>
                            <input type="text" class="form-control" value="{{ Request()->cat_name }}" placeholder="category name"
                                name="cat_name">
                        </div>
                        <div class="col-md-3">
                            <label>ProductName</label>
                            <input type="text" class="form-control" value="{{ Request()->product_name }}" placeholder="product name"
                                name="product_name">
                        </div>


                        <div style="clear: both;"></div>
                        <br>
                        <div class="col-md-12">
                            <input type="submit" class="btn btn-primary" value="Search">
                            <a href="{{ url('product') }}" class="btn btn-success">Reset</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- START BASIC TABLE SAMPLE -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Product List</h3>
                </div>


                <div class="panel-body" style="overflow: auto;">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>CategoryName</th>
                                <th>ProductName</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                {{-- <th>Image</th> --}}
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($getrecord as $value)
                            <tr>
                                <td> {{ $value->id }}</td>
                                <td>{{ $value->category->cat_name }}</td>
                                <td>{{ $value->product_name }}</td>
                                <td>{{ $value->price }}</td>
                                <td>{{ $value->quantity }}</td>
                                {{-- {{ dd($value->images[0]->images) }} --}}
                                {{-- <td>{{ Storage::url($value->images[0]->images) }}</td> --}}
                                {{-- Storage::url($i->images[0]->images) --}}
                                <td> {{ $value->created_at->format('d-m-Y h:i A') }}</td>

                                <td>
                                    <form method="post" action="{{ route('product.destroy', $value->id) }}">
                                        @csrf 
                                        @method('delete')
                                    {{-- <button class="btn btn-primary btn-rounded btn-sm"
                                        onClick="delete_row('trow_3');"><span class="fa fa-eye"></span></button> --}}
                                    <a href="{{ route('product.show',$value->id) }}"
                                        class="btn btn-primary btn-rounded btn-sm"><span class="fa fa-eye"></span></a>
                                    <a href="{{ route('product.edit',$value->id) }}"
                                        class="btn btn-success btn-rounded btn-sm"><span
                                            class="fa fa-pencil"></span></a>
                                    {{-- <button class="btn btn-danger btn-rounded btn-sm"><span
                                            class="fa fa-trash-o"></span></button> --}}
                                    <a href="#" class="btn btn-danger btn-rounded btn-sm mb-control"
                                        data-box="#mb-delete"><span class="fa fa-trash-o"></span></a>

                                    {{-- Delete Button Start--}}
                                   
                                    <div class="message-box animated fadeIn" id="mb-delete">
                                        <div class="mb-container">
                                            <div class="mb-middle">
                                                <div class="mb-title"><span class="fa fa-trash-o"></span> Delete Category?
                                                </div>
                                                <div class="mb-content">
                                                    <p>Are you sure you want to delete category?</p>
                                                    <p>Press No if youwant to continue work. Press Yes to delete category.
                                                    </p>
                                                </div>
                                                <div class="mb-footer">
                                                    <div class="pull-right">
                                                            <button class="btn btn-success btn-lg">Yes</button>
                                                            <button
                                                            class="btn btn-default btn-lg mb-control-close">No</button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Delete Button End --}}

                                </td>
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