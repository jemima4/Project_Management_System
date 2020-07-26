<?php 
$active = "create";
include "./includes/header.php";

?>
<div class="dashboard">
    <?php include "./includes/navbar.php" ?>

    <div class="dashboard-view">
        <div class="jumbotron border-radius-0">
            <div class="container">
                <h1 class="display-4">New Project</h1>
                <p class="lead">Provide the following details to create the project</p>
                <hr class="my-4">

<div class="p-5 bg-dark">

    <form action="#" class="login-form m-auto">
        <div class="form-group">
            <label class="text-light" for="matricNo">Project Name</label>
            <input type="text" class="form-control" placeholder="e.g. 12345678" id="matricNo">
        </div>
        <div class="form-group">
            <label class="text-light" for="password">Upload Document</label>
            <input type="file" class="form-control" placeholder="" id="projectFile">
        </div>
        <p id="message"></p>
        <div class="form-group">
            <input type="submit" class="form-control btn btn-secondary" value="Create" id="create">
        </div>
    </form>

</div>

            </div>
        </div>
        <div class="container">
        
        </div>
    <div>
</div>
</div>
<div class="bg-secondary p-3 bg-secondary footer align-content-center">
    <p class="text-center text-light m-auto p-1">CU PMS &copy; 2020</p>
</div>


<?php include "./includes/footer.php" ?>