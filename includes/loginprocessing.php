<?php
require "connection.php";
session_start();
if(isset($_POST['ltlogin'])){loginLecturer();}
if(isset($_POST['stlogin'])){loginStudent();}
if(isset($_POST['adlogin'])){loginAdmin();}

//Student login is the only function being worked on
function loginStudent()
{
    $matricno = $_REQUEST['matricNo']; $password = $_REQUEST['stpassword'];
    global $db;
    $query = "SELECT * FROM student_tb ";
    $password = md5($password);
    $query .= " WHERE matricno = '$matricno' AND password = '$password'";
    $result = mysqli_query($db, $query);
    if(!$result)
    {
        die("Invalid credentials entered!"); 
    }
    else
    {
        $count = mysqli_num_rows($result);
        if($count == 1)
        {
            $stdetails = mysqli_fetch_assoc($result);
            $holder = $row['matricno'];
            $ltid = $row['lecturerid'];
            $query = "SELECT * FROM lecturer_tb WHERE id = '$ltid'";
            $result = mysqli_query($db, $query);
            if(!$result)
            {
                die("Error while fetching Supervisor's details"); 
            }
            else
            {
                $ltdetails = mysqli_fetch_assoc($result);
                $_SESSION["lecturername"] = $ltdetails['name'];
                $_SESSION["ltdepartmentname"] = $ltdetails['departmentname']; 
                $_SESSION["matricno"] = $stdetails['matricno'];
                $_SESSION["name"] = $stdetails['name'];
                $_SESSION["level"] = $stdetails['level'];
                $_SESSION["departmentname"] = $stdetails['departmentname'];
                $_SESSION["lecturerid"] = $stdetails['lecturerid'];
                header("Location: ../dashboard.php");
            }
        }
        else
        {
            die("Invalid credentials entered!"); 
        }
        mysqli_free_result($result);
    }
    
}

function loginLecturer()
{
    $email = $_REQUEST['ltemail']; $password = $_REQUEST['ltpassword'];
    global $db;
    $query = "SELECT * FROM lecturer_tb ";
    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        echo "<script> window.alert('Email is not vaild')</script>";
    }
    else
    {
        $password = md5($password);
        $query .= " WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($db, $query);
        if(!$result)
        {
            die("Database query failed"); 
            echo "<script> window.alert('Details entered are incorrect')</script>"; 
        }
        else
        {
            $count = mysqli_num_rows($result);
            if($count == 1)
            {
                echo "<script> window.alert('Welcome User')</script>";
            }
            else
            {
                echo "<script> window.alert('Details entered are incorrect')</script>"; 
            }
        }
    }    
}


function loginAdmin()
{
    $email = $_REQUEST['ademail']; $password = $_REQUEST['adpassword'];
    global $db;
    $query = "SELECT * FROM admin_tb ";
    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        echo "<script> window.alert('Email is not vaild')</script>";
    }
    else
    {
        $password = md5($password);
        $query .= " WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($db, $query);
        if(!$result)
        {
            die("Database query failed");
            echo "<script> window.alert('Details entered are incorrect')</script>"; 
        }
        else
        {
            $count = mysqli_num_rows($result);
            if($count == 1)
            {
                echo "<script> window.alert('Welcome User')</script>";
            }
            else
            {
                echo "<script> window.alert('Details entered are incorrect')</script>"; 
            }
        }
    }    
}
?>