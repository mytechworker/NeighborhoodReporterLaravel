@extends('admin.layouts.admin')
@section('title')
        Classified Detail
@endsection
@section('content')
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left" style="width: 50% !important;">
                <h3>Description</h3>
            </div>
            <div class="title_right" style="width: 50% !important;">
                <h3>Classified Comments</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                    <div class="x_content">
                        <div class="item form-group">
                            <label class="control-label" for="name">User :</label>&nbsp;<label class="control-label" for="name">{{ !empty($user->name) ? $user->name: '-' }} {{'('.$user->email.')'}}</label><br/>
                            <label class="control-label" for="name">Location :</label>&nbsp;<label class="control-label" for="name">{{ !empty($classified->location) ? $classified->location: '-' }}</label><br/>
                            <label class="control-label" for="name">Town :</label>&nbsp;<label class="control-label" for="name">{{ !empty($classified->town) ? $classified->town: '-' }}</label><br/>
                            <label class="control-label" for="name">Category :</label>&nbsp;<label class="control-label" for="name">{{ !empty($classified->category) ? $classified->category: '-' }}</label><br/>
                            <label class="control-label" for="name">Title :</label>&nbsp;<label class="control-label" for="name">{{ !empty($classified->title) ? $classified->title: '-' }}</label><br/>
                            <label class="control-label" for="name">Description :</label>&nbsp;<label class="control-label" for="name">{!! !empty($classified->description) ? nl2br($classified->description): '-' !!}</label><br/>
                            <label class="control-label" for="name">Image :</label>&nbsp;
                            <label class="control-label" for="name">
                                @if(!empty($classified->image))
                                @php
                                if (file_exists(public_path() . '/images/' . date('Y/m/d/') . $classified->image)) {
                                $imageurl = '/images/' . date('Y/m/d/') . $classified->image;
                                } elseif (substr($classified->image, 0, 7) == "http://" || substr($classified->image, 0, 8) == "https://") {
                                $imageurl = '/images/' . date('Y/m/d/') . $classified->image;
                                } else {
                                $imageurl = '/images/' . date('Y/m/d/') . $classified->image;
                                }
                                @endphp
                                <a href="{{ $imageurl }}" target="_blank"><img class="avatar" src="{{asset($imageurl)}}" alt="Avatar"></a>
                                @else
                                    {{'-'}}
                                @endif
                            </label><br/>
                            <label class="control-label" for="name">Like Count :</label>&nbsp;<label class="control-label" for="name">{{ !empty($classified->like_count) ? $classified->like_count: '-' }}</label><br/>
                            <label class="control-label" for="name">Comment Count :</label>&nbsp;<label class="control-label" for="name">{{ !empty($classified->comment_count) ? $classified->comment_count: '-' }}</label><br/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                    <div class="x_content">
                        <div>
                            {{-- <h4>Recent Activity</h4> --}}
                            <!-- end of user messages -->
                            <ul class="messages">
                                @if(count($classifiedcomments) > 0)
                                    @foreach ($classifiedcomments as $classifiedcomment)
                                        <li>
                                            <img class="avatar" {{usergetImageUrl($classifiedcomment->profile_image,$classifiedcomment->user_id)}} alt="Avatar">
                                            <div class="message_wrapper">
                                            <h4 class="heading">{{$classifiedcomment->name}}</h4>
                                            <blockquote class="message">{{$classifiedcomment->description}}</blockquote>
                                            @if(!empty($classifiedcomment->image))
                                                <img class="avatar" src="{{postgetImageUrl($classifiedcomment->image,$classifiedcomment->created_at)}}" alt="Avatar"><br/>
                                            @endif
                                            @php
                                                $date = dateFormat($classifiedcomment->created_at);
                                            @endphp
                                            <p style="margin:10px;">{{ !empty($date) ? $date: '-' }}</p>
                                            <br />
                                            {{-- <p class="url">
                                                <span class="fs1 text-info" aria-hidden="true" data-icon=""></span>
                                                <a href="#"><i class="fa fa-paperclip"></i> User Acceptance Test.doc </a>
                                            </p> --}}
                                            </div>
                                        </li>
                                    @endforeach
                                @else
                                    <p class="text-center">No Comments Found</p>
                                @endif
                            </ul>
                            <!-- end of user messages -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection