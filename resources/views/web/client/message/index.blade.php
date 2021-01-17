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
                @if($activetoder->isNotEmpty())
                    @foreach($activetoder as $abc)
                        <li class="{{$abc->project->id==$project_id && $abc->user->todz_id== $todz_id?'active':''}}">
                            <a href="{{url('client/message/'.$abc->project->id."/".$abc->user->todz_id)}}">
                                <h3>{{$abc->project->title}}<span>{{NotificationManager::getAgoTime($abc->date,0)}}</span></h3>
                                <h4><img src="{{asset('web/images/ic_user.png')}}" alt="">Id: {{$abc->user->todz_id}}</h4>
                                @if(!is_null($abc->messageDetail()))
                                    <p>{{Auth::user()->id==$abc->messageDetail()->from_id?'You':'Todder' }}: {{$abc->messageDetail()->message}}</p>
                                @endif
                            </a>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>

        <div class="chattingDiv">
            <span>
                <h3>
                  Todder ID: {{$todz_id}}
                  <br>
                   Project ID : PR_{{$project_id}}
                  <br>
                  <p></p>
                </h3>
              <div style="margin-left: auto;">
                @switch(ProjectManager::isTodderHired($project_id,$chatuser->id))
                    @case(1)
                            <button type="button" >Hired</button>
                        @break

                    @case(2)
                    <button type="button" >Already Another Hired</button>
                        @break

                    @default
                    <button type="button" id="hired-btn">hire</button>
                @endswitch
               
               
              </div>
          </span>
          <div class="main-chat">
              <div class="chat-section">
                @if($messages->isNotEmpty())
                    @foreach($messages as $messgae)
                        @if(Auth::user()->id==$messgae->to_id)
                            <div class="user-message">
                                <h4>{{$messgae->message}}</h4>
                            </div>
                        @else 
                            <div class="self-message">
                                <h4>{{$messgae->message}}</h4>
                                <strong>{{date('h:i A',strtotime($messgae->created_at))}}</strong>
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
socket.on('connect', () => {
    console.log(socket.id); // an alphanumeric id...
 });
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
            url:'{{url("client/message")}}',
            data:{ 
                "_token": "{{ csrf_token() }}",
                'message':msg,
                'project_id':"{{$project_id}}",
                'to_user':"{{$chatuser->id}}"
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

    $("#hired-btn").on('click',function(){
        swal({
        title: "Sure",
        text: "Do you want to hire this todder?",
        icon: "warning",
        buttons: true,
        dangerMode: false,
        })
        .then((willconfirm) => {
        if (willconfirm) {
            jQuery.ajax({
            type:'POST',
            url:'{{url("client/hire_todder")}}',
            data:{ "_token": "{{ csrf_token() }}",
         
            'project_id':'{{$project_id}}',
            'todz_id':'{{$todz_id}}'
             },
            success:function(response){
                if(response.status==1){
            //    / swal("Accepted", response.message, "success");
                swal({title: "Hired", text: response.msg, type: "success"}).then(function(){ 
   location.reload();
   }
);
            }else{
              swal({title: "Oops!", text: response.msg, type: "error"});
            }
            }
            
        });
    }
        });
    });
    </script>
@endsection
