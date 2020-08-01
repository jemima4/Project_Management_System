<?php 
//Contains student CRUD functions

require "connection.php";
require "docmanipulation.php";
if(isset($_POST['ctproject'])){createProject();}
if(isset($_POST['fetchproject'])){fetchProjectDetails();}
if(isset($_GET['delete'])){deleteProject();}
if(isset($_POST['addcomment'])){addComment();}
if(isset($_POST['changepassword'])){changePassword();}


function createProject()
{
    $projectid = $_SESSION["matricno"];
    $matricno = $_SESSION["matricno"];
    $ltid = $_SESSION["lecturerid"];
    $name = $_REQUEST['projectName'];
    $projectid = md5($projectid);
    $target_dir = "../projects/";
    $target_dir .= $projectid;
    $target_dir .= "/";
    global $db;
    $target_file = $target_dir . basename($_FILES["projectFile"]["name"]);
    $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    if(filecheck($target_dir) == 0) 
    {
    }
    else
    {
        $_SESSION['projectname'] = $name;
        $query = "INSERT INTO project_tb (id, matricno, name, path, comment, grade, lectid) VALUES ('$projectid' , '$matricno', 
        '$name','$target_file','','', '$ltid')";
        $result = mysqli_query($db, $query);
        if(!$result)
        {
            // die("Error while creating Project details. " .mysqli_error($db)); 
            die("Error while creating Project details. "); 
        }
        else
        {
            uploadFile($target_dir, $projectid ,$name);
        }
    }
}
function filecheck($target_dir)
{
    $target_file = $target_dir . basename($_FILES["projectFile"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["projectFile"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
    $uploadOk = 0;
    }

    // Allow certain file formats
    if($fileType != "doc" && $fileType != "docx" ) 
    {
        echo "Sorry,  DOC & DOCX files are allowed.";
        $uploadOk = 0;
    }
    return $uploadOk;
}
function uploadFile($target_dir, $projectid,$name)
{   
    $target_file = $target_dir . basename($_FILES["projectFile"]["name"]);     
    mkdir($target_dir);
    if (move_uploaded_file($_FILES["projectFile"]["tmp_name"], $target_file)) {
        // echo "The file ". basename( $_FILES["projectFile"]["name"]). " has been uploaded.";
        $_SESSION["projectid"] = $projectid;
        $_SESSION["projectname"] = $name;
        echo "ProjectSuccessful";
    } 
    else 
    {
        echo "Sorry, there was an error uploading your file.";
    }
}

function deleteFile($filepath)
{
    $dir = "../";
    $holder1 = explode("/",$filepath,-1);
    foreach($holder1 as $hold)
    {
        $dir .= $hold."/";
    }
    $filePath = $dir;
    //Experimental
    // if(is_writable($filepath))
    // {
    //     unlink(dirname(__FILE__) . $filepath);
    // }
    // else
    // {
    //     echo "File is not writable";
    // }
    if(is_dir($filePath))
    {
        $files = glob($filePath . '*', GLOB_MARK);
        foreach($files as $file)
        {
            unlink($file);
        }
        rmdir($filePath);
    }
    elseif(is_file($filePath))
    {
        unlink($filePath);
    }
    // if(!unlink($filePath)) {  
    //     echo ("cannot be deleted due to an error");  
    // }  
    // else {  
    //     echo ("$filePath has been deleted");  
    // }
}
function renameProject()
{
}
function savingEdits()
{
    
}
function deleteProject()
{
    global $db;
    fetchProjectDetails();
    $ptid = $_SESSION['projectid'];
    $query = "DELETE FROM project_tb WHERE id ='$ptid'";
    $result = mysqli_query($db, $query);
    if(!$result)
    {
        // die("Error while creating Project details. " .mysqli_error($db)); 
        die("Error while deleting Project details. "); 
    }
    else
    {
        unset($_SESSION["projectid"]);
        unset($_SESSION["comment"]);
        unset($_SESSION["grade"]);
        unset($_SESSION["path"]);
        deleteFile($_SESSION['path']);
        header("Location: ../dashboard.php");
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

// Not used
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

function changePassword()
{
    global $db;
    $newPassword = $_REQUEST['newpassword'];
    $matricno = $_SESSION['matricno'];
    $newPassword = md5($newPassword);
    $query = "UPDATE student_tb SET password = '$newPassword' WHERE matricno = '$matricno'";
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

