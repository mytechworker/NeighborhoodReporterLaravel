@extends('admin.layouts.admin')
@section('title')
        Edit User
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
                <h3>Edit User</h3>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        <form class="form-horizontal form-label-left" action="{{ route('user.update', $user->id) }}" method="POST" novalidate>
                            @csrf
                            @method('PUT')
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input id="name" class="form-control col-md-6 col-xs-6" required="required" type="text" name="name" value="{{$user->name}}">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Email <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input id="name" class="form-control col-md-6 col-xs-6" required="required" type="email" name="email" value="{{$user->email}}">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Password</label>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input id="name" class="form-control col-md-6 col-xs-6" type="password" name="password">
                                    <span>Enter password only if you want to change it.</span>
                                </div>
                            </div>
                            @if(!empty($cid->communitie_id))
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Default Region Name <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        @foreach($data as $result)
                                            @if($result->id==$cid->communitie_id)
                                                <input autocomplete="off" class="form-control col-md-6 col-xs-6" name="region_name" id="region_name" required type="text" value="{{$result->name. ', ' .$result->region_code}}">
                                            @endif 
                                        @endforeach
                                    </div>
                                </div>
                                <input type="hidden" name="community_id" id="community_id">
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"></label>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <div id="community_list"></div>
                                    </div>
                                </div>
                            @else
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Default Region Name <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <input autocomplete="off" class="form-control col-md-6 col-xs-6" name="region_name" id="region_name" required type="text">
                                    </div>
                                </div>
                                <input type="hidden" name="community_id" id="community_id">
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"></label>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <div id="community_list"></div>
                                    </div>
                                </div>
                            @endif
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Status <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <select name="status" class="form-control col-md-6 col-xs-6" required="required" id="single">
                                        @foreach(\App\User::$status as $k => $v)
                                            <option value="{{$k}}" {{ ($user->status == $k) ? 'selected' : ''}}>{{$v}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <a href="{{ route('user.index') }}"><button type="button" class="btn btn-primary">Cancel</button></a>
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
<script>
    $(document).ready(function () {

        $('#region_name').on('keyup', function () {
            var query = $(this).val();
            $.ajax({

                url: "{{ route('search_community') }}",

                type: "GET",

                data: {'communitie': query},

                success: function (data) {

                    $('#community_list').html(data);
                }
            })
            // end of ajax call
        });

        $(document).on('click', '.list-group-item', function () {

            var value = $(this).text();
            var cid = $(this).data('id');
            $('#region_name').val(value);
            $('#community_id').val(cid);
            $('#community_list').html("");
        });
    });

</script>
@endsection