@extends('web.layouts.app')
@section('title', __('messages.header_titles.DASHBOARD'))

@section('content')

<section class="messageSection">
  <div class="container">

      <div class="sidePanel">
          <h2>Messages</h2>
          <div class="search-person">
              <input type="text" placeholder="Search Id">
          </div>
          <ul>

            @foreach($projects as $project)
                <li class="{{$project->id==$project_id?'active':''}}">
                    <a href="{{url('talent/message/'.$project->id.'/'.$project->client->todz_id)}}">
                    
                        <h3>{{$project->title}}
                            <span>
                                @if(isset($project->messages[0]))
                                    {{count($project->messages)>0?NotificationManager::getAgoTime($project->messages[0]->created_at,0):''}}
                                @else
                                    ''
                                @endif
                            </span>
                        </h3>
                        
                        <h4><img src="{{asset('web/images/ic_user.png')}}" alt="">Id: {{$project->client->todz_id}}</h4>
                        @if(isset($project->messages[0]))
                            <p>{{Auth::user()->id==$project->messages[0]->from_id ? 'You':'Client' }}:  {{$project->messages[0]->message}}</p>
                        @endif
                    </a>
                </li>
              @endforeach
          </ul>
      </div>

        <div class="chattingDiv">
            <span>
                <h3>
                    Project Owner ID:
                    {{$todz_id}}
                    <br>
                    Project ID : PR_{{$project_id}}
                    
                    <br>
                    <p>
                        @if(isset($current_project->messages[0]))
                            {{isset($current_project->messages[0]->created_at) ? $current_project->messages[0]->created_at:''}}
                        @else
                            ''
                        @endif
                    </p>
                </h3>
            </span>
            <div class="main-chat">
                <div class="chat-section">
                @if(@$messages->isNotEmpty())
                    @foreach(@$messages as $row)
                        @if(Auth::user()->id==$row->to_id)
                            <div class="user-message">
                                <h4>{{$row->message}}</h4>
                            </div>
                        @else 
                            <div class="self-message">
                                <h4>{{$row->message}}</h4>
                                <strong>{{date('h:i A',strtotime($row->created_at))}}</strong>
                            </div>
                        @endif
                    @endforeach
                @endif
           

            </div>
              <div class="chat-footer">
                  <input type="text" class="message" placeholder="Type your message here…">
                  <button type="button" class="sendBtn">send</button>
              </div>
          </div>
      </div>

  </div>
</section>

@endsection
@section('footerScript')
@parent
<script src="{{asset('web/js/jquery-1.11.2.min.js')}}"></script>
<script src="{{asset('web/js/jquery-migrate-1.2.1.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
<script>

var socket = io('https://chatsockets.tod-z.com?project_id={{$project_id}}&todz_id={{$todz_id}}');
 
  socket.on("Project.{{$project_id}}.{{$todz_id}}", function(message) {
 
              $( ".chat-section" ).append(` <div class="user-message">
                  <h4>`+message.data.message+`</h4>
                  <strong>`+message.timed+`</strong>
              </div>`);
              $(".main-chat").stop().animate({ scrollTop: $(".main-chat")[0].scrollHeight}, 1000);
 
      });
  
  $(".sendBtn").click(function(e){
    
      e.preventDefault();

      var msg = $(".message").val();
      if(msg != ''){
      
        jQuery.ajax({
            type:'POST',
            url:'{{url("talent/message")}}',
            data:{ "_token": "{{ csrf_token() }}",
            'message':msg,
            'project_id':{{$project_id}},
            'to_user':{{$chatuser->id}}
             },
            success:function(response){
                $( ".chat-section" ).append(`<div class="self-message">
                  <h4>`+response.data.message+`</h4>
                  <strong>`+response.timed+`</strong>
              </div>`);
                $(".message").val('');
                $(".main-chat").stop().animate({ scrollTop: $(".main-chat")[0].scrollHeight}, 1000);
            }
        });

      }else{
          alert("Please Add Message.");
      }
  })
</script>
<script>
    $(".main-chat").stop().animate({ scrollTop: $(".main-chat")[0].scrollHeight}, 1000);

</script>
@endsection
