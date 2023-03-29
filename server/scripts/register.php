<?php

require $GLOBALS["sqlFunction"];

if (isset($_POST["register"])) {
    $info = json_decode($_POST["register"]);
    $name = $info->Name;
    $email = $info->Email;
    $password = $info->$Password;
    
}

?>