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
               <h4 class="card-title float-left">Coupon List</h4>
               <a class="nav-link add_button btn btn-sm float-right" href="{{url('admin/coupon/create')}}">
                <i class=" icon-plus menu-icon"></i>
                <span class="menu-title">Add</span>
              </a>
               <div class="table-responsive">
                  <table class="table">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>Name</th>
                           <th>User Type</th>
                           <th>Coupon Code</th>
                           <th>Coupon Value</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @php $key=1
                        @endphp
                        @if($coupons->isNotEmpty())
                        @foreach ($coupons as $com)
                        <tr>
                           <td>{{$key++}}</td>
                           <td>{{@$com->name}}</td>
                           <td>
                             @if($com->coupon_type == config('constants.COUPON_TYPE.BOTH'))
                             <span class="badge badge-success">Both (Client & Talent)</span>
                             @elseif($com->coupon_type == config('constants.COUPON_TYPE.CLIENT'))
                             <span class="badge badge-success">Client</span>
                             @elseif($com->coupon_type == config('constants.COUPON_TYPE.TALENT'))
                             <span class="badge badge-success">Talent</span>
                             @else
                             @endif
                           </td>
                           <td>{{@$com->code}}</td>
                           <td>{{@$com->coupon_value}}%</td>
                           <td>
                              {{--rl('admin/company/'.$com->id.'/edit') --}}
                            <a class="action-button" href="/admin/coupon/{{$com->id}}/edit" data-toggle="tooltip" title="Edit">
                            <i class=" icon-pencil menu-icon"></i>
                            <span class="menu-title"></span>
                            </a>
                         </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                           <td colspan="6" style="text-align:center">No Coupon code  exist</td>
                        </tr>
                        @endif
                     </tbody>
                  </table>
                  {{ $coupons->links() }}
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
