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
                        <a class="nav-link text-center {{$tab == 'new' ? 'active' : ''}}" id="new-chats-tab" href="{{route('admin.chats.other', 'new')}}">New</a>
                    </li>
                    <li class="nav-item col">
                        <a class="nav-link text-center {{$tab == 'ongoing' ? 'active' : ''}}" id="ongoing-chats-tab" href="{{route('admin.chats.other', 'ongoing')}}">Ongoing</a>
                    </li>
                    <li class="nav-item col">
                        <a class="nav-link text-center {{$tab == 'closed' ? 'active' : ''}}" id="closed-chats-tab" href="{{route('admin.chats.other', 'closed')}}">Closed</a>
                    </li>
                </ul>

                <div class="tab-content" id="pills-tab-content">
                    <div class="tab-pane fade show active" id="new-chats">
                        <div class="col">
                            @if($tab == 'new')
                                @foreach($chats as $chat)
                                    <a href="#" class="card mb-3 p-2 chat-card" data-toggle="modal" data-target="#modal-{{$chat->chat_code}}">
                                        <div class="media">
                                            @if($chat->principal)
                                                <img src="{{ asset('/assets/principal/images/profile/'.$chat->principal->profile_image)}}" class="mr-3 img-thumbnail" width="64" />
                                            @else
                                                <img src="{{ asset('/assets/images/plaseholder.png')}}" class="mr-3 img-thumbnail" width="64" />
                                            @endif
                                            <div class="media-body">
                                                <h5 class="mt-0">{{$chat->principal->first_name}} {{$chat->principal->last_name}}</h5>
                                                <h5 class="mt-0">{{$chat->subject}}</h5>
                                                <p class="">{{$chat->description}}</p>
                                                <p class=""><small class="text-muted">Last updated at {{date('m-d-Y h:i A', strtotime($chat->updated_at))}}</small></p>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="modal fade" id="modal-{{$chat->chat_code}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">{{$chat->subject}}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>{{$chat->description}}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="#" class="btn btn-secondary" data-dismiss="modal">Close</a>
                                                    <a href="{{route('admin.chats.conversation.accept', ['other', $chat->chat_code])}}" class="btn btn-primary">Accept</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @elseif($tab == 'ongoing' Or $tab == 'closed')
                                @foreach($chats as $chat)
                                    <a href="{{route('admin.chats.conversation', ['other', $tab, $chat->chat_code])}}" class="card mb-3 p-2 chat-card {{($tab == 'ongoing' && $chat->principal_replied === 1)?'chat-highlighted':''}}">
                                        <div class="media">
                                            @if($chat->principal)
                                                <img src="{{ asset('/assets/principal/images/profile/'.$chat->principal->profile_image)}}" class="mr-3 img-thumbnail" width="64" />
                                            @else
                                                <img src="{{ asset('/assets/images/plaseholder.png')}}" class="mr-3 img-thumbnail" width="64" />
                                            @endif
                                            <div class="media-body">
                                                <h5 class="mt-0">{{$chat->principal->first_name}} {{$chat->principal->last_name}}</h5>
                                                <h5 class="mt-0">{{$chat->subject}}</h5>
                                                <p class="">{{$chat->description}}</p>
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
