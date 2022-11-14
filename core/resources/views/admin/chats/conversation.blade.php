@extends('admin.layouts.app')
<style type="text/css">
    img{ max-width:100%;}
    .inbox_people {
      background: #f8f8f8 none repeat scroll 0 0;
      float: left;
      overflow: hidden;
      width: 40%; border-right:1px solid #c4c4c4;
    }
    .inbox_msg {
      border: 1px solid #c4c4c4;
      clear: both;
      overflow: hidden;
    }
    .top_spac{ margin: 20px 0 0;}

    .recent_heading {float: left; width:40%;}
    .srch_bar {
      display: inline-block;
      text-align: right;
      width: 60%;
    }
    .headind_srch{ padding:10px 29px 10px 20px; overflow:hidden; border-bottom:1px solid #c4c4c4;}

    .recent_heading h4 {
      color: #05728f;
      font-size: 21px;
      margin: auto;
    }
    .srch_bar input{ border:1px solid #cdcdcd; border-width:0 0 1px 0; width:80%; padding:2px 0 4px 6px; background:none;}
    .srch_bar .input-group-addon button {
      background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
      border: medium none;
      padding: 0;
      color: #707070;
      font-size: 18px;
    }
    .srch_bar .input-group-addon { margin: 0 0 0 -27px;}

    .chat_ib h5{ font-size:15px; color:#464646; margin:0 0 8px 0;}
    .chat_ib h5 span{ font-size:13px; float:right;}
    .chat_ib p{ font-size:14px; color:#989898; margin:auto}
    .chat_img {
      float: left;
      width: 11%;
    }
    .chat_ib {
      float: left;
      padding: 0 0 0 15px;
      width: 88%;
    }

    .chat_people{ overflow:hidden; clear:both;}
    .chat_list {
      border-bottom: 1px solid #c4c4c4;
      margin: 0;
      padding: 18px 16px 10px;
    }
    .inbox_chat { height: 550px; overflow-y: scroll;}

    .active_chat{ background:#ebebeb;}

    .incoming_msg_img {
      display: inline-block;
      width: 5%;
    }
    .received_msg {
      display: inline-block;
      padding: 0 0 0 10px;
      vertical-align: top;
      width: 92%;
     }
     .received_withd_msg p {
      background: #ebebeb none repeat scroll 0 0;
      border-radius: 3px;
      color: #646464;
      font-size: 14px;
      margin: 0;
      padding: 5px 10px 5px 12px;
      width: 100%;
    }
    .time_date {
      color: #747474;
      display: block;
      font-size: 12px;
      margin: 8px 0 0;
    }
    .received_withd_msg { width: 57%;}

    .sent_msg p {
      background: #05728f none repeat scroll 0 0;
      border-radius: 3px;
      font-size: 14px;
      margin: 0; color:#fff;
      padding: 5px 10px 5px 12px;
      width:100%;
    }
    .incoming_msg {
        margin-bottom: 10px;
    }
    .outgoing_msg{ overflow:hidden; margin:26px 0 26px; margin-bottom: 10px;}
    .sent_msg {
      float: right;
      width: 46%;
    }
    .input_msg_write input {
      background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
      border: medium none;
      color: #4c4c4c;
      font-size: 15px;
      min-height: 48px;
      width: 100%;
    }

    .type_msg {border-top: 1px solid #c4c4c4;position: relative;}
    .msg_send_btn {
      background: #05728f none repeat scroll 0 0;
      border: medium none;
      border-radius: 50%;
      color: #fff;
      cursor: pointer;
      font-size: 17px;
      height: 33px;
      position: absolute;
      right: 0;
      top: 11px;
      width: 33px;
    }
    .messaging { padding: 0 0 50px 0;}
    .msg_history {
      height: 48vh;
      overflow-y: auto;
    }
    .chat-close {
        border-radius: 50%;
        border: 1px solid #646464;
        height: 20px;
        width: 20px;
        text-align: center;
        padding: 0;
        line-height: 0.8 !important;
    }
</style>

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                @if($conversation)
                    <div class="card-header">
                        <h5 class="card-title">
                            <strong>{{$conversation->subject ?? $conversation->message_subject}}</strong> 
                            @if($tab != 'closed' && $chat != 'leave-feedback')
                                <span>
                                    <a href="{{route('admin.chats.conversation.close', [$chat, $conversation->chat_code])}}" onclick="return confirm('Are you sure you want to end this chat?');" class="close chat-close">
                                      <span aria-hidden="true">&times;</span>
                                    </a>
                                </span>
                            @endif
                        </h5>
                        {{-- <p class="card-text">{{$conversation->description}}</p> --}}
                    </div>
                    <div class="card-body pt-0">
                        <div class="msg_history pt-3">
                            @php $conversation->chat_history = @json_decode($conversation->chat_history ?? $conversation->chat_hostory) ?? []; @endphp
                            @foreach($conversation->chat_history as $message)
                                @if($message->id == $conversation->principal_code)
                                    <div class="incoming_msg">
                                        <div class="incoming_msg_img"> 
                                            <img src="{{asset('/assets/principal/images/profile/'. $conversation->principal->profile_image)}}" class="img-thumbnail" />
                                        </div>
                                        <div class="received_msg">
                                            <div class="received_withd_msg">
                                                <p>
                                                    <strong>{{$conversation->principal->first_name}} {{$conversation->principal->last_name}}</strong> <br/>
                                                    {{$message->message}}
                                                </p>
                                                <span class="time_date">{{date('m-d-Y h:i A', round($message->date/1000))}}</span>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($message->id == $conversation->coach_code)
                                    <div class="incoming_msg">
                                        <div class="incoming_msg_img"> 
                                            <img src="{{asset('/assets/coach/images/profile/'. $conversation->coach->profile_image)}}" class="img-thumbnail" />
                                        </div>
                                        <div class="received_msg">
                                            <div class="received_withd_msg">
                                                <p>
                                                    <strong>{{$conversation->coach->first_name}} {{$conversation->coach->last_name}}</strong> <br/>
                                                    {{$message->message}}
                                                </p>
                                                <span class="time_date">{{date('m-d-Y h:i A', round($message->date/1000))}}</span>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($message->id == ($conversation->technical_user_code ?? $conversation->admin_user_code) 
                                        || (is_int($message->id))
                                    )
                                    <div class="outgoing_msg">
                                        <div class="sent_msg">
                                            <p>{{$message->message}}</p>
                                            <span class="time_date">{{date('m-d-Y h:i A', round($message->date/1000))}}</span>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        @if($tab == 'closed')
                            <div class="px-2 py-1 bg-danger text-white text-center">
                                <p>Chat Completed. Thank you!</p>
                            </div>
                        @endif
                        @if($tab != 'closed')
                            <div class="type_msg">
                                <div class="input_msg_write">
                                    <form action="{{route('admin.chats.conversation.submit', [$chat, $conversation->chat_code])}}" method="POST">
                                        @csrf
                                        <input type="text" class="write_msg" name="message" autocomplete="off" placeholder="Type a message" maxlength="448" onkeyup="$('#strlength').text(this.value.length);"/>
                                        <p class="text--small text-muted">
                                            <span id="strlength">0</span>/448
                                        </p>
                                        <button class="msg_send_btn" type="submit"><i class="fas fa-paper-plane" aria-hidden="true"></i></button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    @if($chat=='technical-support')
        <a href="{{route('admin.chats.technical_support', $tab)}}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="la la-fw la-backward"></i> @lang('Go Back') </a>
    @elseif($chat=='coaching-question')
        <a href="{{route('admin.chats.coaching_question', $tab)}}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="la la-fw la-backward"></i> @lang('Go Back') </a>
    @elseif($chat=='leave-feedback')
        <a href="{{route('admin.chats.leave_feedback')}}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="la la-fw la-backward"></i> @lang('Go Back') </a>
    @elseif($chat=='other')
        <a href="{{route('admin.chats.other', $tab)}}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="la la-fw la-backward"></i> @lang('Go Back') </a>
    @endif
@endpush

@push('script')
    <script type="text/javascript">
        // scroll to the bottom of the messages 
        $('.msg_history').scrollTop($('.msg_history')[0].scrollHeight);

        @if($conversation && $conversation->chat_code)
            let isNotified = false;
            setInterval(function(){
                $.get('{{route("admin.chats.get_chat_update", [$chat, $conversation->chat_code])}}', 
                    {last_updated_at: '{{$conversation->updated_at}}'}, 
                    function (response, status) {
                    //
                    data = response.data;
                    if(data.length > 0 && !isNotified) {
                        iziToast.info({
                            title: '',
                            message: 'You have a new messages, please refresh the page!',
                            position: 'topRight',
                        });
                        isNotified = true;
                    }
                });
            }, 5000);
        @endif
    </script>
@endpush
