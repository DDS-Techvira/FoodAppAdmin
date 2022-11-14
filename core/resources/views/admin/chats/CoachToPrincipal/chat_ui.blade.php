@extends('admin.layouts.app')
@push('style')
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
       
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
              
        <!-- Font Awesome JS -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
        <style>
    body,html{
      height: 100%;
      margin: 0;
      background: #7F7FD5;
    background: -webkit-linear-gradient(to right, #91EAE4, #86A8E7, #7F7FD5);
      background: linear-gradient(to right, #91EAE4, #86A8E7, #7F7FD5);
    }
    .chat{
      margin-top: auto;
      margin-bottom: auto;
      }
      .card{
          height: 550px;
          border-radius: 15px !important;
          background-color: rgba(0,0,0,0.4) !important;
      }
      .contacts_body{
          padding:  0.75rem 0 !important;
          overflow-y: auto;
          white-space: nowrap;
      }
      .msg_card_body{
          overflow-y: auto;
      }
      .card-header{
          border-radius: 15px 15px 0 0 !important;
          border-bottom: 0 !important;
      }
      .card-footer{
      border-radius: 0 0 15px 15px !important;
          border-top: 0 !important;
      }
      .container{
          align-content: center;
      }
      .search{
          border-radius: 15px 0 0 15px !important;
          background-color: rgba(0,0,0,0.3) !important;
          border:0 !important;
          color:white !important;
      }
      .search:focus{
          box-shadow:none !important;
        outline:0px !important;
      }
      .type_msg{
          background-color: rgba(0,0,0,0.3) !important;
          border:0 !important;
          color:white !important;
          height: 60px !important;
          overflow-y: auto;
      }
          .type_msg:focus{
          box-shadow:none !important;
        outline:0px !important;
      }
      .attach_btn{
      border-radius: 15px 0 0 15px !important;
      background-color: rgba(0,0,0,0.3) !important;
          border:0 !important;
          color: white !important;
          cursor: pointer;
      }
      .send_btn{
      border-radius: 0 15px 15px 0 !important;
      background-color: rgba(0,0,0,0.3) !important;
          border:0 !important;
          color: white !important;
          cursor: pointer;
      }
      .search_btn{
          border-radius: 0 15px 15px 0 !important;
          background-color: rgba(0,0,0,0.3) !important;
          border:0 !important;
          color: white !important;
          cursor: pointer;
      }
      .contacts{
          list-style: none;
          padding: 0;
      }
      .contacts li{
          width: 100% !important;
          padding: 5px 10px;
          margin-bottom: 15px !important;
      }
      .active{
          background-color: rgba(0,0,0,0.3);
      }
      .user_img{
          height: 70px;
          width: 70px;
          border:1.5px solid #f5f6fa;
      }
      .user_img_msg{
          height: 40px;
          width: 40px;
          border:1.5px solid #f5f6fa;
      }
      .img_cont{
          position: relative;
          height: 70px;
          width: 70px;
      }
      .img_cont_msg{
          height: 40px;
          width: 40px;
      }
      .online_icon{
      position: absolute;
      height: 15px;
      width:15px;
      background-color: #4cd137;
      border-radius: 50%;
      bottom: 0.2em;
      right: 0.4em;
      border:1.5px solid white;
      }
      .offline{
      background-color: #c23616 !important;
      }
      .user_info{
      margin-top: auto;
      margin-bottom: auto;
      margin-left: 15px;
      }
      .user_info span{
      font-size: 20px;
      color: white;
      }
      .user_info p{
      font-size: 10px;
      color: rgba(255,255,255,0.6);
      }
      .video_cam{
      margin-left: 50px;
      margin-top: 5px;
      }
      .video_cam span{
      color: white;
      font-size: 20px;
      cursor: pointer;
      margin-right: 20px;
      }
      .msg_cotainer{
      margin-top: auto;
      margin-bottom: auto;
      margin-left: 10px;
      border-radius: 25px;
      background-color: #82ccdd;
      padding: 10px;
      position: relative;
      }
      .msg_cotainer_send{
      margin-top: auto;
      margin-bottom: auto;
      margin-right: 10px;
      border-radius: 25px;
      background-color: #78e08f;
      padding: 10px;
      position: relative;
      }
      .msg_time{
      position: absolute;
      left: 0;
      bottom: -15px;
      color: rgba(255,255,255,0.5);
      font-size: 10px;
      }
      .msg_time_send{
      position: absolute;
      right:0;
      bottom: -15px;
      color: rgba(255,255,255,0.5);
      font-size: 10px;
      }
      .msg_head{
      position: relative;
      }
      #action_menu_btn{
      position: absolute;
      right: 10px;
      top: 10px;
      color: white;
      cursor: pointer;
      font-size: 20px;
      }
      .action_menu{
      z-index: 1;
      position: absolute;
      padding: 15px 0;
      background-color: rgba(0,0,0,0.5);
      color: white;
      border-radius: 15px;
      top: 30px;
      right: 15px;
      display: none;
      }
      .action_menu ul{
      list-style: none;
      padding: 0;
      margin: 0;
      }
      .action_menu ul li{
      width: 100%;
      padding: 10px 15px;
      margin-bottom: 5px;
      }
      .action_menu ul li i{
      padding-right: 10px;
      }
      .action_menu ul li:hover{
      cursor: pointer;
      background-color: rgba(0,0,0,0.2);
      }
      @media(max-width: 576px){
      .contacts_card{
      margin-bottom: 15px !important;
      }
      }
      /* width */
      ::-webkit-scrollbar {
        width: 10px;
      }
      /* Track */
      ::-webkit-scrollbar-track {
        box-shadow: inset 0 0 5px grey; 
        border-radius: 10px;
      }
      
      /* Handle */
      ::-webkit-scrollbar-thumb {
        background: #7F7FD5; 
        border-radius: 10px;
      }
      /* Handle on hover */
      ::-webkit-scrollbar-thumb:hover {
        background: #5454b6; 
      }
    </style>
@endpush
@push('scripts')
<script>
    $(document).ready(function(){
      $('#action_menu_btn').click(function(){
        $('.action_menu').toggle();
    });
    })
   
    </script>
@endpush



 
        
  
  
  
  
    
 
@section('panel')
 
    <div class="fluid ">
    <div class="row justify-content-center h-100">
      <div class="col-md-4 col-xl-3 chat"><div class="card mb-sm-3 mb-md-0 contacts_card">
        <div class="card-header">
          <div class="input-group">
            <input type="text" placeholder="Search..." name="" class="form-control search">
            <div class="input-group-prepend">
              <span class="input-group-text search_btn"><i class="fas fa-search"></i></span>
            </div>
          </div>
        </div>
        <div class="card-body contacts_body">
          <ul class="contacts">
          @forelse($chats as $chat)
          <li class="">
            <div class="d-flex bd-highlight">
              <div class="img_cont">
                <img src="https://theprincipalsclub.ams3.digitaloceanspaces.com/assets/principal/images/profile/{{ $chat->profile_image }}" class="rounded-circle user_img">
                <span class="online_icon"></span>
              </div>
              <div class="user_info">
                
                <span>{{$chat->message_subject}}</span>
                <p>{{$chat->description}}</p>
              </div>
            </div>
          </li>
          @endforeach
          <!-- <li>
            <div class="d-flex bd-highlight">
              <div class="img_cont">
                <img src="https://therichpost.com/wp-content/uploads/2020/06/avatar2.png" class="rounded-circle user_img">
                <span class="online_icon offline"></span>
              </div>
              <div class="user_info">
                <span>jassa</span>
                <p>Taherah left 7 mins ago</p>
              </div>
            </div>
          </li>
          <li>
            <div class="d-flex bd-highlight">
              <div class="img_cont">
                <img src="https://therichpost.com/wp-content/uploads/2020/06/avatar2.png" class="rounded-circle user_img">
                <span class="online_icon"></span>
              </div>
              <div class="user_info">
                <span>jassa Mann</span>
                <p>Sami is online</p>
              </div>
            </div>
          </li>
          <li>
            <div class="d-flex bd-highlight">
              <div class="img_cont">
                <img src="https://therichpost.com/wp-content/uploads/2020/06/avatar2.png" class="rounded-circle user_img">
                <span class="online_icon offline"></span>
              </div>
              <div class="user_info">
                <span>jassa Mann</span>
                <p>Nargis left 30 mins ago</p>
              </div>
            </div>
          </li>
          <li>
            <div class="d-flex bd-highlight">
              <div class="img_cont">
                <img src="https://therichpost.com/wp-content/uploads/2020/06/avatar2.png" class="rounded-circle user_img">
                <span class="online_icon offline"></span>
              </div>
              <div class="user_info">
                <span>jassa Mann</span>
                <p>Rashid left 50 mins ago</p>
              </div>
            </div>
          </li> -->
        </ul>
        </div>
        <div class="card-footer"></div>
      </div></div>
      <div class="col-md-8 col-xl-6 chat">
        <div class="card">
          <div class="card-header msg_head">
            <div class="d-flex bd-highlight">
              <div class="img_cont">
                <img src="https://theprincipalsclub.ams3.digitaloceanspaces.com/assets/principal/images/profile/{{ $chat_messages->profile_image }}" class="rounded-circle user_img">
                <!-- <span class="online_icon"></span> -->
              </div>
              <div class="user_info">
                <span>Chat with {{$chat_messages->first_name}} - {{$chat_messages->last_name}}</span>
                <span>{{$chat_messages->message_subject}}</span>
                <p>{{$chat_messages->description}}</p>
                        <!-- <p>1767 Messages</p> -->

              </div>
            
            </div>
            <span id="action_menu_btn"><i class="fas fa-ellipsis-v"></i></span>
            <div class="action_menu">
              <ul>
                <li><i class="fas fa-user-circle"></i> View profile</li>
                <li><i class="fas fa-users"></i> Add to close friends</li>
                <li><i class="fas fa-plus"></i> Add to group</li>
                <li><i class="fas fa-ban"></i> Block</li>
              </ul>
            </div>
          </div>
          <div class="card-body msg_card_body">

          @forelse($chatMessages as $chat)
            <div class="d-flex justify-content-start mb-4">
              <div class="img_cont_msg">
              <span class="msg_time">8:40 AM, Today</span>
              </div>
              <div class="msg_cotainer">
              {{$chat->message}}
              
              </div>
              
            </div>
           <!-- <div class="d-flex justify-content-end mb-4">
              <div class="msg_cotainer_send">
                Hi jassa i am good tnx how about you?
                <span class="msg_time_send">8:55 AM, Today</span>
              </div>
              <div class="img_cont_msg">
               <img src="https://therichpost.com/wp-content/uploads/2020/06/avatar2.png" class="rounded-circle user_img_msg">
            </div> -->
          @endforeach


            <!--  </div>
            <div class="d-flex justify-content-start mb-4">
              <div class="img_cont_msg">
                <img src="https://therichpost.com/wp-content/uploads/2020/06/avatar2.png" class="rounded-circle user_img_msg">
              </div>
              <div class="msg_cotainer">
                I am good too, thank you for your chat template
                <span class="msg_time">9:00 AM, Today</span>
              </div>
            </div>
            <div class="d-flex justify-content-end mb-4">
              <div class="msg_cotainer_send">
                You are welcome
                <span class="msg_time_send">9:05 AM, Today</span>
              </div>
              <div class="img_cont_msg">
            <img src="https://therichpost.com/wp-content/uploads/2020/06/avatar2.png" class="rounded-circle user_img_msg">
              </div>
            </div>
            <div class="d-flex justify-content-start mb-4">
              <div class="img_cont_msg">
                <img src="https://therichpost.com/wp-content/uploads/2020/06/avatar2.png" class="rounded-circle user_img_msg">
              </div>
              <div class="msg_cotainer">
                I am looking for your next templates
                <span class="msg_time">9:07 AM, Today</span>
              </div>
            </div>
            <div class="d-flex justify-content-end mb-4">
              <div class="msg_cotainer_send">
                Ok, thank you have a good day
                <span class="msg_time_send">9:10 AM, Today</span>
              </div>
              <div class="img_cont_msg">
          <img src="https://therichpost.com/wp-content/uploads/2020/06/avatar2.png" class="rounded-circle user_img_msg">
              </div>
            </div>
            <div class="d-flex justify-content-start mb-4">
              <div class="img_cont_msg">
                <img src="https://therichpost.com/wp-content/uploads/2020/06/avatar2.png" class="rounded-circle user_img_msg">
              </div>
              <div class="msg_cotainer">
                Bye, see you
                <span class="msg_time">9:12 AM, Today</span>
              </div>
            </div> -->
          </div>
          <div class="card-footer">
            <div class="input-group">
              <div class="input-group-append">
                <span class="input-group-text attach_btn"><i class="fas fa-paperclip"></i></span>
              </div>
              <textarea name="" class="form-control type_msg" placeholder="Type your message..."></textarea>
              <div class="input-group-append">
                <span class="input-group-text send_btn"><i class="fas fa-location-arrow"></i></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
        
  @endsection
