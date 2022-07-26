<?php 
    session_start();
    include("connection.php");
    $message_holder = array();
    $queryDisplay = "SELECT * FROM test.message WHERE room_name = '" . $_SESSION['current_chat_room'] . "'";   // selecting everything from the database
    $store = mysqli_query($con, $queryDisplay); //storing the query in the $store variable
    // displaying all the old messages
    if ($store){
    if (mysqli_query($con, $queryDisplay)->num_rows > $_SESSION['messages_length']){ 
        if (file_exists($_SESSION['current_chat_room'] . ".html")) {
            $fp = fopen($_SESSION['current_chat_room'] . ".html", 'r+');
            ftruncate($fp, 0);
            fclose($fp);
        }
        while($rows = mysqli_fetch_assoc($store)){ // looping through each row of the table
            $message_old = $rows['message_text'];  // storing the message from the database in the $message_old variable
            $userName_old = $rows['user_name'];    // storing the username of the sender from the database in the $userName_old variable
            if (!in_array($message_old, $message_holder)){
                array_push($message_holder, $message_old); 
                array_push($_SESSION['messages'], $message_old); 
                $_SESSION['messages_length']++;
                // displaying the user names and the messages
                $fp = fopen($_SESSION['current_chat_room'].".html", 'a');
                fwrite($fp, "<div class='msgln'><b>".$userName_old."</b>: ".stripslashes(htmlspecialchars($message_old))."<br></div>");
                fclose($fp);
            }
        }
    }
}
    if (file_exists($_SESSION['current_chat_room'] . ".html")) {
        echo file_get_contents($_SESSION['current_chat_room'].".html");
    }
?>