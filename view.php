<?php 
include "./includes/session.php";
include "./includes/header.php";
if (empty($_SESSION['name'])) {
    header("Location: index.php");
} else if (empty($_SESSION['projectid']) AND $_SESSION['currentUser'] == 'student') {
    header("Location: dashboard.php");
} else if ($_SESSION['currentUser'] == "lecturer") {
  $assignedStudents = array();
  if (isset($_GET['q']) && !empty($_GET['q'])) {
    $query = $_GET['q'];
    
    foreach($_SESSION['assignedStudents'] as $key => $student) {
      if (stristr($student['matricno'], $query) || stristr($student['name'], $query) || stristr($student['projectname'], $query)) {
        // If it matches, we push to array
        array_push($assignedStudents, $student);
      } else {
        // If no match, we do nothing
      }
    }
  } else {
    $assignedStudents = $_SESSION['assignedStudents'];
  }
}
?>
<div class="dashboard">
    <?php include "./includes/navbar.php"; ?>

    <?php if ($_SESSION['currentUser'] == 'student'): ?>
      <div class="dashboard-view">
        <div class="jumbotron border-radius-0">
            <div class="container">
                <h1 class="display-4"><?=$_SESSION["projectname"]; ?></h1>
                <p class="lead">By: <?=$_SESSION['name']; ?></p>
                <hr class="my-4">
                <div class="p-5 bg-secondary align-items-center row">
                    <div class="col-md-4 text-center">
                        <div class="card m-auto text-center rounded" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title text-dark"><i class="fa fa-download"></i></h5>
                            <p class="card-text">Uploaded project document</p>
                            <a href="./projects/<?=$_SESSION['path']; ?>" class="btn btn-dark">Download</a>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="card m-auto text-center rounded" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title text-dark"><i class="fa fa-pencil"></i></h5>
                            <p class="card-text">View and edit document</p>
                            <a href="editDocument.php" class="btn btn-dark">View</a>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="card m-auto text-center rounded" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title text-danger"><i class="fa fa-trash"></i></h5>
                            <p class="card-text text-danger">Put document in trash</p>
                            <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#confirmModal">Delete</a>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div>

    <?php elseif ($_SESSION['currentUser'] == 'admin'): ?>

      <div class="dashboard-view">
        <div class="jumbotron border-radius-0">
            <div class="container">
                <h1 class="display-4"><?=$_SESSION["adminView"]; ?> Portal</h1>
                <p class="lead">Manage registered <?=$_SESSION["adminView"]; ?></p>
                <hr class="my-4">
                <div class="p-5 bg-secondary align-items-center row">

                    <?php if($_SESSION["adminView"] === "Students"): ?>

                      <div class="col-md-6 text-center">
                        <div class="card m-auto text-center rounded" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title text-dark"><i class="fa fa-plus"></i></h5>
                            <p class="card-text text-dark">Create a new student account</p>
                            <a href="#" class="btn btn-dark" data-toggle="modal" data-target="#addModal">Add Student</a>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <div class="card m-auto text-center rounded" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title text-dark"><i class="fa fa-cog"></i><i class="fa fa-graduation-cap px-1"></i></h5>
                            <p class="card-text">View and manage students</p>
                            <a href="adminManage.php" class="btn btn-dark">Manage</a>
                        </div>
                        </div>
                    </div>

                      <?php elseif($_SESSION["adminView"] === "Lecturers"): ?>

                        <div class="col-md-6 text-center">
                            <div class="card m-auto text-center rounded" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title text-dark"><i class="fa fa-plus"></i></h5>
                                <p class="card-text text-dark">Create a new lecturer account</p>
                                <a href="#" class="btn btn-dark" data-toggle="modal" data-target="#addModal">Add Lecturer</a>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            <div class="card m-auto text-center rounded" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title text-dark"><i class="fa fa-cog"></i><i class="fa fa-university px-1"></i></h5>
                                <p class="card-text">View and manage lecturers</p>
                                <a href="adminManage.php" class="btn btn-dark">Manage</a>
                            </div>
                            </div>
                        </div>
                        
                      <?php endif; ?>

                </div>
            </div>
        </div>
        
    <div>
    <?php elseif ($_SESSION['currentUser'] == 'lecturer'): ?>
      <div class="dashboard-view">
        <div class="jumbotron border-radius-0">
            <div class="container">

                <div class="d-flex flex-row align-items-center justify-content-between">
                    <div>
                      <h1 class="display-4">Assigned Students</h1>
                      <p class="lead">To: <?= $_SESSION['name']; ?></p>
                    </div>
                    <form class="form-inline text-center" method="GET">
                        <input value="<?= isset($_GET['q']) ? $_GET['q'] : ""; ?>" name="q" type="text" class="form-control mb-2 mr-sm-2" id="search" placeholder="Search by name, id, project..">
                        <button type="submit" class="btn btn-dark mb-2">
                        <i class="fa fa-search"></i>
                        </button>
                  </form>
                </div>

                <hr class="my-4">
                <div class="p-5 bg-secondary align-items-center row">
                  
                <!-- Student card  -->
                <?php if(count($assignedStudents) > 0): ?>

                <?php foreach($assignedStudents as $student): ?>

                    <div class="col-md-4 text-center">
                        <div class="card m-auto text-center rounded" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title text-dark"><i class="fa fa-id-card"></i></h5>
                            <ul class="list-group list-group-flush">
                              <li class="list-group-item">
                                  <?= $student['matricno'] ?>
                                  <p class="text-muted small">Matric Number</p>
                              </li>
                              <li class="list-group-item">
                                  <?= $student['name'] ?>
                                  <p class="text-muted small">Full Name</p>
                              </li>
                              <li class="list-group-item">
                                  <?= empty($student['projectname']) ? "-" : $student['projectname']; ?>
                                  <p class="text-muted small">Project Topic</p>
                              </li>
                            </ul>
                            <?php if(empty($student['projectname'])):?>
                              <a href="#" class="btn btn-secondary disabled" disabled>No project uploaded</a>
                            <?php else: ?>
                            <a project="<?=$student['projectid']; ?>" student="<?=$student['name']; ?>" href="#" class="btn btn-dark view-student">View & Manage Project</a>
                            <?php endif; ?>
                        </div>
                        </div>
                    </div>

                <?php endforeach; ?>

                <?php else:  ?>
                    <h3 class="text-white">No assigned students found.</h3>
                <?php endif; ?>


                </div>
            </div>
        </div>
        
    <div>

    <?php endif; ?>
    
        
</div>

<!-- Modals  -->
<?php include "./includes/modals.php"; ?>

</div>
<div class="bg-secondary p-3 bg-secondary footer align-content-center">
    <p class="text-center text-light m-auto p-1">CU PMS &copy; 2020</p>
</div>


<?php include "./includes/footer.php" ?>