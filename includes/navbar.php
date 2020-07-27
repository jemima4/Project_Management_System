
<?php     
    $fullName = isset($_SESSION['name']) ? $_SESSION['name'] : "Sample Student";
 ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a id="brand" class="navbar-brand" href="#">CU PMS</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <div class="navbar-nav">
                <a class="nav-item nav-link active" href="dashboard.php">Home <span class="sr-only">(current)</span></a>
                <?php if(!isset($_SESSION["projectid"])): ?>
                    <a class="nav-item nav-link" href="./create.php">Create Project</a>
                <?php else: ?>
                    <a class="nav-item nav-link" href="./view.php">View Project</a>
                <?php endif; ?>
            </div>
            <div class="dropdown ml-auto">
                <a class="nav-link text-light dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="assets/profile.png" width="30" height="30" loading="lazy" alt="Profile icon">
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                    <h6 class="dropdown-header" disabled><?= $fullName ?></h6>
                    <div class="dropdown-divider"></div>        
                    <a class="dropdown-item" id="logoutUser" href="#">Log out</a>
                </div>
            </div>
        </div>
    </div>
</nav>