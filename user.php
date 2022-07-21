<?php
class User{
    public $userName;
    public $user_messages = [];
    public $user_id;
    // add more user definitions

    function __construct($userName){
        $this->userName = $userName;
        $this->message_time = time(); //to retrieve when a message was sent
        
        $this->set_userid();

    }

    function get_userName(){
        $userName = $this->userName;
        return $userName;
    }

    function set_userid(){
        if ($this->user_id != NULL) {
            $this->user_id += 002010; // incrementing the user id to get more uniqure user ids (going to change it to a randomizer)
        } else {
            $this->user_id = 2000870000; //setting up the first user id (going to change it to user a randomizer)
        }
    }
} 
?>