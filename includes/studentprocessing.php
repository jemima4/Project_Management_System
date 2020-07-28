<?php 
//Contains student CRUD functions
require "connection.php";
if(isset($_POST['ctproject'])){createProject();}
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
    $query = "INSERT INTO project_tb (id, matricno, name, path, comment, grade, lectid) VALUES ('$projectid' , '$matricno', 
    '$name','$target_dir','','--', '$ltid')";
    $result = mysqli_query($db, $query);
    if(!$result)
    {
        die("Error while creating Project details. " .mysqli_error($db)); 
    }
    else
    {
        uploadFile($target_dir);
    }
}

function uploadFile($target_dir)
{
    mkdir($target_dir);
    echo $_REQUEST['projectName'];
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

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } 
    else 
    {
    if (move_uploaded_file($_FILES["projectFile"]["tmp_name"], $target_file)) {
        // echo "The file ". basename( $_FILES["projectFile"]["name"]). " has been uploaded.";
        echo "ProjectSuccessful";
    } 
    else 
    {
        echo "Sorry, there was an error uploading your file.";
    }
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
?>

