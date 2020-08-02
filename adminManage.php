<?php 
include "./includes/session.php";
include "./includes/header.php";
if (empty($_SESSION['name'])) {
    header("Location: index.php");
} else if (empty($_SESSION['projectid']) AND $_SESSION['currentUser'] == 'student') {
    header("Location: dashboard.php");
} else if ($_SESSION['currentUser'] !== "admin") {
    header("Location: index.php");
} else if ($_SESSION['currentUser'] == "admin") {
  $registeredUsers = array();
  if (isset($_GET['q']) && !empty($_GET['q'])) {
    $query = $_GET['q'];
    // When admin is looking at students
    if ($_SESSION['adminView'] === "Students") {
        foreach($_SESSION['registeredUsers'] as $key => $user) {
            if (stristr($user['matricno'], $query) || stristr($user['name'], $query)) {
              // If it matches, we push to array
              array_push($registeredUsers, $user);
            } else {
              // If no match, we do nothing
            }
        }
    // When admin is looking at lecturers
    } else if ($_SESSION['adminView'] === "Lecturers") {
        foreach($_SESSION['registeredUsers'] as $key => $user) {
            if (stristr($user['id'], $query) || stristr($user['name'], $query)) {
              // If it matches, we push to array
              array_push($registeredUsers, $user);
            } else {
              // If no match, we do nothing
            }
        }
    }

  } else {
    $registeredUsers = $_SESSION['registeredUsers'];
  }
}
?>
<div class="dashboard">
    <?php include "./includes/navbar.php"; ?>

    <?php if ($_SESSION['currentUser'] == 'admin'): ?>
      <div class="dashboard-view">
        <div class="jumbotron border-radius-0">
            <div class="container">

                <div class="d-flex flex-row align-items-center justify-content-between">
                    <div>
                      <h1 class="display-4">Registered <?=$_SESSION['adminView']; ?></h1>
                      <p class="lead">Manage registered <?=$_SESSION["adminView"]; ?></p>
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
                  
                <!-- Student and Lecturers card  -->
                <?php if(count($registeredUsers) > 0): ?>

                    <?php foreach($registeredUsers as $student): ?>

                        <div class="col-md-4 text-center">
                            <div class="card m-auto text-center rounded" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title text-dark"><i class="fa fa-id-card"></i></h5>
                                <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <?php if($_SESSION['adminView'] === "Students"): ?>
                                    <?= $student['matricno'] ?>
                                    <p class="text-muted small">Matric Number</p>
                                    <?php else: ?>
                                    <?= $student['id'] ?>
                                    <p class="text-muted small">Index Number</p>
                                    <?php endif; ?>
                                </li>
                                <li class="list-group-item">
                                    <?= $student['name'] ?>
                                    <p class="text-muted small">Full Name</p>
                                </li>
                                <li class="list-group-item">
                                    

                                    <?php if($_SESSION['adminView'] === "Students"): ?>
                                        <?= $student['level'] ?>
                                        <p class="text-muted small">Level</p>
                                    <?php else: ?>
                                        <?= $student['email'] ?>
                                        <p class="text-muted small">Email address</p>
                                    <?php endif; ?>
                                </li>
                                <li class="list-group-item">
                                    <?= $student['departmentname'] ?>
                                    <p class="text-muted small">Department</p>
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
                    <h3 class="text-white">No registered accounts found.</h3>
                <?php endif; ?>


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

<!-- New account modal  -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content text-center">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New <?=$_SESSION["adminView"] === "Lecturers"? "Lecturer" : "Student"; ?> Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      <?php if($_SESSION["adminView"] === "Students"): ?>
        
        <form type="<?=$_SESSION["adminView"]; ?>" id="" action="#" method="post" class="admin-form m-auto">
        <div class="form-group">
            <label class="text-dark" for="matricno">Matric Number</label>
            <input type="text" class="form-control" placeholder="e.g. 12345678" id="matricno" name="matricno">
        </div>
        <div class="form-group">
            <label class="text-dark" for="name">Full Name</label>
            <input type="text" class="form-control" placeholder="e.g. John Doe" id="name" name="name">
        </div>
        <div class="form-group">
            <label class="text-dark" for="level">Level</label>
            <input type="text" class="form-control" placeholder="e.g. 400" id="level" name="level">
        </div>
        <div class="form-group">
            <label class="text-dark" for="departmentname">Department Name</label>
            <input type="text" class="form-control" placeholder="e.g. Chemistry" id="departmentname" name="departmentname">
        </div>
        <div class="form-group">
            <label class="text-dark" for="name">Supervisor</label>
            <select class="form-control" id="lecturerid" name="lecturerid">
              <option value="654321">Terra Baffoe</option>
              <option value="954321">Seth Whenton</option>
              <option value="#">We need the query here</option>
            </select>
        </div>
        <div class="form-group">
            <label class="text-dark" for="password">Temporary Password</label>
            <input type="password" class="form-control" placeholder="* * * * * * * *" id="password" name ="password">
        </div>
        <div class="form-group">
            <label class="text-dark" for="rePassword">Confirm Temporary Password</label>
            <input type="password" class="form-control" placeholder="* * * * * * * *" id="rePassword" name ="rePassword">
        </div>
        <p id="message"></p>
        <div class="form-group">
            <input type="submit" class="form-control btn btn-secondary" value="Create Account" id="ctstudent" name = "ctstudent">
        </div>
        </form>

      <?php elseif($_SESSION["adminView"] === "Lecturers"): ?>

      <form type="<?=$_SESSION["adminView"]; ?>" id="" action="#" method="post" class="admin-form m-auto">
        <div class="form-group">
            <label class="text-dark" for="lecturerId">Lecturer Id</label>
            <input type="text" class="form-control" placeholder="e.g. 12345678" id="lecturerId" name="lecturerId">
        </div>
        <div class="form-group">
            <label class="text-dark" for="fullName">Full Name</label>
            <input type="text" class="form-control" placeholder="e.g. John Doe" id="fullName" name="fullName">
        </div>
        <div class="form-group">
            <label class="text-dark" for="email">Email Address</label>
            <input type="text" class="form-control" placeholder="e.g. john@gmail.com" id="email" name="email">
        </div>
        <div class="form-group">
            <label class="text-dark" for="departmentName">Department Name</label>
            <input type="text" class="form-control" placeholder="e.g. Chemistry" id="departmentName" name="departmentName">
        </div>
        <div class="form-group">
            <label class="text-dark" for="password">Temporary Password</label>
            <input type="password" class="form-control" placeholder="* * * * * * * *" id="password" name ="password">
        </div>
        <div class="form-group">
            <label class="text-dark" for="rePassword">Confirm Temporary Password</label>
            <input type="password" class="form-control" placeholder="* * * * * * * *" id="rePassword" name ="rePassword">
        </div>
        <p id="message"></p>
        <div class="form-group">
            <input type="submit" class="form-control btn btn-secondary" value="Create Account" id="ctstudent" name = "ctstudent">
        </div>
        </form>

        <?php endif; ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

</div>
<div class="bg-secondary p-3 bg-secondary footer align-content-center">
    <p class="text-center text-light m-auto p-1">CU PMS &copy; 2020</p>
</div>


<?php include "./includes/footer.php" ?>