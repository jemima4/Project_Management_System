<?php 
//Contains student CRUD functions

require "connection.php";
if(isset($_POST['ctproject'])){createProject();}
if(isset($_POST['fetchproject'])){fetchProjectDetails();}
if(isset($_GET['delete'])){deleteProject();}
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
    //Experimental
    if(is_writable($filepath))
    {
        unlink(dirname(__FILE__) . $filepath);
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
    if($_SESSION["currentUser"] == "student")
    {
        $type = "st";
    }
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

class DocxConversion{
    private $filename;

    public function __construct($filePath) {
        $this->filename = $filePath;
    }

    private function read_doc() {
        $fileHandle = fopen($this->filename, "r");
        $line = @fread($fileHandle, filesize($this->filename));   
        $lines = explode(chr(0x0D),$line);
        $outtext = "";
        foreach($lines as $thisline)
          {
            $pos = strpos($thisline, chr(0x00));
            if (($pos !== FALSE)||(strlen($thisline)==0))
              {
              } else {
                $outtext .= $thisline." ";
              }
          }
         $outtext = preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/","",$outtext);
        return $outtext;
    }

    private function read_docx(){

        $striped_content = '';
        $content = '';

        $zip = zip_open($this->filename);

        if (!$zip || is_numeric($zip)) return false;

        while ($zip_entry = zip_read($zip)) {

            if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

            if (zip_entry_name($zip_entry) != "word/document.xml") continue;

            $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

            zip_entry_close($zip_entry);
        }// end while

        zip_close($zip);

        // $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
        // $content = str_replace('</w:r></w:p>', "\r\n", $content);
        // $striped_content = strip_tags($content);

        $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
        $content = str_replace('</w:r></w:p>', "\r\n", $content);
        $content = preg_replace('/<w:p w[0-9-Za-z]+:[a-zA-Z0-9]+="[a-zA-z"0-9 :="]+">/',"\n\r",$content);
        $content = preg_replace('/<w:tr>/',"\n\r",$content);
        $content = preg_replace('/<w:tab\/>/',"\t",$content);
        $content = preg_replace('/<\/w:p>/',"\n\r",$content);
        $striped_content = strip_tags($content);

        return $striped_content;
    }


    public function convertToText() {

        if(isset($this->filename) && !file_exists($this->filename)) {
            return "File Not exists";
        }

        $fileArray = pathinfo($this->filename);
        $file_ext  = $fileArray['extension'];
        if($file_ext == "doc" || $file_ext == "docx" || $file_ext == "xlsx" || $file_ext == "pptx")
        {
            if($file_ext == "doc") {
                return $this->read_doc();
            } elseif($file_ext == "docx") {
                return $this->read_docx();
            } elseif($file_ext == "xlsx") {
                return $this->xlsx_to_text();
            }elseif($file_ext == "pptx") {
                return $this->pptx_to_text();
            }
        } else {
            return "Invalid File Type";
        }
    }

}
?>

