<!DOCTYPE html>
<html>
    <head>  
        <title>Admin</title>        
    </head>
    <body>
    <form action="./includes/loginprocessing.php" method="post">
        <input type="text" name="id" placeholder="Test 1" />
        <input type="submit" name="stlogin" />
    </form> 
    <form action="admin.php" method="post">
        <input type="text" name="id" placeholder="Test 2" />
        <input type="submit" name="submit" />
    </form>
    </body>
</html>