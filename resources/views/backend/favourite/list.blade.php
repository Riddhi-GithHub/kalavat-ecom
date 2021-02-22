@extends('backend.layouts.app')
@section('style')
<style type="text/css">

</style>
@endsection
@section('content')

<ul class="breadcrumb">
    <li><a href="">Favourite </a></li>
    <li><a href="">Favourite List</a></li>
</ul>

<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span> Favourite List</h2>
</div>

<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            {{-- start --}}
            @include('message')
            {{-- Add Menu --}}

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Favourite  Search</h3>
                </div>


                <div class="panel-body" style="overflow: auto;">

                    <form action="" method="get">
                        <div class="col-md-3">
                            <label>ID</label>
                            <input type="text" value="{{ Request()->id }}" class="form-control" placeholder="ID"
                                name="id">
                        </div>
                        <div class="col-md-3">
                            <label>UserName</label>
                            <input type="text" class="form-control" value="{{ Request()->title }}" placeholder="Title"
                                name="title">
                        </div>
                        <div class="col-md-3">
                            <label>ProductName</label>
                            <input type="text" class="form-control" value="{{ Request()->description }}"
                                placeholder="Description" name="description">
                        </div>

                        <div style="clear: both;"></div>
                        <br>
                        <div class="col-md-12">
                            <input type="submit" class="btn btn-primary" value="Search">
                            <a href="{{ url('admin/Favourite_us') }}" class="btn btn-success">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
            <!-- START BASIC TABLE SAMPLE -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Contact Us List</h3>
                </div>
                <div class="panel-body" style="overflow: auto;">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>UserName</th>
                                <th>ProductName</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($getrecord as $value)
                            <tr>
                                <td> {{ $value->fav_id }}</td>
                                <td> {{ $value->user->username }}</td>
                                <td>{{ $value->product->product_name }}</td>
                                <td> {{ $value->created_at->format('d-m-Y h:i A') }}</td>
                                <td>
                                    <a href="#" class="mb-control btn btn-danger btn-rounded btn-sm"
                                        data-box="#con_mb_delete"><span class="fa fa-trash-o"></span></a>

                                    {{-- Delete Button Start--}}
                                    <div class="message-box animated fadeIn" id="con_mb_delete">
                                        <div class="mb-container">
                                            <div class="mb-middle">
                                                <div class="mb-title"><span class="fa fa-trash-o"></span> Delete ?</div>
                                                <div class="mb-content">
                                                    <p>Are you sure you want to delete?</p>
                                                    <p>Press No if youwant to continue work. Press Yes to delete current
                                                        contact.</p>
                                                </div>
                                                <div class="mb-footer">
                                                    <div class="pull-right">
                                                        <a href="{{ url('admin/contact_us/delete/'.$value->id) }}"
                                                            class="btn btn-success btn-lg">Yes</a>
                                                        <button
                                                            class="btn btn-default btn-lg mb-control-close">No</button>
                                                    </div>
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