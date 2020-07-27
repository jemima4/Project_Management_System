<!DOCTYPE html>
<html>
    <head>  
        <title>Admin</title>        
    </head>
    <body>
    <form action="./includes/studentprocessing.php" method="post" enctype="multipart/form-data">
        <input type="text" name="projectName" placeholder="Name" />
        <br>
        <input type="file" name="projectFile" id="projectFile" placeholder="Upload file" />
        <input type="submit" name="ctproject" />
    </form>
    </body>
</html>