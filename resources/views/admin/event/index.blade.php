@extends('admin.layouts.admin')
@section('title')
        Event List
@endsection
@section('content')

<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="col-md-12 col-sm-12 col-xs-12">
                @if($message = Session::get('success'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <p >{{ $message }}</p>
                    </div>
                @endif
                <div class="alert alert-danger" id="success" style="display:none"></div>
            </div>
            <div class="title_left">
                <h3>Event List</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        <table class="table table-striped responsive-utilities jambo_table bulk_action myTable">
                            <thead>
                            <tr class="headings">
                                <th class="column-title">Event Id </th>
                                <th class="column-title">User Name </th>
                                <th class="column-title">Location </th>
                                <th class="column-title">Town </th>
                                <th class="column-title">Date </th>
                                <th class="column-title">Time </th>
                                <th class="column-title">AM/PM </th>
                                <th class="column-title">Venue </th>
                                <th class="column-title no-link last"><span class="nobr">Action</span></th>
                            </tr>
                            </thead>

                            {{-- <tbody>
                                @foreach ($religionals as $religional)
                                    <tr class="even pointer">
                                        <td class=" ">{{ $religional->id }}</td>
                                        <td class=" ">{{ $religional->name }} </td>
                                        <td class=" ">
                                            <form action="{{ route('religionals.destroy', $religional->id) }}" method="POST">
                                                <a href="{{ route('religionals.edit', $religional->id) }}">
                                                    <i class="fa fa-edit  fa-lg"></i>
                        
                                                </a>
                        
                                                @csrf
                                                @method('DELETE')
                        
                                                <button type="submit" title="delete" style="border: none; background-color:transparent;" onclick="return confirm('Are you sure you want to delete this item')">
                                                    <i class="fa fa-trash fa-lg text-danger"></i>
                        
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody> --}}

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function() {
        const a="{{config('app.menu_length')}}"
       
        var table = jQuery('.myTable').DataTable({
                ajax: '',
                serverSide: true,
                processing: true,
                aaSorting:[[0,"desc"]],
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'location', name: 'location'},
                    {data: 'town', name: 'town'},
                    {data: 'date', name: 'date'},
                    {data: 'time', name: 'time'},
                    {data: 'am_pm', name: 'am_pm'},
                    {data: 'venue', name: 'venue'},
                    {data: 'action', name: 'action'},
                ],
                'columnDefs': [ {
                    'targets': [8],
                    'orderable': false,
                }],
                "lengthMenu": a.split(',')
            });

        jQuery(document).on('click','.btn-delete',function(){
            if(!confirm("Are you sure?")) return;
            
            var rowid = jQuery(this).data('rowid')
            var el = jQuery(this)
            if(!rowid) return;

           
            jQuery.ajax({
                type: "POST",
                dataType: 'JSON',
                url: "event/" + rowid,
                data: {_method: 'delete',_token: '{{ csrf_token() }}'},
                success: function (data) {
                    if (data.success) {
                        table.row(el.parents('tr'))
                            .remove()
                            .draw();
                            jQuery("#success").css("display","block");
                            jQuery('.alert-success').css("display","none");  
                        jQuery("#success").html('<p><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+data.message+'</p>');
                    }
                }
             }); //end ajax
        })
    })
</script>
@endsection
