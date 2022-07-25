<!doctype html>
<html>
    <style> 
        *{
            margin: 0px;
            padding: 0px;
        }
        #main{
            border: 1px solid black;
            width: 400px;
            height: 500px;
            margin: 24px auto;
        }
        #msgArea{
            border: 1px solid grey;
            width: 95%;
            padding: 0% 2%;
            height: 400px;
            margin: 10px auto;
            overflow: auto;
            

        }
    </style>
    
<body>
<?php
//print('I come to this page lOL');
// if you want to make changes please feel free
    session_start();
    if (isset($_SESSION['user_name'])){ //if the session is runnning
        echo '<h2>Welcome to the chat ' . $_SESSION['user_name'] . '! </h2>
            <form method="post">
                <input type="submit" name="exitChat" class="button" value="Exit Chat" />
            </form>';
        if (array_key_exists('exitChat', $_POST)) { exitChat(); }
    } else {  //if the session is not running then the user is directed to the homescreen
        header("Location: homescreen.php");
    }

    function exitChat() {
        header("Location: homescreen.php");
        session_destroy();
    }
?>
<div id = "main">
    <div id = "msgArea">
        <?php 
            include("connection.php");
            $message_holder = array();
            $queryDisplay = "SELECT * FROM test.message";   // selecting everything from the database
            $store = mysqli_query($con, $queryDisplay); //storing the query in the $store variable
            //displaying all the old messages
            // while($rows = mysqli_fetch_assoc($store)){ // looping through each row of the table
            //     $message_old = $rows['message_text'];  // storing the message from the database in the $message_old variable
            //     $userName_old = $rows['user_name'];    // storing the username of the sender from the database in the $userName_old variable
            //     if (!in_array($message_old, $message_holder)){
            //         array_push($message_holder, $message_old); 
            //         //displaying the user names and the messages
            //         echo '<h4 style = "color: blue">' .$userName_old. '</h4>';  
            //         echo '<p>' .$message_old. '</p>';
            //         echo '<hr>'; // add a line after every message
            //         //Maybe Fixed??? -- Problem with this above code? when the other end user sends a message, it is not displayed until screen is refreshed
            //     }
            // }
        ?>
        
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
        <script>
            // Loads file containng log.html to print contents
            function loadLog() {
                $.ajax({
                    url: "log.html",
                    cache: false,
                    success: function(html) {
                        $("#msgArea").html(html); //Insert chat log into the the chat area			
                    },
                });
            }
        </script>
    </div>
    <form method= "post">
        <input type = "text" name = "message_typed" style= "width: 300px; height: 50px;" id = "usermsg" placeholder = "Your message goes here!" size="63" />
        <input type = "submit" name = "submit" style = "width: 80px; height: 50px; " value = "Send" id="submitmsg" />
    </form>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
    <script>
        // Action when submitting message
        // Executes chat.php to format text and write to log.html
        $("#submitmsg").click(function(){	
            var clientmsg = $("#usermsg").val();
            $.post("chat.php", {text: clientmsg, type: "send"});				
            $("#usermsg").attr("value", "");
            return false;
        });
    </script>
</div>
<script type="text/javascript"></script>
<script>
    // Keep updating the page for new messages
    setInterval (loadLog, 1000);
</script>
</body>
</html>