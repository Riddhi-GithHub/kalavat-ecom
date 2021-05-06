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

            <a href="{{ route('product.create') }}" class="btn btn-primary" title="Add New Product"><i class="fa fa-plus"></i>&nbsp;&nbsp;<span class="bold">Add New Product</span></a>

                    <a href="{{ route('product.import_excel') }}" class="btn btn-primary" title="Add New Import Excel"><i class="fa fa-upload"></i>&nbsp;&nbsp;<span class="bold">Add New Import Excel </span></a> 

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
                            <label>Category Name</label>
                            <input type="text" class="form-control" value="{{ Request()->cat_name }}" placeholder="Category Name"
                                name="cat_name">
                        </div>
                        <div class="col-md-3">
                            <label>Product Name</label>
                            <input type="text" class="form-control" value="{{ Request()->product_name }}" placeholder="Product Name"
                                name="product_name">
                        </div>
                        <div class="col-md-3">
                            <label>Price</label>
                            <input type="text" class="form-control" value="{{ Request()->price }}" placeholder="Price"
                                name="price">
                        </div>
                        <div style="clear: both;"></div>
                        <br>
                        <div class="col-md-12">
                            <input type="submit" class="btn btn-primary" value="Search">
                            <a href="{{ url('admin/product') }}" class="btn btn-success">Reset</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- START BASIC TABLE SAMPLE -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Product List</h3>
                </div>
                {{-- @if(!empty(json_decode($manage_project->image)))
                @foreach(json_decode($manage_project->image) as $image)
                <div>
                    <img src="{{asset('/files/profile/'.$image)}}" class="slider-img" />
                </div>
                @endforeach
                @endif --}}
                <div class="panel-body" style="overflow: auto;">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category Name</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Offer</th>
                                <th>Total Price</th>
                                <th>Image/Video</th>
                                {{-- <th>Rating</th> --}}
                                {{-- <th>Created Date</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($getrecord as $key=>$value)
                            <tr>
                                <td> {{ $value->id }}</td>
                                <td>{{ $value->category->cat_name }}</td>
                                <td>{{ $value->product_name }}</td>
                                <td>{{ $value->price }}</td>
                                <td>{{ $value->quantity }}</td>
                                <td>{{ $value->offer }}</td>
                                <td>{{ $value['price'] * $value['quantity'] -
                                    ($value['price']*  $value->offer/100) }}</td>
                                <td>
                                    {{-- {{ dd($item) }} --}}
                                    {{-- {{ dd($extension[1] == $imageExtensions) }} --}}
                                    @if(($extension[$key] == 'jpg'))
                                        <img alt="image name" src="{{ url('public/images/product/'.$value->img) }}" 
                                        style="width:70px; height:70px;" />
                                    @else 
                                      <video src="{{ url('public/images/product/'.$value->img) }}" style="width:70px; height:70px;"> 
                                         {{-- <source src="{{ url('public/images/product/'.$value->img) }}" type="video/ogg">  --}}
                                    @endif
                                
                                </td>
                                {{-- <td>{{ $rating[$key] }}</td> --}}
 
                                {{-- <td> {{ $value->created_at->format('d-m-Y h:i A') }}</td> --}}
                                <td>
                                    <form method="get" action="{{ route('product.delete', $value->id) }}">
                                        <a href="{{ route('product.show',$value->id) }}"
                                            class="btn btn-primary btn-rounded btn-sm"><span
                                                class="fa fa-eye"></span></a>
                                        <a href="{{ route('product.edit',$value->id) }}"
                                            class="btn btn-success btn-rounded btn-sm"><span
                                                class="fa fa-pencil"></span></a>
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