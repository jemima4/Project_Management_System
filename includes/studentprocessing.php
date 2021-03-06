<?php 
require "connection.php";
require "docmanipulation.php";

if(isset($_POST['ctproject'])){createProject();}
if(isset($_POST['fetchproject'])){fetchProjectDetails();}
if(isset($_GET['delete'])){deleteProject();}
if(isset($_POST['addcomment'])){addComment();}
if(isset($_POST['stchangepass'])){changePassword();}
if (isset($_POST['reupproject'])){reUploadProject();};


function createProject()
{
    global $db;
    $projectid = $_SESSION["matricno"];
    $matricno = $_SESSION["matricno"];
    $ltid = $_SESSION["lecturerid"];
    $name = mysqli_real_escape_string($db, $_REQUEST['projectName']);
    $projectid = md5($projectid);
    $target_dir = "../projects/";
    $target_dir .= $projectid;
    $target_dir .= "/";
    $target_file = $target_dir . basename($_FILES["projectFile"]["name"]);
    if(filecheck($target_dir) == 0) 
    {
    }
    else
    {
        $query = "INSERT INTO project_tb (id, matricno, name, path, comment, grade, lectid) VALUES ('$projectid' , '$matricno','$name','$target_file','','', '$ltid')";
        $result = mysqli_query($db, $query);
        if(!$result)
        {
            die("Error while creating Project details. ".mysqli_error($db)); 
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
    gc_collect_cycles();
    clearstatcache();
    $dir = "";
    $holder1 = explode("/",$filepath,-1);
    foreach($holder1 as $hold)
    {
        $dir .= $hold."/";
    }
    $filePath = $dir;
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
}

function deleteProject()
{
    global $db;
    // fetchProjectDetails();
    $ptid = $_SESSION['projectid'];
    $query = "DELETE FROM project_tb WHERE id ='$ptid'";
    $result = mysqli_query($db, $query);
    if(!$result)
    { 
        die("Error while deleting Project details. "); 
    }
    else
    {
        deleteFile($_SESSION['path']);
        unset($_SESSION["projectid"]);
        unset($_SESSION["projectname"]);
        unset($_SESSION["comment"]);
        unset($_SESSION["grade"]);
        unset($_SESSION["path"]);
        if (!isset($_POST['reupproject'])) {
        header("Location: ../dashboard.php");
        }
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
            $_SESSION["projectname"] = $ptdetails['name'];
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
    global $db;
    $comment = $_SESSION["comment"];
    $newComment = mysqli_real_escape_string($db, $_REQUEST['newComment']);
    $id = $_SESSION['projectid'];
    if($_SESSION["currentUser"] == "student"){$type = "st";}
    else{$type = "lt";}

    // Checking if comment is empty to prevent first empty array field that occurs on exploding
    empty($comment) ?  $comment.= $type.",".$newComment : $comment .= ";".$type.",".$newComment;

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
        echo "changeSuccessful";
    }
}

function reUploadProject() {
    deleteProject();
    createProject();
}
?>

