<?php 
    include "./includes/header.php";
    if (empty($_SESSION['name'])) {
        header("Location: index.php");
    }
?>
<div class="dashboard">
    <?php include "./includes/navbar.php" ?>

    <div class="dashboard-view">

        <?php if (isset($_GET['u']) AND $_GET['u'] == "lecturer"): ?>
            <div class="jumbotron border-radius-0">
            <div class="container">
                <h1 class="display-4">Hello, <?= $_SESSION['name']; ?></h1>
                <p class="lead">Welcome to CU Project Management System</p>
                <hr class="my-4">
                <p>What do you want to do?</p>
                <a class="btn btn-secondary btn-lg mb-1" href="#" role="button">View and Manage Assigned Students</a>
            </div>
        </div>
        <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="card m-auto" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Your Details</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><?= $_SESSION['name']; ?></li>
                        <li class="list-group-item"><?= $_SESSION['email']; ?></li>
                        <li class="list-group-item">Department of <?= $_SESSION['departmentname']; ?></li>
                    </ul>
                </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-white mx-auto" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">No. of assigned students</h5>
                    <ul class="list-group list-group-flush text-center">
                        <li class="list-group-item bg-dark rounded-circle text-light"><?= "13" ?></li>
                    </ul>
                </div>
                </div>
            </div>

        </div>
        </div>
        <?php else: ?>
            <div class="jumbotron border-radius-0">
            <div class="container">
                <h1 class="display-4">Hello, <?= $_SESSION['name']; ?></h1>
                <p class="lead">Welcome to CU Project Management System</p>
                <hr class="my-4">
                <p>What do you want to do?</p>
                <?php if(!isset($_SESSION["projectid"])): ?>
                    <a class="btn btn-dark btn-lg mb-1" href="create.php" role="button">Create New Project</a>
                <?php endif; ?>
                <a class="btn btn-secondary btn-lg mb-1" href="#" role="button">View and Manage Existing Projects</a>
            </div>
        </div>
        <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="card m-auto" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Your Details</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><?= $_SESSION['name']; ?></li>
                        <li class="list-group-item">Level <?= $_SESSION['level']; ?></li>
                        <li class="list-group-item">Department of <?= $_SESSION['departmentname']; ?></li>
                    </ul>
                </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-white mx-auto" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Your Supervisor</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><?= $_SESSION["lecturername"]; ?></li>
                        <li class="list-group-item">Department of <?= $_SESSION["ltdepartmentname"]; ?></li>
                    </ul>
                </div>
                </div>
            </div>

        </div>
        </div>
        <?php endif; ?>
    <div>
</div>
</div>
<div class="bg-secondary p-3 bg-secondary footer align-content-center">
    <p class="text-center text-light m-auto p-1">CU PMS &copy; 2020</p>
</div>


<?php include "./includes/footer.php" ?>