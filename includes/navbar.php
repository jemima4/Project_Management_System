
<?php     
    $fullName = isset($_SESSION['name']) ? $_SESSION['name'] : "Sample Student";
 ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a id="brand" class="navbar-brand" href="#">PMS</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <div class="navbar-nav">
                <a class="nav-item nav-link active" href="dashboard.php">Home <span class="sr-only">(current)</span></a>
                <?php if(!isset($_SESSION["projectid"]) AND ($_SESSION['currentUser']) === "student"): ?>
                    <a class="nav-item nav-link" href="./create.php">Create Project</a>
                <?php endif; ?>
            </div>
            <div class="dropdown ml-auto">
                <a class="nav-link text-light dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?= ($_SESSION['currentUser'] == 'admin') ? "<i class='fa fa-cog'></i>" : "" ?>
                <img src="assets/profile.png" width="30" height="30" loading="lazy" alt="Profile icon">
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                    <h6 class="dropdown-header" disabled><?= $fullName ?></h6>
                    <div class="dropdown-divider"></div>  
                    <?php if($_SESSION['currentUser'] !== "admin"): ?>
                        <a class="dropdown-item" id="changePassword" href="login.php?type=Password">Change Password</a>
                    <?php endif;?>
                    <a class="dropdown-item" id="logoutUser" href="#">Log out</a>
                </div>
            </div>
        </div>
    </div>
</nav>