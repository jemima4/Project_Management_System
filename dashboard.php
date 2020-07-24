<?php include "./includes/header.php" ?>
<div class="dashboard">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a id="brand" class="navbar-brand" href="#">CU PMS</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <div class="navbar-nav">
                <a class="nav-item nav-link active" href="#">Home <span class="sr-only">(current)</span></a>
                <a class="nav-item nav-link" href="#">Create Project</a>
                <a class="nav-item nav-link" href="#">View Project</a>
            </div>
            <div class="dropdown ml-auto">
                <a class="nav-link text-light dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="assets/profile.png" width="30" height="30" loading="lazy" alt="Profile icon">
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                    <h6 class="dropdown-header" disabled>Full Name</h6>
                    <div class="dropdown-divider"></div>        
                    <a class="dropdown-item" href="#">Log out</a>
                </div>
            </div>
        </div>
    </div>
    </nav>


    <div class="dashboard-view">
        <div class="jumbotron border-radius-0">
            <div class="container">
                <h1 class="display-4">Hello, Student</h1>
                <p class="lead">Welcome to CU Project Management System</p>
                <hr class="my-4">
                <p>What do you want to do?</p>
                <a class="btn btn-dark btn-lg mb-1" href="#" role="button">Create New Project</a>
                <a class="btn btn-secondary btn-lg mb-1" href="#" role="button">View and Manage Existing Projects</a>
            </div>
        </div>
        <div class="container">
        <div class="row ">
            <div class="col-md-6">
                <div class="card m-auto" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Your Details</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Olga Simpson</li>
                        <li class="list-group-item">Level 400</li>
                        <li class="list-group-item">Department of Pharmacy</li>
                    </ul>
                </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-white mx-auto" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Your Supervisor</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Dr. Fred Jackson</li>
                        <li class="list-group-item">Department of Pharmacy</li>
                    </ul>
                </div>
                </div>
            </div>

        </div>
        </div>
    <div>
</div>
</div>
<div class="bg-secondary p-3 bg-secondary footer align-content-center">
    <p class="text-center text-light m-auto p-1">CU PMS &copy; 2020</p>
</div>


<?php include "./includes/footer.php" ?>