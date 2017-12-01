<?php
    include_once('lib/SessionManagerBase.php');
    class SessionManager extends SessionManagerBase{
        function userHandler(){
            if($_SESSION["tipo"]==1){
                include_once('usuarios/admin/context/index.php');
            } else{
                include_once('usuarios/invitado/context/index.php');
            }
        }
    }
?>
