<?php
session_start();
include("connection.php");

if(isset($_SESSION['user_name'])){
    $message_text = $_POST['text']; //storing the input into the $message_text variable

    if ($message_text !== "") {
        $fp = fopen($_SESSION['current_chat_room'].".html", 'a');
        fwrite($fp, "<div class='msgln'><b>".$_SESSION['user_name']."</b>: ".stripslashes(htmlspecialchars($message_text))."<br></div>");
        fclose($fp);
        $query = "INSERT INTO message (id, user_name, message_text, room_name)
                VALUES(0, '".$_SESSION['user_name']."', '".$message_text."', '".$_SESSION['current_chat_room']."')"; // Inserting the id, message, and the user name into the databsae
        mysqli_query($con,$query);
    }
}
?>