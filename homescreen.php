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

<?php session_start();
    include("connection.php");
     //establishing connection betweent register.php and connection.php
     //include("message.php")
    if(isset($_POST['start'])){
        //$new_msg = message();
        $userName = $_POST['user_name'];  // Storing the entered user name into a variable
        if ($userName!= ""){ //checking if the text box is not null
            $query = "INSERT INTO user (id,user_name)
                        VALUES('','".$userName."')"; //inserting the username and the id of the user into the database
            
            if (mysqli_query($con,$query)){
                $_SESSION['user_name'] = $new_msg->userName; // making the entered username by the user into a session variable
                echo "what is love baby dont hurt me";
                header("location: chat_area.php"); //redirect user to the chat page
                
                
            } else {
                print 'not logged in because of ' . $query;
            }
           
        } else { //if it is empty then, the program prompts the user to add in the username
            print 'Please enter your username' ;
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
