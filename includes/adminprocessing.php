<?php 
require "connection.php";
if(isset($_POST['ctstudent'])){createStudent();}
if(isset($_POST['ctlecturer'])){createLecturer();}
if(isset($_POST['etstudent'])){editStudent();}
if(isset($_POST['etlecturer'])){editLecturer();}
// Viewing student and lecturers
if(isset($_POST['viewstudents'])){viewStudents();}
if(isset($_POST['viewlecturers'])){viewLecturers();}
// Deleting students and lecturers
if(isset($_GET['delstudent'])){deleteStudent();}
if(isset($_GET['dellecturer'])){deleteLecturer();}

 //will have admin crud processes for students and lecturers
function createStudent()
{
    global $db;
    $matricno = mysqli_real_escape_string($db,$_REQUEST['matricno']);
    $name = mysqli_real_escape_string($db,$_REQUEST['name']);
    $dptname = mysqli_real_escape_string($db,$_REQUEST['departmentname']);
    $level = mysqli_real_escape_string($db,$_REQUEST['level']);
    $password = mysqli_real_escape_string($db,$_REQUEST['password']);
    $ltid = mysqli_real_escape_string($db,$_REQUEST['lecturerid']);
    $password = md5($password);
    $query = "INSERT INTO student_tb (matricno, name, departmentname, level, password, lecturerid) VALUES ('$matricno' , '$name', 
    '$dptname','$level','$password', '$ltid')";
    $queryltid = "SELECT * FROM lecturer_tb WHERE id = '$ltid'";
    $querydptname = "SELECT * FROM department_tb WHERE name = '$dptname'";
    $result1 = mysqli_query($db, $queryltid);
    $result2 = mysqli_query($db, $querydptname);
    if(!$result1)
    {
        // die("Error while creating Project details. " .mysqli_error($db)); 
        die("Error confirming lecturer id"); 
    }
    else
    {
        //check if lecturer exists
        $count1 = mysqli_num_rows($result1);
        $count2 = mysqli_num_rows($result2);
        if($count1 > 0)
        {
            //check if department exists
            if($count2 > 0)
            {
                $result = mysqli_query($db, $query);
                if(!$result)
                {
                    die("Error inserting to student table".mysqli_error($db));
                }
                else{
                    viewStudents();
                    echo "accountCreated";
                }
            }
            else{echo "Department doesn't exist";}
        }
        else{echo "Lecturer Id doesnt exist";}
    }
}

function editStudent()
{
    global $db;
    $matricno = mysqli_real_escape_string($db,$_REQUEST['matricno']);
    $name = mysqli_real_escape_string($db,$_REQUEST['name']);
    $dptname = mysqli_real_escape_string($db,$_REQUEST['departmentname']);
    $level = mysqli_real_escape_string($db,$_REQUEST['level']);
    $ltid = mysqli_real_escape_string($db,$_REQUEST['lecturerid']);
    $query = "UPDATE student_tb SET matricno = '$matricno', name = '$name', departmentname = '$dptname', level = '$level',
    lecturerid = '$ltid' WHERE matricno = '$matricno'";
    $queryltid = "SELECT * FROM lecturer_tb WHERE id = '$ltid'";
    $querydptname = "SELECT * FROM department_tb WHERE name = '$dptname'";
    $result1 = mysqli_query($db, $queryltid);
    $result2 = mysqli_query($db, $querydptname);
    if(!$result1)
    {
        // die("Error while-------. " .mysqli_error($db)); 
        die("Error confirming lecturer id"); 
    }
    else
    {
        //check if lecturer exists
        $count1 = mysqli_num_rows($result1);
        $count2 = mysqli_num_rows($result2);
        if($count1 > 0)
        {
            //check if department exists
            if($count2 > 0)
            {
                $result = mysqli_query($db, $query);
                if(!$result)
                {
                    die("Error inserting to student table or Matric No exists");
                }
                else{
                    viewStudents();
                    echo "accountUpdated";
                }
            }
            else{echo "Department doesn't exist";}
        }
        else{echo "Lecturer Id doesnt exist";}
    }   
}
function viewStudents()
{
    global $db;
    $studentdetails = array();
    $i = 0;
    $query = "SELECT * FROM student_tb";
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
            $ltid = $stdetails['lecturerid'];
            $studentdetailsItem = array('matricno' => $matricno ,'name'=>$name,'departmentname'=> $dptname,'level'=>$level ,'lecturerid'=> $ltid);
            array_push($studentdetails, $studentdetailsItem); 
            $i=$i +1;
        } 
    }
    echo "FetchSuccessful";
    $_SESSION['adminView'] = "Students";
    $_SESSION['registeredUsers'] = $studentdetails;
}

