@extends('layouts.app')

@section('content')
    <div class="user_partner">
        <h1 > {{$user_partner->username}}</h1>
    </div>
    <ul id="messages">
        @foreach ($messages as $message)
            <li><strong>{{$message->user->username}}: </strong>
                <p>{{$message->message}} </p></li>        @endforeach
    </ul>
    <span id='type' style="position: fixed; bottom: 10%;"></span>
    <form action="" id="chat">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="user" value="{{ Auth::user()->username }}">
        <input class="msg" autocomplete="off"/>
        <button>Send</button>
    </form>
@section('my-script')

    <script>
        $(function () {
            var socket = io('http://localhost:6969');
            $('#chat').submit(function () {
                var token = $("input[name='_token']").val();
                var user = $("input[name='user']").val();
                var msg = $(".msg").val();
                var partner = $(".user_partner h1").text();
                if (msg != '') {

                    $.ajax({
                        type: "POST",
                        url: '{!! URL::to("sendmessage") !!}',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {
                            '_token': token,
                            'message': msg,
                            'user': user,
                            'partner' : partner
                        },
                        success: function (data) {
                            console.log(1);
                            $(".msg").val('');

                        },
                        error: function (data) {
                            console.log(partner);
                        }
                    });
                    return false;
                } else {
                    alert("Please Add Message.");
                }

            });

            socket.on('sendMessage', function (data) {
                $("#messages").append("<li><strong>" + data.user + ":</strong><p>" + data.message + "</p></li>");
            })
        })
    </script>
@endsection
@endsection
