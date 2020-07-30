<?php 
include "./includes/header.php";
if (empty($_SESSION['name'])) {
    header("Location: index.php");
} else if (empty($_SESSION['projectid']) AND $_SESSION['currentUser'] == 'student') {
    header("Location: dashboard.php");
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
                        <p class="lead">By: <?=$_SESSION['name']; ?></p>
                    </div>
                    <div class="bg-dark rounded text-light px-3 py-1 text-center font-weight-bold">
                        <p>GRADE</p>
                        <p><?= isset($_SESSION['grade']) ? $_SESSION['grade'] : "N/A"; ?></p>
                    </div>
                </div>
                <hr class="my-4">
                <div class="p-5 bg-secondary  row">
                    
                    <div class="col-md-9 text-center">
                        <div class="m-auto text-center bg-white rounded mb-2 pt-2" style="min-height: 100vh;">
                            Text Editor here
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <a href="#" class="btn btn-dark mb-3">Save Document</a>

                        <?php if ($_SESSION['currentUser'] === "lecturer"): ?>
                        <form id="grade-form" class="my-2" >
                            <div class="form-group">
                                <label for="gradeInput" class="text-light">Grade</label>
                                <input placeholder="Enter grade (1 to 10)" class="form-control" id="gradeInput">
                            </div>
                            <a type="submit" href="#" class="btn btn-dark mb-3">Assign</a>
                        </form>
                        <?php endif; ?>

                        <form id="comment-form" class="my-2" >
                            <div class="form-group">
                                <label for="commentTextarea" class="text-light">Comments</label>
                                <textarea placeholder="Comment on project" class="form-control" id="commentTextarea" rows="3"></textarea>
                            </div>
                            <a type="submit" href="#" class="btn btn-dark mb-3">Add Comment</a>
                        </form>

                        <div class="card m-auto text-center rounded" style="">
                        <div class="card-body">
                            <h5 class="card-title text-dark"><i class="fa fa-comments"></i></h5>
                        </div>
                        <ul class="list-group list-group-flush comments-list">
                            <li class="list-group-item">I couldn't find all the articles you listed so i search for extra ones.
                                <p class="text-muted small">By Student</p>
                            </li>
                            <li class="list-group-item">A very good work.
                            <p class="text-muted small">By Supervisor</p>

                            </li>
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