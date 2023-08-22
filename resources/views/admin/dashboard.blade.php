@extends('admin.layouts.admin')
@section('title')
        Dashboard
@endsection
@section('content')
<div class="right_col" role="main">

    <!-- top tiles -->
    <div class="row tile_count">
      @if(Auth::user()->type=='Superadmin')
        <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
          <div class="left"></div>
          <div class="right">
            <span class="count_top"><i class="fa fa-user"></i> Total Users</span>
            <div class="count">{{$users['total_user']}}</div>
            <span class="count_bottom"><i class="green">{{!empty($users['admin']) ? $users['admin'] : 0}} </i> Admin</span>
            <span class="count_bottom"><i class="red">{{!empty($users['user']) ? $users['user'] : 0}} </i> User</span>
          </div>
        </div>
        <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
          <div class="left"></div>
          <div class="right">
            <span class="count_top"><i class="fa fa-newspaper-o"></i> Total Article Post</span>
            <div class="count">{{$article_post}}</div>
            {{-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span> --}}
          </div>
        </div>
        <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
          <div class="left"></div>
          <div class="right">
            <span class="count_top"><i class="fa fa-newspaper-o"></i> Total Neighbour Post</span>
            <div class="count">{{$neighbour_post}}</div>
            {{-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span> --}}
          </div>
        </div>
        <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
          <div class="left"></div>
          <div class="right">
            <span class="count_top"><i class="fa fa-tasks"></i> Total Event</span>
            <div class="count">{{$event}}</div>
            {{-- <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span> --}}
          </div>
        </div>
        <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
          <div class="left"></div>
          <div class="right">
            <span class="count_top"><i class="fa fa-user"></i> Total Classified</span>
            <div class="count">{{$classified}}</div>
            {{-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span> --}}
          </div>
        </div>
        <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
          <div class="left"></div>
          <div class="right">
            <span class="count_top"><i class="fa fa-industry"></i> Total Feature Business</span>
            <div class="count">{{$feature_business}}</div>
            {{-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span> --}}
          </div>
        </div>
      @else
        <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
          <div class="left"></div>
          <div class="right">
            <span class="count_top"><i class="fa fa-user"></i> Total Users</span>
            <div class="count">{{$total_user}}</div>
          </div>
        </div>
        <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
          <div class="left"></div>
          <div class="right">
            <span class="count_top"><i class="fa fa-newspaper-o"></i> Total Article Post</span>
            <div class="count">{{$article_post}}</div>
            {{-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span> --}}
          </div>
        </div>
        <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
          <div class="left"></div>
          <div class="right">
            <span class="count_top"><i class="fa fa-newspaper-o"></i> Total Neighbour Post</span>
            <div class="count">{{$neighbour_post}}</div>
            {{-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span> --}}
          </div>
        </div>
        <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
          <div class="left"></div>
          <div class="right">
            <span class="count_top"><i class="fa fa-tasks"></i> Total Event</span>
            <div class="count">{{$event}}</div>
            {{-- <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span> --}}
          </div>
        </div>
        <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
          <div class="left"></div>
          <div class="right">
            <span class="count_top"><i class="fa fa-user"></i> Total Classified</span>
            <div class="count">{{$classified}}</div>
            {{-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span> --}}
          </div>
        </div>
        <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
          <div class="left"></div>
          <div class="right">
            <span class="count_top"><i class="fa fa-industry"></i> Total Feature Business</span>
            <div class="count">{{$feature_business}}</div>
            {{-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span> --}}
          </div>
        </div>
      @endif

    </div>
    <!-- /top tiles -->
  </div>
@endsection