<?php
    require_once("./include/essential.php");
    session_start();
    session_unset();
    session_destroy();
    redirect("index.php");
?>