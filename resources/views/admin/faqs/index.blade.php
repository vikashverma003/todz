@extends('admin.layouts.app')
@section('title','FAQs')
@section('user_name',$user->first_name." ".$user->last_name)
@section('role',$user->role)
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    @if (\Session::has('success'))
                    <div class="alert alert-success">
                        {!! \Session::get('success') !!}
                    </div>
                    @endif
                    @if (\Session::has('error'))
                    <div class="alert alert-danger">
                        {!! \Session::get('error') !!}
                    </div>
                    @endif
                    <h4 class="card-title">FAQs List</h4>
                    <a class="nav-link add_button" href="{{url('admin/faqs/create')}}">
                        <i class=" icon-plus menu-icon"></i>
                        <span class="menu-title">Add</span>
                    </a>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Category</th>
                                    <th>Title</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php 
                                    $key=1
                                @endphp
                                @if($data->isNotEmpty())
                                    @foreach ($data as $row)
                                        <tr>
                                            <td>{{$key++}}</td>
                                            <td>{{@$row->category}}</td>
                                            <td>{{@$row->title}}</td>
                                            <td>
                                                <a class="action-button" href="{{route('faqs.edit',[$row->id])}}" data-toggle="tooltip" title="Edit">
                                                    <i class=" icon-pencil menu-icon"></i>
                                                    <span class="menu-title"></span>
                                                </a>

                                                <a class="action-button delete_record" href="javascript:;" data-toggle="tooltip" title="Delete" data-id="{{$row->id}}">
                                                    <i class=" icon-trash menu-icon"></i>
                                                    <span class="menu-title"></span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="6" style="text-align:center">No Data record exist</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footerScript')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script type="text/javascript">
    $(document).ready(function(){
        
        $(document).on('click','.delete_record', function(){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                     var id = $(this).data("id");
                    $.ajax({
                        async : true,
                        url: "{{url('admin/faqs')}}"+'/'+id, //url
                        type: 'delete', //request method
                        data: {
                            'id':id,
                             "_token": "{{ csrf_token() }}",
                        },
                        success: function(data) {
                            if(data.status){
                                Swal.fire({
                                    text:data.message
                                }).then((result) => {
                                    window.location.reload();
                                });
                            }else{
                                Swal.fire(data.message);
                            }
                        },
                        error: function(xhr) {
                            
                        }
                    });
                }
            });
        });
    });
</script>
@endsection