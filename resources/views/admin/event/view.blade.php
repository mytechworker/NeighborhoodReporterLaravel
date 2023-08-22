@extends('admin.layouts.admin')
@section('title')
        Event Detail
@endsection
@section('content')
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left" style="width: 50% !important;">
                <h3>Description</h3>
            </div>
            <div class="title_right" style="width: 50% !important;">
                <h3>Event Comments</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                    <div class="x_content">
                        <div class="item form-group">
                            <label class="control-label" for="name">User :</label>&nbsp;<label class="control-label" for="name">{{ !empty($user->name) ? $user->name: '-' }} {{'('.$user->email.')'}}</label><br/>
                            <label class="control-label" for="name">Location :</label>&nbsp;<label class="control-label" for="name">{{ !empty($event->location) ? $event->location: '-' }}</label><br/>
                            <label class="control-label" for="name">Town :</label>&nbsp;<label class="control-label" for="name">{{ !empty($event->town) ? $event->town: '-' }}</label><br/>
                            <label class="control-label" for="name">Date :</label>&nbsp;<label class="control-label" for="name">{{ !empty($event->date) ? $event->date: '-' }}</label><br/>
                            <label class="control-label" for="name">Time :</label>&nbsp;<label class="control-label" for="name">{{ !empty($event->time) ? $event->time: '-' }}</label><br/>
                            <label class="control-label" for="name">AM/PM :</label>&nbsp;<label class="control-label" for="name">{{ !empty($event->am_pm) ? $event->am_pm: '-' }}</label><br/>
                            <label class="control-label" for="name">Venue :</label>&nbsp;<label class="control-label" for="name">{{ !empty($event->venue) ? $event->venue: '-' }}</label><br/>
                            <label class="control-label" for="name">Title :</label>&nbsp;<label class="control-label" for="name">{{ !empty($event->title) ? $event->title: '-' }}</label><br/>
                            <label class="control-label" for="name">Description :</label>&nbsp;<label class="control-label" for="name">{!! !empty($event->description) ? nl2br($event->description): '-' !!}</label><br/>
                            <label class="control-label" for="name">Link :</label>&nbsp;<label class="control-label" for="name">{{ !empty($event->link) ? $event->link: '-' }}</label><br/>
                            <label class="control-label" for="name">Image :</label>&nbsp;
                            <label class="control-label" for="name">
                                @if(!empty($event->image))
                                @php
                                if (file_exists(public_path() . '/images/' . date('Y/m/d/', strtotime($event->date)) . $event->image)) {
                                $imageurl = '/images/' . date('Y/m/d/', strtotime($event->created_at)) . $event->image;
                                } elseif (substr($event->image, 0, 7) == "http://" || substr($event->image, 0, 8) == "https://") {
                                $imageurl = '/images/' . date('Y/m/d/', strtotime($event->created_at)) . $event->image;
                                } else {
                                $imageurl = '/images/' . date('Y/m/d/', strtotime($event->created_at)) . $event->image;
                                }
                                @endphp

                                    <a href="{{ $imageurl }}" target="_blank"><img class="avatar" src="{{asset($imageurl)}}" alt="Avatar"></a>
                                @else
                                    {{'-'}}
                                @endif
                            </label><br/>
                            <label class="control-label" for="name">Interest Count :</label>&nbsp;<label class="control-label" for="name">{{ !empty($event->intrest_count) ? $event->intrest_count: '-' }}</label><br/>
                            <label class="control-label" for="name">Comment Count :</label>&nbsp;<label class="control-label" for="name">{{ !empty($event->comment_count) ? $event->comment_count: '-' }}</label>
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
                                @if(count($eventcomments) > 0)
                                    @foreach ($eventcomments as $eventcomment)
                                        <li>
                                            <img class="avatar" {{usergetImageUrl($eventcomment->profile_image,$eventcomment->user_id)}} alt="Avatar">
                                            <div class="message_wrapper">
                                            <h4 class="heading">{{$eventcomment->name}}</h4>
                                            <blockquote class="message">{{$eventcomment->description}}</blockquote>
                                            @if(!empty($eventcomment->image))
                                                <img class="avatar" src="{{postgetImageUrl($eventcomment->image,$eventcomment->created_at)}}" alt="Avatar"><br/>
                                            @endif
                                            @php
                                                $date = dateFormat($eventcomment->created_at);
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