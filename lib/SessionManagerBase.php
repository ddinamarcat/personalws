<?php

    class SessionManagerBase{

        public $userKey = "user";
        public $typeKey = "tipo";
        public $guestType = 0;
        public $guestName = "Invitado";

        function __construct(){
            session_start();
            if(!isset($_SESSION[$this->userKey])){
                $_SESSION[$this->userKey] = $this->guestName;
                $_SESSION[$this->typeKey] = $this->guestType;
            }
            if(isset($_SESSION[$this->userKey])){
                $this->userHandler();
            }
        }
        function userHandler(){
        }
    }
?>
