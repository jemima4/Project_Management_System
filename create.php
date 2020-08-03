<?php 
include "./includes/session.php";
include "./includes/header.php";
if (empty($_SESSION['name'])) {
    header("Location: index.php");
} 
?>
<div class="dashboard">
    <?php include "./includes/navbar.php" ?>

    <div class="dashboard-view">
        <div class="jumbotron border-radius-0">
            <div class="container">
                <?php if(!empty($_SESSION['projectid'])): ?>
                    <h1 class="display-4">Update Project</h1>
                    <p class="lead">Provide the following details to update the project</p>
                    <hr class="my-4">
                    <div class="p-5 bg-dark">
                        <form action="#" class="create-form m-auto" type="reupload">
                            <div class="form-group">
                                <label class="text-light" for="matricNo">Project Name</label>
                                <input value="<?=$_SESSION['projectname']; ?>" type="text" class="form-control" placeholder="e.g. Study of why pigs fly" id="projectName" name="projectName">
                            </div>
                            <div class="form-group">
                                <label class="text-light" for="projectFile">Upload Document</label>
                                <input type="file" class="form-control" id="projectFile" name="projectFile">
                            </div>
                            <p id="message"></p>
                            <div class="form-group">
                                <input type="submit" class="form-control btn btn-secondary" value="Update" id="Update">
                            </div>
                            <div class="progress" style="display: none">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 0%"></div>
                            </div>
                        </form>
                    </div>
                <?php else: ?>
                    <h1 class="display-4">New Project</h1>
                    <p class="lead">Provide the following details to create the project</p>
                    <hr class="my-4">
                    <div class="p-5 bg-dark">
                        <form action="#" class="create-form m-auto" type="newupload">
                            <div class="form-group">
                                <label class="text-light" for="matricNo">Project Name</label>
                                <input type="text" class="form-control" placeholder="e.g. Study of why pigs fly" id="projectName" name="projectName">
                            </div>
                            <div class="form-group">
                                <label class="text-light" for="projectFile">Upload Document</label>
                                <input type="file" class="form-control" id="projectFile" name="projectFile">
                            </div>
                            <p id="message"></p>
                            <div class="form-group">
                                <input type="submit" class="form-control btn btn-secondary" value="Create" id="create">
                            </div>
                            <div class="progress" style="display: none">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 0%"></div>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
                
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