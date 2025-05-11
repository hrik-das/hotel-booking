<?php
    require_once("./admin/include/essential.php");
    
    session_start();
    session_unset();
    session_destroy();
    redirect("index.php");
?>