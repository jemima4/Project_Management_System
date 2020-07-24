<?php 
    include "./includes/header.php";
?>

<div class="login bg-secondary">
<div class="p-5 bg-dark">
    <h1 class="login-title mb-4 text-light">CU PMS Admin</h1>

        <form action="#" type="Admin" class="login-form m-auto">
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
        
</div>
<div>

<?php include "./includes/footer.php" ?>