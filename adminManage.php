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

                    <?php foreach($registeredUsers as $index => $student): ?>

                        <div class="col-md-4 text-center mb-4">
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
                                <a user="<?=$user['name']; ?>" index="<?=$index ?>" href="?selected=<?=$index ?>" class="btn btn-dark" >Edit</a>
                                <a user="<?=$user['name']; ?>" href="#" class="btn btn-danger" data-toggle="modal" data-target="#confirmModal">Remove</a>

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

<?php include "./includes/modals.php"; ?>

</div>
<div class="bg-secondary p-3 bg-secondary footer align-content-center">
    <p class="text-center text-light m-auto p-1">CU PMS &copy; 2020</p>
</div>




<?php include "./includes/footer.php" ?>

<?php if(isset($_GET['selected'])): ?>
<script>
    $(()=> {
        $('#editModal').modal('show');
    })
</script>
<?php endif; ?>