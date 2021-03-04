@extends('backend.layouts.app')
@section('style')
<style type="text/css">

</style>
@endsection
@section('content')

<ul class="breadcrumb">
    <li><a href="">App Version</a></li>
    <li><a href="">App Version Name</a></li>
</ul>

<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span> App Version Name</h2>
</div>

<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">

            {{-- start --}}

            @include('message')

            <!-- START BASIC TABLE SAMPLE -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">App Version Name</h3>
                </div>

                <div class="panel-body" style="overflow: auto;">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Version</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($getrecord as $value)
                            <tr>
                                <td> {{ $value->id }}</td>
                                <td>{{ $value->app_version }}</td>
                                <td> {{ $value->created_at->format('d-m-Y h:i A') }}</td>
                                <td>  <a href="{{ url('admin/versionsetting/edit/'.$value->id) }}"
                                    class="btn btn-success btn-rounded btn-sm"><span
                                        class="fa fa-pencil"></span></a></td>
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