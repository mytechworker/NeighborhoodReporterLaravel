@extends('admin.layouts.admin')
@section('title')
        Faqs List
@endsection
@section('content')

<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="col-md-12 col-sm-12 col-xs-12">
                @if ($message = Session::get('success'))
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
                <h3>Faqs List</h3>
            </div>
            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <div class="input-group">
                        <span class="input-group-btn text-right">
                            <a class="btn btn-default" href="{{ route('faqs.create') }}" title="Create a Faq">Add New Faq</a>
                        </span>
                    </div>
                </div>
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
                                <th class="column-title">Faq Id </th>
                                 <th class="column-title">Faq Category </th>
                                <th class="column-title">Faq Title </th>
                                <th class="column-title">Faq Description </th>
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
    function htmlDecode(input) {
  var doc = new DOMParser().parseFromString(input, "text/html");
  return doc.documentElement.textContent;
}
    jQuery(document).ready(function() {
        const a="{{config('app.menu_length')}}"
       
        var table = jQuery('.myTable').DataTable({
                ajax: '',
                serverSide: true,
                processing: true,
                aaSorting:[[0,"desc"]],
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'faq_categories_title', name: 'faq_categories_title'},
                    {data: 'title', name: 'title'},
                    {data: 'description', name: 'description',"render": function (data){
                        return htmlDecode(data).replace( /(<([^>]+)>)/ig, '')
                    }},
                    {data: 'action', name: 'action'},
                ],
               
                'columnDefs': [ {
                    'targets': [4],
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
                url: "faqs/" + rowid,
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
