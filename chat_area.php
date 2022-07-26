<!doctype html>
<html>
    <head>
        <script type="text/javascript"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
    </head>
    <style> 
        *{
            margin: 0px;
            padding: 0px;
            
        }
        #main{
            margin: auto;
            max-width: 550px;
            font: 15px arial, sans-serif;
            background-color: white;
            border-style: solid;
            border-width: 1px;
            padding-top: 20px;
            padding-bottom: 25px;
            padding-right: 25px;
            padding-left: 25px;
            box-shadow: 5px 5px 5px grey;
            border-radius: 15px;
        }
        #msgArea{
            border: 1px solid grey;
            width: 95%;
            padding: 0% 2%;
            height: 400px;
            margin: 10px auto;
            overflow: auto;
            

        }
        #logo{
            display: flex;
            justify-content: center;

        }
        #title{
            font-size: 30px;
            display: flex;
            justify-content: center;
            padding-bottom: 20px;
            font-family: "Lucida Console", "Courier New", monospace;
        }
        a{
            font-size: 15px;
            padding-right: 10;
        }
        
        
    </style>
    
<body>
<div id="logo">
    <img src="logo.png" alt="logo" width="200" height="200">
</div>
<?php
    
    session_start();
    include("connection.php");
    
    $_SESSION['current_chat_room'] = $_POST['room_name'];
    $_SESSION['messages'] = array();
    $_SESSION['messages_length'] = 0;
    if (isset($_SESSION['user_name'])){ //if the session is runnning
        
        echo '<h2>Welcome to the chat ' . $_SESSION['user_name'] . ' in the '. $_SESSION['current_chat_room'] .' chat </h2>
            <form method="post">
                <input type="submit" name="exitChat" class="button" value="Exit '. $_SESSION['current_chat_room'] .'" />
            </form>';

        $incrementQuery = "UPDATE test.chat_rooms SET room_amount = room_amount + 1 WHERE room_name = '" .$_SESSION['current_chat_room']. "'";
        mysqli_query($con,$incrementQuery);
        if (array_key_exists('exitChat', $_POST)) { 
            exitChat(trim($_POST['exitChat'], "Exit ")); 
        }
    } else {  //if the session is not running then the user is directed to the homescreen
        header("Location: homescreen.php");
    }

    function exitChat($room) {
        include('connection.php');
        $decrementQuery = "UPDATE test.chat_rooms SET room_amount = room_amount - 1 WHERE room_name = '" .$room. "' AND room_amount > 0";
        mysqli_query($con, $decrementQuery);
        header("Location: chat_rooms.php");
    }
?>
<div>
    <form method="post">
        <button type="submit">Change Username</button>
    </form>
</div>
<div id = "main">
    <div id = "msgArea">        
        <script>
            // Loads file containng log.html to print contents
            function loadLog() {
                $.ajax({
                    url: "log.php",
                    cache: false,
                    success: function(html) {
                        $("#msgArea").html(html);
                    }
                });
            }
        </script>
    </div>
    
    <form method= "post">
        <input type = "text" name = "message_typed" style= "width: 300px; height: 50px;" id = "usermsg" placeholder = "Your message goes here!" />
        <input type = "submit" name = "submit" style = "width: 80px; height: 50px; " value = "Send" id="submitmsg"/>
    </form>
    <script>
        // Action when submitting message
        // Executes chat.php to format text and write to log.html
        $("#submitmsg").click(function(){	
            var clientmsg = $("#usermsg").val();
            $.post("chat.php", {text: clientmsg});				
            $("#usermsg").attr("value", "");
            return false;
        });
    </script>
</div>
<script>
    // Keep updating the page for new messages
    setInterval (loadLog, 1000);
</script>
</body>
</html>
