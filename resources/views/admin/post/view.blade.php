@extends('admin.layouts.admin')
@section('title')
        Post Detail
@endsection
@section('content')
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left" style="width: 50% !important;">
                <h3>Description</h3>
            </div>
            <div class="title_right" style="width: 50% !important;">
                <h3>Post Comments</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                    <div class="x_content">
                        <div class="item form-group">
                            <label class="control-label" for="name">Post Author :</label>&nbsp;<label class="control-label" for="name">{{ !empty($user->name) ? $user->name: '-' }} {{'('.$user->email.')'}}</label><br/>
                            <label class="control-label" for="name">Post Date :</label>&nbsp;<label class="control-label" for="name">
                                @php
                                    $date = dateFormat($post->post_date);
                                @endphp
                                {{ !empty($date) ? $date: '-' }}
                            </label><br/>
                            <label class="control-label" for="name">Location :</label>&nbsp;<label class="control-label" for="name">{{ !empty($post->location) ? $post->location: '-' }}</label><br/>
                            <label class="control-label" for="name">Town :</label>&nbsp;<label class="control-label" for="name">{{ !empty($post->town) ? $post->town: '-' }}</label><br/>
                            <label class="control-label" for="name">Post Title :</label>&nbsp;<label class="control-label" for="name">{{ !empty($post->post_title) ? $post->post_title: '-' }}</label><br/>
                            <label class="control-label" for="name">Post Subtitle :</label>&nbsp;<label class="control-label" for="name">{{ !empty($post->post_subtitle) ? $post->post_subtitle: '-' }}</label><br/>
                            <label class="control-label" for="name">Post Content :</label>&nbsp;<label class="control-label" for="name">
                                @if(!empty($post->post_content))
                                    {!! nl2br($post->post_content) !!}
                                @else
                                    {{'-'}}
                                @endif
                            </label><br/>
                            <label class="control-label" for="name">Post Image :</label>&nbsp;
                            <label class="control-label" for="name">
                                @if(!empty($post->post_image))
                                @php
                                if (file_exists(public_path() . '/images/' . date('Y/m/d/', strtotime($post->post_date)) . $post->post_image)) {
                                $imageurl = '/images/' . date('Y/m/d/', strtotime($post->post_date)) . $post->post_image;
                                } elseif (substr($post->post_image, 0, 7) == "http://" || substr($post->post_image, 0, 8) == "https://") {
                                $imageurl = '/images/' . date('Y/m/d/', strtotime($post->post_date)) . $post->post_image;
                                } else {
                                $imageurl = '/images/' . $post->post_image;
                                }
                                @endphp
                                    <a href="{{asset($imageurl)}}" target="_blank">
                                        <img class="avatar" src="{{asset($imageurl)}}" alt="Avatar">
                                    </a>
                                @else
                                    {{'-'}}
                                @endif
                            </label><br/>
                            <label class="control-label" for="name">Post Category :</label>&nbsp;<label class="control-label" for="name">{{ !empty($post->post_category) ? $post->post_category: '-' }}</label><br/>
                            <label class="control-label" for="name">Post Type :</label>&nbsp;<label class="control-label" for="name">{{ !empty($post->post_type) ? $post->post_type: '-' }}</label><br/>
                            <label class="control-label" for="name">Post Status :</label>&nbsp;<label class="control-label" for="name">{{ !empty($post->post_status) ? $post->post_status: '-' }}</label><br/>
                            <label class="control-label" for="name">Like Count :</label>&nbsp;<label class="control-label" for="name">{{ !empty($post->like_count) ? $post->like_count: '-' }}</label><br/>
                            <label class="control-label" for="name">Comment Count :</label>&nbsp;<label class="control-label" for="name">{{ !empty($post->comment_count) ? $post->comment_count: '-' }}</label>
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
                                @if(count($postcomments) > 0)
                                    @foreach ($postcomments as $postcomment)
                                        <li>
                                            <img class="avatar" {{usergetImageUrl($postcomment->profile_image,$postcomment->user_id)}} alt="Avatar">
                                            <div class="message_wrapper">
                                            <h4 class="heading">{{$postcomment->name}}</h4>
                                            <blockquote class="message">{{$postcomment->comment}}</blockquote>
                                            @if(!empty($postcomment->image))
                                                <img class="avatar" src="{{postgetImageUrl($postcomment->image,$postcomment->created_at)}}" alt="Avatar"><br/>
                                            @endif
                                            @php
                                                $date = dateFormat($postcomment->created_at);
                                            @endphp
                                            <p style="margin:10px;">{{ !empty($date) ? $date: '-' }}</p>
                                            <br />
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