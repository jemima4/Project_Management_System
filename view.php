<?php 
include "./includes/session.php";
include "./includes/header.php";
if (empty($_SESSION['name'])) {
    header("Location: index.php");
} else if (empty($_SESSION['projectid']) AND $_SESSION['currentUser'] == 'student') {
    header("Location: dashboard.php");
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
    <?php elseif ($_SESSION['currentUser'] == 'lecturer'): ?>
      <div class="dashboard-view">
        <div class="jumbotron border-radius-0">
            <div class="container">

                <div class="d-flex flex-row align-items-center justify-content-between">
                    <div>
                      <h1 class="display-4">Assigned Students</h1>
                      <p class="lead">To: <?= $_SESSION['name']; ?></p>
                    </div>
                    <form class="form-inline text-center">
                        <input type="text" class="form-control mb-2 mr-sm-2" id="search" placeholder="Search...">
                        <button type="submit" class="btn btn-dark mb-2">
                        <i class="fa fa-search"></i>
                        </button>
                  </form>
                </div>

                <hr class="my-4">
                <div class="p-5 bg-secondary align-items-center row">
                  
                <!-- Student card  -->
                <?php foreach($_SESSION['assignedStudents'] as $student): ?>

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
                                  <?= $student['projectname'] ?>
                                  <p class="text-muted small">Project Topic</p>
                              </li>
                            </ul>
                            <a href="editDocument.php" class="btn btn-dark">View & Manage Project</a>
                        </div>
                        </div>
                    </div>

                <?php endforeach; ?>

                </div>
            </div>
        </div>
        
    <div>

    <?php endif; ?>
    
        
</div>

<!-- Confirm modal  -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content text-center">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4 class="text-danger">Are you sure you want to delete your project ?</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal">No</button>
        <a href="./includes/studentprocessing.php?delete=confirmed" type="button" class="btn btn-secondary">Delete</a>
      </div>
    </div>
  </div>
</div>

</div>
<div class="bg-secondary p-3 bg-secondary footer align-content-center">
    <p class="text-center text-light m-auto p-1">CU PMS &copy; 2020</p>
</div>


<?php include "./includes/footer.php" ?>