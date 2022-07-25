<?php
session_start();
// Make sure there is an active session by checking name
$type = $_POST['type'];

if ($type === 'send') { send(); }
elseif ($type === 'retrieve'){ retrieve(); }

function send() {
    include("connection.php");
    if(isset($_SESSION['user_name'])){
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
    include("connection.php");
    $message_holder = array();
    $queryDisplay = "SELECT * FROM test.message";   // selecting everything from the database
    $store = mysqli_query($con, $queryDisplay); //storing the query in the $store variable
    // displaying all the old messages
    while($rows = mysqli_fetch_assoc($store)){ // looping through each row of the table
        $message_old = $rows['message_text'];  // storing the message from the database in the $message_old variable
        $userName_old = $rows['user_name'];    // storing the username of the sender from the database in the $userName_old variable
        if (!in_array($message_old, $message_holder)){
            array_push($message_holder, $message_old); 
            //displaying the user names and the messages
            echo '<h4 style = "color: blue">' .$userName_old. '</h4>';  
            echo '<p>' .$message_old. '</p>';
            echo '<hr>'; // add a line after every message
            //Maybe Fixed??? -- Problem with this above code? when the other end user sends a message, it is not displayed until screen is refreshed
        }
    }
}

?>