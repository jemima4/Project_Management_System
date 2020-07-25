<?php 
    include "./includes/header.php";
    isset($_GET['type']) ?  $type = $_GET['type'] : header("Location: index.php");
?>

<div class="login bg-secondary">
<div class="p-5 bg-dark">
    <h1 class="login-title mb-4 text-light"><span id="brand">CU PMS</span> <?= $type; ?></h1>

    <?php if ($type === "Student"): ?>
        <form action ="./includes/loginprocessing.php" method="post" type=<?= $type; ?> class="login-form m-auto">
        <div class="form-group">
            <label class="text-light" for="matricNo">Matric Number</label>
            <input type="text" class="form-control" placeholder="e.g. 12345678" id="matricNo" name="matricNo">
        </div>
        <div class="form-group">
            <label class="text-light" for="password">Password</label>
            <input type="password" class="form-control" placeholder="* * * * * * * *" id="password" name ="stpassword">
        </div>
        <p id="message"></p>
        <div class="form-group">
            <input type="submit" class="form-control btn btn-secondary" value="Login" id="stlogin" name = "stlogin">
        </div>
        </form>

    <?php elseif ($type === "Lecturer"): ?>
        <form action="#" type=<?= $type; ?> class="login-form m-auto">
        <div class="form-group">
            <label class="text-light" for="email">Email address</label>
            <input type="email" class="form-control" placeholder="e.g. john@gmail.com" id="email">
        </div>
        <div class="form-group">
            <label class="text-light" for="password">Password</label>
            <input type="password" class="form-control" placeholder="* * * * * * * *" id="password">
        </div>
        <p id="message"></p>
        <div class="form-group">
            <input type="submit" class="form-control btn btn-secondary" value="Login" id="login">
        </div>
        </form>
        
    <?php endif; ?>

</div>
<div>
<p class="bg-secondary text-center text-light p-3 mt-4">CU PMS &copy; 2020</p>


<?php include "./includes/footer.php" ?>