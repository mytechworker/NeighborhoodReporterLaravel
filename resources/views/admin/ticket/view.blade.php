@extends('admin.layouts.admin')
@section('title')
        Ticket Detail
@endsection
@section('content')
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Description</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        <div class="item form-group">
                            <label class="control-label col-md-6 col-sm-6 col-xs-6" for="name">Email :-</label>
                            <label class="control-label col-md-6 col-sm-6 col-xs-6" for="name">
                                @if(!empty($ticket->email))
                                    <a href="mailto:{{$ticket->email}}"> {{$ticket->email}} </a>
                                @else
                                    {{'-'}}
                                @endif    
                            </label>
                            <label class="control-label col-md-6 col-sm-6 col-xs-6" for="name">Description :-</label><label class="control-label col-md-6 col-sm-6 col-xs-6" for="name">{{ !empty($ticket->description) ? $ticket->description: '-' }}</label>
                            <label class="control-label col-md-6 col-sm-6 col-xs-6" for="name">Town :-</label><label class="control-label col-md-6 col-sm-6 col-xs-6" for="name">{{ !empty($ticket->town) ? $ticket->town: '-' }}</label>
                            <label class="control-label col-md-6 col-sm-6 col-xs-6" for="name">URL :-</label><label class="control-label col-md-6 col-sm-6 col-xs-6" for="name">
                                @if(!empty($ticket->url))
                                    <a href="{{$ticket->url}}" target="_blank">{{$ticket->url}}</a>
                                @else
                                    {{'-'}}
                                @endif
                            </label>
                            <label class="control-label col-md-6 col-sm-6 col-xs-6" for="name">Attachement :-</label>
                            <label class="control-label col-md-6 col-sm-6 col-xs-6" for="name">
                                <?php
                                    $filename = $ticket->attachement;
                                    $allowed1 = array('gif', 'png', 'jpg','jpeg');
                                    $allowed2 = array('pdf','doc','docx','csv','ppt','txt','html');
                                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                ?>
                                @if(in_array($ext, $allowed1))
                                    @if(!empty($ticket->attachement))
                                        <a href="{{ postgetImageUrl($ticket->attachement) }}" target="_blank"><img class="avatar" src="{{ postgetImageUrl($ticket->attachement) }}" alt="Avatar" height="300px" width="300px"></a>
                                    @else
                                        {{'-'}}
                                    @endif
                                @elseif(in_array($ext, $allowed2))
                                    @if(!empty($ticket->attachement))
                                        <a href="{{asset("images/".$ticket->attachement)}}" download="{{$ticket->attachement}}">{{$ticket->attachement}}</a>
                                    @else
                                        {{'-'}}
                                    @endif
                                @else
                                @endif
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection