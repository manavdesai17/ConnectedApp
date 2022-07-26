<?php
class ChatRoom{
    public $roomName;
    public $room_id;
    // add more user definitions

    function __construct($roomName){
        $this->roomName = $roomName;
    }

    function get_roomName(){
        $roomName = $this->roomName;
        return $roomName;
    }
    
    function set_roomName($newRoomName){
        $this->roomName = $newRoomName;
    }
} 
?>