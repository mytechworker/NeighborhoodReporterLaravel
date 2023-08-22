@extends('admin.layouts.admin')
@section('title')
        View Feature Business
@endsection
@section('content')
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left" style="width: 50% !important;">
                <h3>Description</h3>
            </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">User Name :</label><label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">{{ !empty($feature_business->name) ? $feature_business->name: '-' }}</label>
                            <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">Business Name :</label><label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">{{ !empty($featureBusiness->business_name) ? $featureBusiness->business_name: '-' }}</label>
                            <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">Location :</label><label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">{{ !empty($featureBusiness->location) ? $featureBusiness->location: '-' }}</label>
                            <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">Town :</label><label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">{{ !empty($featureBusiness->town) ? $featureBusiness->town: '-' }}</label>
                            <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">Message to Reader :</label><label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">{!! !empty($featureBusiness->message_to_reader) ? nl2br($featureBusiness->message_to_reader): '-' !!}</label>
                            <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">Phone :</label>
                            <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">
                                @if(!empty($featureBusiness->phone))
                                    <a href="tel:{{$featureBusiness->phone}}">{{$featureBusiness->phone}}</a>
                                @else 
                                    {{'-'}};
                                @endif
                            </label>
                            <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">Website :</label>
                            <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">
                                <?php
                                        if(!empty($featureBusiness->website))
                                        {
                                ?>
                                            <a href="{{$featureBusiness->website}}" target="_blank">{{$featureBusiness->website}}</a>
                                <?php
                                        }
                                        else 
                                        {
                                            echo "-";
                                        }
                                ?>
                            </label>
                            <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">Adddress :</label><label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">{{ !empty($featureBusiness->address) ? $featureBusiness->address: '-' }}</label>
                            <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">Image :</label>
                            <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">
                                @if(!empty($featureBusiness->image))
                                    <a href="{{ postgetImageUrl($featureBusiness->image,$featureBusiness->created_at) }}" target="_blank"><img class="avatar" src="{{ postgetImageUrl($featureBusiness->image,$featureBusiness->created_at) }}" alt="Avatar"></a>
                                @else
                                    {{'-'}}
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