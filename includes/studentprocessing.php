<?php 
//Contains student CRUD functions

require "connection.php";
if(isset($_POST['ctproject'])){createProject();}
if(isset($_POST['addcomment'])){addComment();}
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
        '$name','$target_dir','','--', '$ltid')";
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

function deleteFile($filename)
{
    //Experimental
    $id = $_SESSION["matricno"];
    $id = md5($id);
    $filetestpath = "/../projects/";
    $filetestpath .= $id ;
    $filetestpath .= "/" ;
    $filetestpath .= $filename;
    $filepath = realpath($filename);
    if(is_writable($filename))
    {
        unlink(dirname(__FILE__) . $filetestpath);
    }
    else
    {
        echo "File is not writable";
    }
}
function renameProject()
{
}
function deleteProject()
{
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
        }
    }
}

function addComment()
{
    $comment = $_SESSION["comment"];
    $name = $_REQUEST['newComment'];
    $id = $_SESSION['projectid'];
    if($_SESSION["currentUser"] == "student")
    {
        $type = "st";
    }
    else{$type = "lt";}
    $comment .= ";".$type.",";
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
        echo "addcommentsuccesful";
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
?>

