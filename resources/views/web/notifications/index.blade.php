@extends('web.layouts.app')
@section('title', __('messages.header_titles.DASHBOARD'))

@section('content')
<section class="dashboard-section">
<h2 class="text-center text-muted py-3">All Notifications</h2>

<div class="container py-2 mt-4 mb-4">
    
    @foreach($allNotifications as $key=> $notification)
    @if($key%2==0)
  <!-- timeline item 1 -->
  <div class="row no-gutters">
    <div class="col-sm"> <!--spacer--> </div>
    <!-- timeline item 1 center dot -->
    <div class="col-sm-1 text-center flex-column d-none d-sm-flex">
      <div class="row h-50">
        <div class="col">&nbsp;</div>
        <div class="col">&nbsp;</div>
      </div>
      <h5 class="m-2">
        <span class="badge badge-pill {{$notification->is_read==1?'bg-light':'bg-warning'}} border">&nbsp;</span>
      </h5>
      <div class="row h-50">
        <div class="col border-right">&nbsp;</div>
        <div class="col">&nbsp;</div>
      </div>
    </div>
    <!-- timeline item 1 event content -->
    <div class="col-sm py-2">
      <div class="card">
        <div class="card-body">
          <div class="float-right text-muted small">{{date('M dS Y h:i A',strtotime($notification->created_at))}}</div>
        <h4 class="card-title text-muted"><a class="card-title text-muted" href="{{url($notification->route_link)}}">{{$notification->notification_name}}</a></h4>
        <p class="card-text"><a class="card-text text-muted" href="{{url($notification->route_link)}}">{{$notification->message}}</a></p>
        </div>
      </div>
    </div>
  </div>
  <!--/row-->

@else
  <!-- timeline item 2 -->
  <div class="row no-gutters">
    <div class="col-sm py-2">
      <div class="card border-muted shadow">
        <div class="card-body">
          <div class="float-right text-muted small">{{date('M dS Y h:i A',strtotime($notification->created_at))}} </div>
          <h4 class="card-title text-muted"><a class="card-title text-muted" href="{{url($notification->route_link)}}">{{$notification->notification_name}}</a></h4>
          <p class="card-text"><a class="card-text text-muted" href="{{url($notification->route_link)}}">{{$notification->message}}</a></p>
         
        </div>
      </div>
    </div>
    <div class="col-sm-1 text-center flex-column d-none d-sm-flex">
      <div class="row h-50">
        <div class="col border-right">&nbsp;</div>
        <div class="col">&nbsp;</div>
      </div>
      <h5 class="m-2">
        <span class="badge badge-pill {{$notification->is_read==1?'bg-light':'bg-warning'}} border">&nbsp;</span>
      </h5>
      <div class="row h-50">
        <div class="col border-right">&nbsp;</div>
        <div class="col">&nbsp;</div>
      </div>
    </div>
    <div class="col-sm"> <!--spacer--> </div>
  </div>
  <!--/row-->
  @endif
  @endforeach
 
</div>
</section>

@endsection