function createLecturer()
{
    global $db;
    $id = mysqli_real_escape_string($db,$_REQUEST['id']);
    $name = mysqli_real_escape_string($db,$_REQUEST['name']);
    $departmentname = mysqli_real_escape_string($db,$_REQUEST['departmentname']);
    $password = md5($_REQUEST['$password']);
    $email = $_REQUEST['email'];
    $query = "INSERT INTO lecturer_tb (id, name, email, password, departmentname) VALUES ('$id' , '$name', 
    '$email','$password','$departmentname')";
    $querydptname = "SELECT * FROM department_tb WHERE name = '$departmentname'";
    $result1 = mysqli_query($db, $querydptname);
    if(!$result1)
    {
        // die("Error while-------. " .mysqli_error($db)); 
        die("Error confirming department"); 
    }
    else
    {
        //check if department exists
        $count1 = mysqli_num_rows($result1);
        if($count1 > 0)
        {
            $result = mysqli_query($db, $query);
            if(!$result)
            {
                die("Error updating lecturer information".mysqli_error($db));
            }
            else{
                viewLecturers();
                echo "accountCreated";
            }
        }
        else{echo "Department doesn't exist";}
        
    }
}
function viewLecturers()
{
    global $db;
    $lecturerdetails = array();
    $i = 0;
    $query = "SELECT * FROM lecturer_tb";
    $result = mysqli_query($db , $query);
    if(!$result)
    {
        die("Error fetching lecturers");
    }
    else
    {
        $count = mysqli_num_rows($result);
        while($i< $count)
        {
            $ltdetails = mysqli_fetch_assoc($result);
            $id = $ltdetails['id'];
            $name = $ltdetails['name'];
            $dptname = $ltdetails['departmentname'];
            $email = $ltdetails['email'];
            $lecturerdetail = array('id' => $id ,'name'=>$name,'departmentname'=> $dptname,'email'=>$email);
            array_push($lecturerdetails, $lecturerdetail); 
            $i=$i +1;
        } 
    }
    echo "FetchSuccessful";
    $_SESSION['adminView'] = "Lecturers";
    $_SESSION['registeredUsers'] = $lecturerdetails;
}
function viewLecturersMini()
{
    global $db;
    $lecturerdetails = array();
    $i = 0;
    $query = "SELECT * FROM lecturer_tb";
    $result = mysqli_query($db , $query);
    if(!$result)
    {
        die("Error fetching lecturers");
    }
    else
    {
        $count = mysqli_num_rows($result);
        while($i< $count)
        {
            $ltdetails = mysqli_fetch_assoc($result);
            $id = $ltdetails['id'];
            $name = $ltdetails['name'];
            $lecturerdetailsItem = array('id' => $id ,'name'=>$name);
            array_push($lecturerdetails, $lecturerdetailsItem); 
            $i=$i +1;
        } 
    }
    echo "FetchSuccessful";
    $_SESSION['availableLecturers'] = $lecturerdetails;   
}
function editLecturer()
{
    global $db;
    $id = mysqli_real_escape_string($db, $_REQUEST['id']);
    $name = mysqli_real_escape_string($db,$_REQUEST['name']);
    $dptname = mysqli_real_escape_string($db,$_REQUEST['departmentname']);
    $email = mysqli_real_escape_string($db,$_REQUEST['email']);
    $query = "UPDATE lecturer_tb SET id = '$id', name = '$name', departmentname = '$dptname',
    email = '$email' WHERE id = '$id'";
    $querydptname = "SELECT * FROM department_tb WHERE name = '$dptname'";
    $result1 = mysqli_query($db, $querydptname);
    if(!$result1)
    {
        // die("Error while-------. " .mysqli_error($db)); 
        die("Error confirming department"); 
    }
    else
    {
        //check if department exists
        $count1 = mysqli_num_rows($result1);
        if($count1 > 0)
        {
            $result = mysqli_query($db, $query);
            if(!$result)
            {
                die("Error updating lecturer information");
            }
            else{
                viewLecturers();
                echo "accountUpdated";
            }
        }
        else{echo "Department doesn't exist";}
        
    }   
}

function viewDepartments()
{
    global $db;
    $departmentdetails = array();
    $i = 0;
    $query = "SELECT * FROM department_tb";
    $result = mysqli_query($db , $query);
    if(!$result)
    {
        die("Error fetching departments");
    }
    else
    {
        $count = mysqli_num_rows($result);
        while($i< $count)
        {
            $dptdetails = mysqli_fetch_assoc($result);
            $name = $dptdetails['name'];
            $departmentdetailsItem = array('name'=>$name);
            array_push($departmentdetails, $departmentdetailsItem); 
            $i=$i +1;
        } 
    }
    echo "FetchSuccessful";
    $_SESSION['availableDepartments'] = $departmentdetails;      
}

function deleteStudent()
{
    global $db;
    $matricno = $_REQUEST["matricno"];
    $query = "DELETE FROM student_tb WHERE matricno ='$matricno'";
    $result = mysqli_query($db , $query);
    if(!$result)
    {
        echo "Couldn't delete student";
    }
    else{
        deleteProject($matricno);
        viewStudents();
        header("Location: ../adminManage.php");
    }
}
function deleteLecturer()
{
    global $db;
    $id = $_REQUEST["id"];
    $query = "DELETE FROM lecturer_tb WHERE id ='$id'";
    $result = mysqli_query($db , $query);
    if(!$result)
    {
        echo "Couldn't delete lecturer";
    }
    else{
        viewLecturers();
        header("Location: ../adminManage.php");
    }
}

function deleteProject($matricno)
{
    global $db;
    // fetchProjectDetails();
    $queryfile = "SELECT * FROM project_tb WHERE matricno ='$matricno'";
    $query = "DELETE FROM project_tb WHERE matricno ='$matricno'";
    $resultfile = mysqli_query($db ,$queryfile);
    if(!$resultfile)
    {
        die("Error while fetching Project path. "); 
    }
    else
    {
        $ptdetails = mysqli_fetch_assoc($resultfile);
        $path = $ptdetails['path'];
        deleteFile($path);
        $result = mysqli_query($db, $query);
        if(!$result)
        {
            die("Error while deleting Project");
        }
        else{
            //I dont know what to unset or remove
        }
    }
}
function deleteFile($filepath)
{
    $dir = "";
    $holder1 = explode("/",$filepath,-1);
    foreach($holder1 as $hold)
    {
        $dir .= $hold."/";
    }
    $filePath = $dir;
    if(is_dir($filePath))
    {
        echo "hello";
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
?>