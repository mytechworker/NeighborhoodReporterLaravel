@extends('admin.layouts.admin')
@section('title')
        Edit Faq Category
@endsection

@section('content')

<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="col-md-12 col-sm-12 col-xs-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="title_left">
                <h3>Edit Faq Category</h3>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        <form class="form-horizontal form-label-left" action="{{ route('faq_categories.update', $faqCategory->id) }}" method="POST" novalidate>
                            @csrf
                            @method('PUT')
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Title <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input id="name" class="form-control col-md-6 col-xs-6" required="required" type="text" name="title" value="{{ $faqCategory->title }}">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Description <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <textarea id="textarea" required="required" name="description" class="form-control col-md-7 col-xs-12">{{ $faqCategory->description }}</textarea>
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <a href="{{ route('faq_categories.index') }}"><button type="button" class="btn btn-primary">Cancel</button></a>
                                    <button id="send" type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection