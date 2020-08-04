<?php
require "connection.php";
require "docmanipulation.php";

if(isset($_POST['vwstudents'])){viewStudents();}
if(isset($_POST['gradeproject'])){gradeProject();}
if(isset($_POST['fetchproject'])){fetchProjectDetails();}
if(isset($_POST['ltchangepass'])){changePassword();}
if(isset($_POST['fetchEach'])){fetchEach($_POST['projectId'], $_POST['student']);}

function viewStudents()
{
    global $db;
    $studentdetails = array();
    $i = 0;
    $id = $_SESSION['id'];
    $query = "SELECT * FROM student_tb WHERE lecturerid = '$id'";
    $result = mysqli_query($db , $query);
    if(!$result)
    {
        die("Error fetching students");
    }
    else
    {
        $count = mysqli_num_rows($result);
        while($i< $count)
        {
            $stdetails = mysqli_fetch_assoc($result);
            $matricno = $stdetails['matricno'];
            $name = $stdetails['name'];
            $dptname = $stdetails['departmentname'];
            $level = $stdetails['level'];
            $query1 = "SELECT * FROM project_tb WHERE matricno = '$matricno'";
            $result1 = mysqli_query($db , $query1);
            if(!$result1)
            {
                die("Error fetching students project details");
            }
            else
            {
                
                $ptdetails = mysqli_fetch_array($result1);
                $ptname = $ptdetails['name'];
                $ptid = $ptdetails['id'];
                $studentdetailsItem = array('matricno' => $matricno ,'name'=>$name,'departmentname'=> $dptname, 
                'level'=>$level,'projectname'=> $ptname,'projectid'=> $ptid);
                array_push($studentdetails, $studentdetailsItem); 
            }
            $i=$i +1;
        } 
    }
    echo "FetchSuccessful";
    $_SESSION['assignedStudents'] = $studentdetails;
}

function fetchEach($projectId, $student) {
    $_SESSION['projectid'] = $projectId;
    $_SESSION['selectedStudent'] = $student;
    fetchProjectDetails();
    echo "FetchSuccessful";
}

function fetchProjectDetails()
{
    global $db;
    $projectid = $_SESSION["projectid"];
    $query = "SELECT * FROM project_tb WHERE id = '$projectid'";
    $result = mysqli_query($db, $query);
    if(!$result)
    {
        die("Error while fetching project details. "); 
    }
    else
    {
        $count = mysqli_num_rows($result);
        if($count == 1)
        {
            $ptdetails = mysqli_fetch_assoc($result);
            $_SESSION["comment"] = $ptdetails['comment'];
            $_SESSION["grade"] = $ptdetails['grade'];
            $_SESSION["path"] = $ptdetails['path'];
            $_SESSION["projectname"] = $ptdetails['name'];
            viewDocument();
            echo "FetchSuccessful";
        }
    }
}
function gradeProject()
{
    global $db;
    $projectid = $_SESSION['projectid'];
    $newgrade = mysqli_real_escape_string($db, $_REQUEST['newgrade']);
    $query = "UPDATE project_tb SET grade = '$newgrade' WHERE id = '$projectid'";
    $result = mysqli_query($db, $query);
    if(!$result)
    {
        die("Error while updating grade details. "); 
    }
    else
    {
        $_SESSION['grade'] = $newgrade;
        echo "graded";
    }
}

function viewDocument()
{
    global $db;
    $ptid = $_SESSION['projectid'];
    $query = "SELECT * FROM project_tb WHERE id='$ptid'";
    $result = mysqli_query($db, $query);
    if(!$result)
    { 
        die("Error fetching project path."); 
    }
    else
    {
        $ptdetails = mysqli_fetch_assoc($result);
        $filePath = $ptdetails['path'];
        $docObj = new DocxConversion($filePath);
        $docText= $docObj->convertToText();
        $_SESSION['docContent'] = $docText;
    }
}

function changePassword()
{
    global $db;
    $newPassword = $_REQUEST['newpassword'];
    $id = $_SESSION['id'];
    $newPassword = md5($newPassword);
    $query = "UPDATE lecturer_tb SET password = '$newPassword' WHERE id = '$id'";
    $result = mysqli_query($db, $query);
    if(!$result)
    {
        die("Error while updating password. "); 
    }
    else
    {
        echo "changeSuccessful";
    }
}
?>