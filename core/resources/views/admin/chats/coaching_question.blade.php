@extends('admin.layouts.app')
<style type="text/css">
    .chat-card:hover {box-shadow: 1px 2px 5px 0px rgb(14 20 69 / 40%) !important;}
    .chat-highlighted {box-shadow: 1px 2px 5px 1px rgb(0 6 88) !important;}
</style>
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <ul class="nav nav-pills py-3" id="pills-tab">
                    <li class="nav-item col">
                        <a class="nav-link text-center {{$tab == 'new' ? 'active' : ''}}" id="new-chats-tab" href="{{route('admin.chats.coaching_question', 'new')}}">New</a>
                    </li>
                    <li class="nav-item col">
                        <a class="nav-link text-center {{$tab == 'ongoing' ? 'active' : ''}}" id="ongoing-chats-tab" href="{{route('admin.chats.coaching_question', 'ongoing')}}">Ongoing</a>
                    </li>
                    <li class="nav-item col">
                        <a class="nav-link text-center {{$tab == 'closed' ? 'active' : ''}}" id="closed-chats-tab" href="{{route('admin.chats.coaching_question', 'closed')}}">Closed</a>
                    </li>
                </ul>

                <div class="tab-content" id="pills-tab-content">
                    <div class="tab-pane fade show active" id="new-chats">
                        <div class="col">
                            @if($tab == 'new')
                                @foreach($chats as $chat)
                                    <a href="#" class="card mb-3 p-2 chat-card">
                                        <div class="media">
                                            @if($chat->coach)
                                                <img src="{{ asset('/assets/coach/images/profile/'.$chat->coach->profile_image)}}" class="mr-3 img-thumbnail" width="64" />
                                            @else
                                                <img src="{{ asset('/assets/images/plaseholder.png')}}" class="mr-3 img-thumbnail" width="64" />
                                            @endif
                                            <div class="media-body">
                                                <h5 class="mt-0">{{$chat->principal->first_name}} {{$chat->principal->last_name}}</h5>
                                                <h5 class="mt-0">{{$chat->message_subject}}</h5>
                                                <p class="">{{$chat->description}}</p>
                                                <p class=""><small class="text-muted">Last updated at {{date('m-d-Y h:i A', strtotime($chat->updated_at))}}</small></p>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @elseif($tab == 'ongoing' Or $tab == 'closed')
                                @foreach($chats as $chat)
                                    <a href="{{route('admin.chats.conversation', ['coaching-question', $tab, $chat->chat_code])}}" class="card mb-3 p-2 chat-card {{!($chat->principal_replied && $chat->coach_replied) && ($chat->principal_replied || $chat->coach_replied)?'chat-highlighted':''}}">
                                        <div class="media">
                                            @if($chat->coach)
                                                <img src="{{ asset('/assets/coach/images/profile/'.$chat->coach->profile_image)}}" class="mr-3 img-thumbnail" width="64" />
                                            @else
                                                <img src="{{ asset('/assets/images/plaseholder.png')}}" class="mr-3 img-thumbnail" width="64" />
                                            @endif
                                            <div class="media-body">
                                                <h5 class="mt-0">{{$chat->principal->first_name}} {{$chat->principal->last_name}}</h5>
                                                <h5 class="mt-0">{{$chat->message_subject}}</h5>
                                                <p class="">{{$chat->description ?? $chat->message_description}}</p>
                                                <p class=""><small class="text-muted">Last updated at {{date('m-d-Y h:i A', strtotime($chat->updated_at))}}</small></p>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
