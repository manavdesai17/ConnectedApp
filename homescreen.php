<!doctype html>
<html>

<head> 

<style>
*{
    margin: 0px;
    padding: 0px;
}
#main{
    border:1px solid black;
    width: 200px;
    margin: 50px auto;
}

</style>

</head>

<body>
<?php 
    //include($_SERVER['DOCUMENT_ROOT'] . '/connection.php'); // check database connection
    include("connection.php");
    session_start();
    if (isset($_SESSION['user_name'])) {
        header('Location: chat_area.php');
    }
    else {
        include("connection.php");
         //establishing connection betweent register.php and connection.php
         //include("message.php")
        if(isset($_POST['start'])) {
            require_once('message.php');
            require_once('user.php');
            $userName = $_POST['user_name'];  // Storing the entered user name into a variable
            if ($userName !== ""){ //checking if the text box is not null
                $check = "SELECT * FROM user WHERE user_name = '" . $userName . "'";
                if (mysqli_query($con, $check)->num_rows >= 1){
                    $user = new User($userName);
                    $new_msg = new Message($userName);
                    $_SESSION['user_name'] = $user->get_userName(); // making the entered username by the user into a session variable
                    header('Location: chat_rooms.php');
                    exit();
                }
                else {
                    $query = "INSERT INTO user (id, user_name)
                                VALUES(0,'".$userName."')"; //inserting the username and the id of the user into the database
                    
                    if (mysqli_query($con,$query)){
                        $user = new User($userName);
                        $new_msg = new Message($userName);
                        $_SESSION['user_name'] = $user->get_userName(); // making the entered username by the user into a session variable
                        header('Location: chat_rooms.php'); //redirect user to the chat page
                        exit();
                    } else {
                        print 'not logged in because of ' . $query;
                    }
                }
            } 
            else { //if it is empty then, the program prompts the user to add in the username
                print 'Please enter your username' ;
            }
        }
    }

?>

<div id = "main">
<h2 align = "center"> Enter Your Name! </h2>
<form method = "post">
    User Name: <br>
    <input type = "text" name = "user_name" placeholder="User Name">
    <br><br>
    <input type="submit" name = "start" value = "Start">
</form>
</div>
</body>



</html>
