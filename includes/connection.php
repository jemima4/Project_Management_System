<?php
    session_start();
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "cupms_db";
    
    $db = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

    if(mysqli_connect_errno()){
        die("Database connection failed: ". 
        mysqli_connect_error() . 
        "(" . mysqli_connect_errno() . ")"
        );
    }
    if (!$_SESSION['currentUser'] = "student" or !$_SESSION['currentUser'] = "lecturer" or !$_SESSION['currentUser'] = "admin")
    {
        header("Location: ../index.php");
    }
?>