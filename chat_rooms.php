<!DOCTYPE html>
<html lang="en">

<body>
<?php
session_start();
include("connection.php");

if (isset($_SESSION['user_name'])){ //if the session is runnning
    echo '<h2>Welcome to the chat room selection ' . $_SESSION['user_name'] . '! </h2>
        <form method="post">
            <input type="submit" name="exitRooms" class="button" value="Exit Chat Room Selection" />
        </form>';
    if (array_key_exists('exitRooms', $_POST)) { exitRooms(); }
}
else {  //if the session is not running then the user is directed to the homescreen
    header("Location: homescreen.php");
}

function exitRooms() {
    $Decrementquery = "UPDATE test.chat_rooms SET room_amount = room_amount + 1 WHERE room_name = a
                        VALUE('".$_POST['room_name']."')";
    
    mysqli_query($con,$Decrementquery);
    
    header("Location: homescreen.php");
    
    session_destroy();
}

$chat_rooms = array();
$queryDisplay = "SELECT * FROM test.chat_rooms";   // selecting everything from the database
$store = mysqli_query($con, $queryDisplay); //storing the query in the $store variable
while($rows = mysqli_fetch_assoc($store)){ // looping through each row of the table
    $chat_room_name = $rows['room_name']; 
    if (!in_array($chat_room_name, $chat_rooms)){
        array_push($chat_rooms, $chat_room_name);
    }
}

?>

<form method="post" action="chat_area.php">
    <?php 
    // Select a chat room
    foreach ($chat_rooms as $room) {
        echo "<button type='submit' name='room_name' value='" . $room . "'>" . $room .  "</button>";
    }
    ?>
</form>

</body>
</html>

