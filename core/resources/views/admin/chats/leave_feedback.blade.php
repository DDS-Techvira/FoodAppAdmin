@extends('admin.layouts.app')
<style type="text/css">
    .chat-card:hover {box-shadow: 1px 2px 5px 0px rgb(14 20 69 / 40%) !important;}
    .chat-highlighted {box-shadow: 1px 2px 5px 1px rgb(0 6 88) !important;}
</style>
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="tab-content" id="pills-tab-content">
                    <div class="tab-pane fade show active" id="new-chats">
                        <div class="col">
                            @foreach($chats as $chat)
                                <a href="{{route('admin.chats.conversation', ['leave-feedback', $tab, $chat->chat_code])}}" class="card mb-3 p-2 chat-card {{($chat->principal_replied === 1)?'chat-highlighted':''}}">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
