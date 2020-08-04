<?php
require "connection.php";
if(isset($_POST['ltlogin'])){loginLecturer();}
if(isset($_POST['stlogin'])){loginStudent();}
if(isset($_POST['adlogin'])){loginAdmin();}
if(isset($_POST['logoutUser'])){logOut();}
//The clear session is the last function i don't know how you will call it 
//Sessions have been created in lecturer login
function loginStudent()
{
    global $db;
    $matricno = mysqli_real_escape_string($db,$_REQUEST['matricNo']);
    $password = mysqli_real_escape_string($db,$_REQUEST['stpassword']);
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
            $ltid = $stdetails['lecturerid'];
            $query = "SELECT * FROM lecturer_tb WHERE id = '$ltid'";
            $result = mysqli_query($db, $query);
            $count = mysqli_num_rows($result);
            if(!$result)
            {
                die("Error while fetching Supervisor's details"); 
            }
            else
            {
                $ltdetails = mysqli_fetch_assoc($result);
                $ownerid = $stdetails['matricno'];
                $query = "SELECT * FROM project_tb WHERE matricno = '$ownerid'";
                $result = mysqli_query($db, $query);
                $count = mysqli_num_rows($result);
                if(!$result)
                {
                    die("Error while fetching Project's details"); 
                }
                else
                {
                    $ptdetails = mysqli_fetch_assoc($result);
                    //If there's no project session will have null stored in it
                    $_SESSION["projectid"] = $ptdetails['id'];
                    $_SESSION["projectname"] = $ptdetails['name'];
                    $_SESSION["lecturername"] = $ltdetails['name'];
                    $_SESSION["ltdepartmentname"] = $ltdetails['departmentname']; 
                    $_SESSION["matricno"] = $stdetails['matricno'];
                    $_SESSION["name"] = $stdetails['name'];
                    $_SESSION["level"] = $stdetails['level'];
                    $_SESSION["departmentname"] = $stdetails['departmentname'];
                    $_SESSION["lecturerid"] = $stdetails['lecturerid'];
                    $_SESSION["currentUser"] = "student";
                    echo "loginSuccessful";
                }
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
    global $db;
    $email = mysqli_real_escape_string($db,$_REQUEST['ltemail']); 
    $password = mysqli_real_escape_string($db,$_REQUEST['ltpassword']);
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
            die("Details entered are incorrect"); 
        }
        else
        {
            $count = mysqli_num_rows($result);
            if($count == 1)
            {
                $ltdetails = mysqli_fetch_assoc($result);
                $ltid = $ltdetails['id'];
                $query = "SELECT * FROM student_tb WHERE lecturerid = '$ltid'";
                $result = mysqli_query($db, $query);
                if(!$result)
                {
                    die("Error fetching student details"); 
                }
                else
                {
                    $count = mysqli_num_rows($result);
                    $_SESSION["id"] = $ltdetails['id'];
                    $_SESSION["numofstudents"] = $count;
                    $_SESSION["name"] = $ltdetails['name'];
                    $_SESSION["departmentname"] = $ltdetails['departmentname']; 
                    $_SESSION["email"] = $ltdetails['email'];
                    $_SESSION["currentUser"] = "lecturer";
                    echo "loginSuccessful";
                }
            }
            else
            {
                echo "Details entered are incorrect"; 
            }
        }
    }    
}

function loginAdmin()
{
    global $db;
    $email = mysqli_real_escape_string($db, $_REQUEST['ademail']); $password = mysqli_real_escape_string($db, $_REQUEST['adpassword']);
    $query = "SELECT * FROM admin_tb ";
    $querylt ="SELECT * FROM lecturer_tb";
    $queryst ="SELECT * FROM student_tb";
    $resultlt = mysqli_query($db,$querylt);
    $resultst = mysqli_query($db,$queryst);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        die("Invalid Email entered!");
    }
    else
    {
        $password = md5($password);
        $query .= " WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($db, $query);
        if(!$result)
        {
            die("An error occurred while checking for user.");
        }
        else
        {
            $count = mysqli_num_rows($result);
            if($count == 1)
            {
                $adminNameList = explode("@", $email);
                $_SESSION["name"] = reset($adminNameList);
                $_SESSION["email"] = $email;
                $_SESSION["currentUser"] = "admin";
                if(!$resultlt and !$resultst)
                {
                    die("An error occured when fetching registered users");
                }
                else{
                    $_SESSION["numoflecturers"] = mysqli_num_rows($resultlt);
                    $_SESSION["numofstudents"] = mysqli_num_rows($resultst);
                    echo "loginSuccessful";
                }
            }
            else
            {
                die("Invalid credentials entered!"); 
            }
        }
    }    
}

function logOut()
{
    echo "logoutSuccessful";
    session_unset();
    session_destroy();
}
?>