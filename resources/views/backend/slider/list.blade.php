@extends('backend.layouts.app')
@section('style')
<style type="text/css">

</style>
@endsection
@section('content')

<ul class="breadcrumb">
    <li><a href="">Slider</a></li>
    <li><a href="">Slider List</a></li>
</ul>

<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span> Sliders List</h2>
</div>

<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">

            {{-- start --}}
            @include('message')
            <a href="{{ url('admin/slider/add') }}" class="btn btn-primary" title="Add New Slider"><i
                    class="fa fa-plus"></i>&nbsp;&nbsp;<span class="bold">Add New Slider</span></a>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Slider Search</h3>
                </div>

                <div class="panel-body" style="overflow: auto;">

                    <form action="" method="get">
                        <div class="col-md-3">
                            <label>ID</label>
                            <input type="text" value="{{ Request()->id }}" class="form-control" placeholder="ID"
                                name="id">
                        </div>
                        <div class="col-md-3">
                            <label>Slider Name</label>
                            <input type="text" class="form-control" value="{{ Request()->slider_name }}"
                                placeholder="Slider Name" name="slider_name">
                        </div>

                        <div style="clear: both;"></div>
                        <br>
                        <div class="col-md-12">
                            <input type="submit" class="btn btn-primary" value="Search">
                            <a href="{{ url('admin/slider') }}" class="btn btn-success">Reset</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- START BASIC TABLE SAMPLE -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Sliders List</h3>
                </div>

                <div class="panel-body" style="overflow: auto;">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Slider Name</th>
                                <th>Slider Type</th>
                                <th>Slider Offer</th>
                                <th>Slider Discount</th>
                                <th>Slider Image</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($getrecord as $value)
                            <tr>
                                <td> {{ $value->id }}</td>
                                <td>{{ $value->slider_name }}</td>
                                {{-- <td>{{ $value->type == '1' ? 'category' : $value->type == '2' ? 'sub' : 'none'}} --}}
                                    {{-- $value->type == '3' ? 'product' : $value->type == '4' ? 'brand' : 'no'}}</td> --}}
                               
                                    <td> @if($value->type == 1) <?php echo "category"; ?>
                                        @elseif($value->type == 2) <?php echo "subcategory"; ?>
                                        @elseif($value->type == 3) <?php echo "product"; ?>
                                        @elseif($value->type == 4) <?php echo "brand"; ?>
                                        @endif
                                </td>
                                

                                <td>{{ $value->offer }}</td>
                                <td>{{ $value->discount }}</td>
                                <td><img alt="image name" src="{{ url('public/images/slider/'.$value->slider_image) }}"
                                        style="width:70px; height:70px;" /></td>
                                <td> {{ $value->created_at->format('d-m-Y h:i A') }}</td>
                                <td>
                                    <form method="get" action="{{ route('slider.delete', $value->id) }}">
                                        {{-- <a href="{{ url('admin/slider/view/'.$value->id) }}"
                                            class="btn btn-primary btn-rounded btn-sm"><span
                                                class="fa fa-eye"></span></a> --}}
                                        <a href="{{ url('admin/slider/edit/'.$value->id) }}"
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
                                        {{--
                                                     </div> --}}
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