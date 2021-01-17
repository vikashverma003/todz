@extends('admin.layouts.app')
@section('title',$title)
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
               <h4 class="card-title float-left">Category List</h4>
               <a class="nav-link add_button btn btn-sm float-right" href="{{url('admin/categories/create')}}">
                <i class=" icon-plus menu-icon"></i>
                <span class="menu-title">Add</span>
              </a>
               <div class="table-responsive">
                  <table class="table">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>Name</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @php $key=1
                        @endphp
                        @if($categories->isNotEmpty())
                        @foreach ($categories as $cat)
                        <tr>
                           <td>{{$key++}}</td>
                           <td>{{@$cat->name}}</td>
                           <td>
                            <a class="action-button" href="/admin/categories/{{$cat->id}}/edit" data-toggle="tooltip" title="Edit">
                            <i class=" icon-pencil menu-icon"></i>
                            <span class="menu-title"></span>
                            </a>
                         </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                           <td colspan="6" style="text-align:center">No category code  exist</td>
                        </tr>
                        @endif
                     </tbody>
                  </table>
                  {{ $categories->links() }}
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
