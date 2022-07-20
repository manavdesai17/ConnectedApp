<?php

// Creating each message as an Object, following an OOP approach
// Might completely remove
require_once("user.php")
class Message {
    public $userName;  // Need to store the Messages according to each user connected to the server. 
    public $message_time;
    public $message_id;
    public $message_text;

    function __construct($userName){
        $this->userName = $userName;
        $this->message_time = time(); //to retrieve when a message was sent
        set_messageid();

    }

    function get_userName(){
        $userName = $this->userName;
        return $userName;
    }

    function set_messageid(){
        if $this->message_id != NULL{
            $this->message_id += 002010; // incrementing the user id to get more uniqure message ids (going to change it to a randomizer)
        } else {
            $this->message_id = 2000870000; //setting up the first messaage id (going to change it to message a randomizer)
        }
    }

    function set_message_text($message_text){
        $this->message_text = $message_text
    }
    function get_message_text(){
        return $this->message_text;
    }
}

?>