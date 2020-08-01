<?php
require "connection.php";
require "docmanipulation.php";
if(isset($_POST['vwstudents'])){viewStudents();}
if(isset($_POST['addcomment'])){addComment();}
if(isset($_POST['gradeproject'])){gradeProject();}
if(isset($_POST['fetchproject'])){fetchProjectDetails();}
if(isset($_POST['addcomment'])){addComment();}
if(isset($_POST['changepassword'])){changePassword();}

//Note: Project id sessions have to be created when using the add and fetch comments , add grade 
//view document and fetch project details
//This should be done when a particular student is selected
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
                die("Erro fetching studdents project details");
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
    // echo $studentdetails;
    $_SESSION['assignedStudents'] = $studentdetails;
}

function addComment()
{
    $comment = $_SESSION["comment"];
    $newComment = $_REQUEST['newComment'];
    $id = $_SESSION['projectid'];
    if($_SESSION["currentUser"] == "student"){$type = "st";}
    else{$type = "lt";}

    // Checking if comment is empty to prevent first empty array field that occurs on exploding
    empty($comment) ?  $comment.= $type.",".$newComment : $comment .= ";".$type.",".$newComment;

    global $db;
    $projectid = $_SESSION["projectid"];
    $query = "UPDATE project_tb SET comment = '$comment' WHERE id = '$projectid'";
    $result = mysqli_query($db, $query);
    if(!$result)
    {
        die("Error while adding comment details. "); 
    }
    else
    {
        // updating session with new concatenated comment string
        $_SESSION['comment'] = $comment;
        echo "addCommentSuccesful";
    }
}

function fetchComments()
{
    global $db;
    $projectid = $_SESSION['projectid'];
    $query = "SELECT * FROM project_tb WHERE id = '$projectid'";
    $result = mysqli_query($db , $query);
    if(!$result)
    {
        die("Error fetching comments");
    }
    else
    {
        $ptdetails = mysqli_fetch_assoc($result);
        $_SESSION['comment'] = $ptdetails['comment'];
        // Or i return an array of the comments this can be put in the main file depending on you
        $holder1 = explode(";",$_SESSION['comment']);
        foreach($holder1 as $hold)
        {
            $holder2 = explode(";",$hold);
            if($holder2[0] == 'st')
            {
                //student comment
                echo $holder2[1];
            }
            else
            {
                //lecturer comment
                //i dont know how youd use it so i used echo for now
                echo $holder2[1];
            }
        }
    }
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
            // Added to read document while fetching project details.
            viewDocument();
            echo "FetchSuccessful";
        }
    }
}
function gradeProject()
{
    global $db;
    $projectid = $_SESSION['projectid'];
    $newgrade = $_REQUEST['newgrade'];
    $query = "UPDATE project_tb SET grade = '$newgrade' WHERE id = '$projectid'";
    $result = mysqli_query($db, $query);
    if(!$result)
    {
        die("Error while updating grade details. "); 
    }
    else
    {
        // updating session with new concatenated comment string
        $_SESSION['grade'] = $newgrade;
        echo "GradeUpdated";
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
        echo "passwordUpdated";
    }
}
?>