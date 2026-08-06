<?php
    session_start();
    session_destroy();

    if(isset($_GET['run']) && $_GET['run'] == 1){
            header("Location: index.php?run=1");
    } else{
        header("Location: index.php");
    }

    exit;
?>