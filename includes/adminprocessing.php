<?php 
require "connection.php";
if(isset($_POST['ctstudent'])){createStudent();}
if(isset($_POST['ctlecturer'])){createLecturer();}
if(isset($_POST['etlecturer'])){editStudent();}
if(isset($_POST['etlecturer'])){editLecturer();}
// Viewing student and lecturers
if(isset($_POST['viewstudents'])){viewStudents();}
if(isset($_POST['viewlecturers'])){viewLecturers();}


 //will have admin crud processes for students and lecturers
function createStudent()
{
    global $db;
    $matricno = $_REQUEST['matricno'];
    $name = $_REQUEST['name'];
    $dptname = $_REQUEST['departmentname'];
    $level = $_REQUEST['level'];
    $password = $_REQUEST['password'];
    $ltid = $_REQUEST['lecturerid'];
    $query = "INSERT INTO student_tb (matricno, name, departmentname, level, password, lectuerid) VALUES ('$matricno' , '$name', 
    '$dptname','$level','$password', '$ltid')";
    $queryltid = "SELECT * FROM lecturer_tb WHERE id = '$ltid'";
    $querydptname = "SELECT * FROM department_tb WHERE name = '$dptname'";
    $result1 = mysqli_query($db, $queryltid);
    $result2 = mysqli_query($db, $querydptname);
    if(!$result)
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
                    die("Error inserting to student table");
                }
                else{
                    echo "SuccessCreatingStudent";
                }
            }
            else{echo "Department doesn't exist";}
        }
        else{echo "Lecturer Id doesnt exist";}
    }
    echo "accountCreated";
}

function editStudent()
{
    global $db;
    $matricno = $_REQUEST['matricno'];
    $name = $_REQUEST['name'];
    $dptname = $_REQUEST['dptname'];
    $level = $_REQUEST['level'];
    $ltid = $_REQUEST['lecturerid'];
    $query = "UPDATE student_tb SET matricno = '$matricno', name = '$name', departmentname = '$dptname',
    lecturerid = '$ltid' WHERE matricno = '$matricno'";
    $queryltid = "SELECT * FROM lecturer_tb WHERE id = '$ltid'";
    $querydptname = "SELECT * FROM department_tb WHERE name = '$dptname'";
    $result1 = mysqli_query($db, $queryltid);
    $result2 = mysqli_query($db, $querydptname);
    if(!$result)
    {
        // die("Error while-------. " .mysqli_error($db)); 
        die("Error confirming lecturer id"); 
    }
    else
    {
        //check if lecturer exists
        $count1 = mysqli_num_rows($result1);
        $count2 = mysqli_num_rows($result2);
        if($count > 0)
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
                    echo "SuccessUpdatingStudent";
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
            $studentdetailsItem = array('matricno' => $matricno ,'name'=>$name,'departmentname'=> $dptname,'level'=>$level);
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

function editLecturer()
{
    $id = $_REQUEST['id'];
    $name = $_REQUEST['name'];
    $dptname = $_REQUEST['dptname'];
    $email = $_REQUEST['email'];
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
                echo "SuccessUpdatingLecturer";
            }
        }
        else{echo "Department doesn't exist";}
        
    }   
}
?>