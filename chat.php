<?php
session_start();
// Make sure there is an active session by checking name
$type = $_POST['type'];

if ($type === 'send') { send(); }
elseif ($type === 'retrieve'){ retrieve(); }

function send() {
    if(isset($_SESSION['user_name'])){
        include("connection.php");
        $message_text = $_POST['text']; //storing the input into the $message_text variable
    
        if ($message_text !== "") {
            $fp = fopen("log.html", 'a');
            fwrite($fp, "<div class='msgln'><b>".$_SESSION['user_name']."</b>: ".stripslashes(htmlspecialchars($message_text))."<br></div>");
            fclose($fp);
            $query = "INSERT INTO message (id, user_name, message_text)
                    VALUES(0, '".$_SESSION['user_name']."', '".$message_text."')"; // Inserting the id, message, and the user name into the databsae
            mysqli_query($con,$query);
        }
    }
}

function retrieve() {

}

?>