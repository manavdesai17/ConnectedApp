<!DOCTYPE html>
<html lang="en">

<body>
<?php
session_start();
include("connection.php");
require_once('room.php');

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
    header("Location: homescreen.php");
    session_destroy();
}

$chat_rooms = array();
$queryDisplay = "SELECT * FROM test.chat_rooms";   // selecting everything from the database
$store = mysqli_query($con, $queryDisplay); //storing the query in the $store variable
while($rows = mysqli_fetch_assoc($store)){ // looping through each row of the table
    $chat_room_name = $rows['room_name']; 
    if (!in_array($chat_room_name, $chat_rooms)){
        array_push($chat_rooms, new ChatRoom($chat_room_name));
    }
}
?>

<form method="post">
    <?php 
    // Select a chat room
    foreach ($chat_rooms as $room) {
        echo "<button type='submit' name='room_name' value='" . $room->get_roomName() . "'>" . $room->get_roomName() .  "</button>";
    }
    ?>
</form>

<?php 
if (array_key_exists('room_name', $_POST)) {
    $_SESSION['current_chat_room'] = stripslashes(htmlspecialchars($_POST['room_name']));
    header('Location: chat_area.php');
}
?>

</body>
</html>

