<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body { font: 13px Helvetica, Arial; }
            form { background: #000; padding: 3px; position: fixed; bottom: 0; width: 100%; }
            form input { border: 0; padding: 10px; width: 90%; margin-right: .5%; }
            form button { width: 9%; background: rgb(130, 224, 255); border: none; padding: 10px; }
            #messages { list-style-type: none; margin: 0; padding: 0; }
            #messages li { padding: 5px 10px; }
            #messages li:nth-child(odd) { background: #eee; }
        </style>
    </head>
    <body>
        <ul id="messages"></ul>
        <span id='type' style="position: fixed; bottom: 10%;"></span>
        <form action="">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" >
            <input type="hidden" name="user" value="{{ Auth::user()->name }}" >
            <input class="msg" autocomplete="off" /><button>Send</button>
        </form>
        <div id="test"></div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.3/socket.io.js">  </script>
        <script src="https://code.jquery.com/jquery-1.11.1.js"></script>
        <script>
            $(function () {
                var socket = io('http://localhost:3000');
                $('form').submit(function(){
                    e.preventDefault();
                    var token = $("input[name='_token']").val();
                    var user = $("input[name='user']").val();
                    var msg = $(".msg").val();
                    if(msg != ''){
                        $.ajax({
                            type: "POST",
                            url: '{!! URL::to("sendmessage") !!}',
                            dataType: "json",
                            data: {'_token':token,'message':msg,'user':user},
                            success:function(data){
                                console.log(data);
                                $(".msg").val('');
                            }
                        });
                    }else{
                        alert("Please Add Message.");
                    }
                });

                socket.on('test-channel:App\\Events\\UserSignedUp', function (data) {
                    $( "#messages" ).append( "<li><strong>"+data.user+":</strong><p>"+data.message+"</p></li>" );
                })
            })
        </script>
    </body>
</html>
