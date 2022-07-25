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
        print 'Welcome to the chat ' . $_SESSION['user_name'] . ' !  ' . "\n";
        print '<a href = "homescreen.php"> Exit the Session </a>'; //for the user to exit the chat room
        
    } else {  //if the session is not running then the user is directed to the homescreen
        header("Location: homescreen.php");
    }
?>
<div id = "main">
    <div id = "msgArea">
        <?php 
            include("connection.php");
            $message_holder = array();
            $queryDisplay = "SELECT * FROM test.message";   // selecting everything from the database
            $store = mysqli_query($con,$queryDisplay); //storing the query in the $store variable
            // var_dump($store);
            // //while (true){
                
            //     //displaying all the old messages
                
                while($rows = mysqli_fetch_assoc($store)){ // looping through each row of the table
                    $message_old = $rows['message_text'];  // storing the message from the database in the $message_old variable
                    $userName_old = $rows['user_name'];    // storing the username of the sender from the database in the $userName_old variable
                    if (!in_array($message_old, $message_holder)){
                        array_push($message_holder,$message_old); 
                        //displaying the user names and the messages
                        print '<h4 style = "color: blue">' .$userName_old. '</h4>';  
                        print '<p>' .$message_old. '</p>';
                        print '<hr>'; // add a line after every message
                        //Maybe Fixed??? -- Problem with this above code? when the other end user sends a message, it is not displayed until screen is refreshed
                    }
                    

                }
                if (isset($_POST['submit'])){ //whenever the "Send" button is clicked
                    $message_text = $_POST['message_typed']; //storing the input into the $message_text variable
                    $query = "INSERT INTO message (id, user_name, message_text)
                            VALUES(0, '".$_SESSION['user_name']."', '".$message_text."')"; // Inserting the id, message, and the user name into the databsae
                
                    if (mysqli_query($con,$query)){
                        print '<h4 style = "color: green">' .$_SESSION['user_name']. '</h4>'; //new messages are green in color
                        print '<p>'.$message_text.'</p>';
                        print '<hr>'; // add a line after every message
                        $_POST = array();
                    }
                }
        //}
        ?>
        
    </div>
    
    <form method= "post">
    <input type = "text" name = "message_typed" style= "width: 300px; height: 50px;" id = "1" placeholder = "Your message goes here!" />
    <input type = "submit" name = "submit" style = "width: 80px; height: 50px; " value = "Send" />
    </form>
</div>
</body>
</html>