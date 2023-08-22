@extends('admin.layouts.admin')
@section('title')
        View Classified Report
@endsection
@section('content')
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Classified Details</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        <div class="item form-group">
                            <label class="control-label" for="name">Title :</label>&nbsp;<label class="control-label" for="name">{{ !empty($post_title->title) ? $post_title->title: '-' }} </label><br/>
                            <label class="control-label" for="name">User :</label>&nbsp;<label class="control-label" for="name">{{ !empty($user->name) ? $user->name: '-' }} {{'('.$user->email.')'}}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-title">
            <div class="title_left">
                <h3>View Report</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        {{-- <div class="item form-group">
                            @php
                                $i=1;
                            @endphp
                            @if(count($post_reports) > 0)
                                @foreach ($post_reports as $key=>$post_report)
                                    @php
                                        $user= DB::table('users')->where('id',$post_report->user_id)->first();
                                    @endphp
                                    <label class="control-label col-md-12 col-sm-12 col-xs-12" for="name">{{'('.$i.')'}}</label>
                                    <label class="control-label col-md-6 col-sm-6 col-xs-6" for="name">User Name :-</label><label class="control-label col-md-6 col-sm-6 col-xs-6" for="name">{{ $user->name }} {{'('.$user->email.')'}} </label>
                                    <label class="control-label col-md-6 col-sm-6 col-xs-6" for="name">Type :-</label><label class="control-label col-md-6 col-sm-6 col-xs-6" for="name">{{ $post_report->type }} </label>
                                    <label class="control-label col-md-6 col-sm-6 col-xs-6" for="name">Report Type :-</label><label class="control-label col-md-6 col-sm-6 col-xs-6" for="name">{{ $post_report->report_type }} </label>
                                    <label class="control-label col-md-6 col-sm-6 col-xs-6" for="name">Date :-</label><label class="control-label col-md-6 col-sm-6 col-xs-6" for="name">
                                    @php
                                        $date = dateFormat($post_report->created_at);
                                    @endphp  
                                    {{$date}}  
                                    </label><br/>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                            @else
                                <p class="text-center">No Data Found</p>
                            @endif
                        </div> --}}
                        <table class="table table-striped responsive-utilities jambo_table bulk_action myTable1">
                            <thead>
                            <tr class="headings">
                                <th class="column-title">Id </th>
                                <th class="column-title">User Name </th>
                                <th class="column-title">Type </th>
                                <th class="column-title">Report Type </th>
                                <th class="column-title">Date </th>
                            </tr>
                            </thead>

                            <tbody>
                                @foreach ($post_reports as $post_report)
                                @php
                                        $user= DB::table('users')->where('id',$post_report->user_id)->first();
                                @endphp
                                    <tr class="even pointer">
                                        <td class=" ">{{ $post_report->id }}</td>
                                        <td class=" ">{{ $user->name }} {{'('.$user->email.')'}} </td>
                                        <td class=" ">{{ $post_report->type }} </td>
                                        <td class=" ">{{ $post_report->report_type }} </td>
                                        <td class=" ">
                                            @php
                                                $date = dateFormat($post_report->created_at);
                                            @endphp  
                                            {{$date}}  
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function() {
        var table = jQuery('.myTable1').DataTable({

        });
    });
</script>
@endsection