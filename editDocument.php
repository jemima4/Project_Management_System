<?php 
include "./includes/header.php";
include "./includes/connection.php";

// Comments fetch
$commentsList = array();
function fetchComments()
{
    global $db;
    $projectid = $_SESSION['projectid'];
    $query = "SELECT * FROM project_tb WHERE id = '$projectid'";
    $result = mysqli_query($db , $query);
    if(!$result)
    {
        die("Error fetching comments");
    }
    else
    {
        $ptdetails = mysqli_fetch_assoc($result);
        $_SESSION['comment'] = $ptdetails['comment'];
        $holder1 = explode(";",$_SESSION['comment']);

        global $commentsList;
        foreach($holder1 as $hold)
        {
            $holder2 = explode(",",$hold);
            array_push($commentsList, $holder2);
        }
        $commentsList = array_reverse($commentsList);
    }
}

if (empty($_SESSION['name'])) {
    header("Location: index.php");
} else if (empty($_SESSION['projectid']) AND $_SESSION['currentUser'] == 'student') {
    header("Location: dashboard.php");
} else {
    fetchComments();
}
?>
<div class="dashboard">
    <?php include "./includes/navbar.php" ?>

    <div class="dashboard-view">
        <div class="jumbotron border-radius-0">
            <div class="container">
               <div class="d-flex flex-row align-items-center justify-content-between">
                    <div>
                        <h1 class="display-4"><?=$_SESSION["projectname"]; ?></h1>
                        <p class="lead">By: <?= $_SESSION['currentUser'] === "student" ? $_SESSION['name'] : $_SESSION['selectedStudent']; ?></p>
                    </div>
                    <div class="bg-dark rounded text-light px-3 py-1 pt-3 text-center font-weight-bold">
                        <p>GRADE</p>
                        <p><?= empty($_SESSION['grade']) ? "N/A" : $_SESSION['grade']."%"; ?></p>
                    </div>
                </div>
                <hr class="my-4">
                <div class="p-5 bg-secondary  row">
                    
                    <div class="col-md-9 text-center">
                        <div class="m-auto text-center bg-white rounded mb-2 pt-2" style="min-height: 100vh;">
                            <h3 class="p-1 pb-2">Project Document</h3>
                            <div class="form-group">
                                <textarea placeholder="Doc contents here" name="docContent" class="form-control" id="docContent" rows="30">
                                    <?= $_SESSION['docContent']; ?>
                                </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <a href="#" class="btn btn-dark mb-3">Save Document</a>

                        <?php if ($_SESSION['currentUser'] === "lecturer"): ?>
                        <form id="grade-form" class="my-2" >
                            <div class="form-group">
                                <label for="newgrade" class="text-light">Grade</label>
                                <input value="<?= empty($_SESSION['grade']) ? "" : $_SESSION['grade']; ?>" placeholder="Enter grade (0 to 100)" name="newgrade" class="form-control" id="newgrade">
                            </div>
                            <p id="Gmessage"></p>
                            <button type="submit" class="btn btn-dark mb-3 disabled">Assign</button>
                        </form>
                        <?php endif; ?>

                        <form class="my-2 comment-form" >
                            <div class="form-group">
                                <label for="newComment" class="text-light">Comments</label>
                                <textarea placeholder="Comment on project" name="newComment" class="form-control" id="newComment" rows="3"></textarea>
                            </div>
                            <p id="message"></p>
                            <input type="submit" class="btn btn-dark mb-3" value="Add Comment" />
                        </form>

                        <div class="card m-auto text-center rounded" style="">
                        <div class="card-body">
                            <h5 class="card-title text-dark"><i class="fa fa-comments"></i></h5>
                        </div>
                        <ul class="list-group list-group-flush comments-list">

                        <?php if(!empty($_SESSION['comment'])): ?>

                            <?php foreach($commentsList as $commentItem): ?>
                                <li class="list-group-item rounded-circle mb-1 border-secondary pb-3 shadow-sm <?= $commentItem[0] == "st" ? "text-left" : "text-right" ; ?>">
                                    <?=$commentItem[1]; ?>
                                    <p class="text-muted small p-1 font-weight-bold"><?= $commentItem[0] == "st" ? "By Student" : "By Supervisor" ; ?> </p>
                                </li>
                            <?php endforeach; ?>

                        <?php else: ?>
                            <li class="list-group-item">
                                No comments yet.
                            </li>
                        <?php endif; ?>


                        </ul>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        
    <div>
        
</div>


<!-- Confirm modal  -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content text-center">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4 class="text-danger">Are you sure you want to delete your project document ?</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-secondary">Delete</button>
      </div>
    </div>
  </div>
</div>

</div>
<div class="bg-secondary p-3 bg-secondary footer align-content-center">
    <p class="text-center text-light m-auto p-1">CU PMS &copy; 2020</p>
</div>


<?php include "./includes/footer.php" ?>