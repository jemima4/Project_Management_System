<?php 
include "./includes/header.php";
if (empty($_SESSION['name'])) {
    header("Location: index.php");
} else if (empty($_SESSION['projectid'])) {
    header("Location: dashboard.php");
}
?>
<div class="dashboard">
    <?php include "./includes/navbar.php" ?>

    <div class="dashboard-view">
        <div class="jumbotron border-radius-0">
            <div class="container">
                <h1 class="display-4">Project Title</h1>
                <p class="lead">By: Student name</p>
                <hr class="my-4">
                <div class="p-5 bg-secondary align-items-center row">
                    <div class="col-md-4 text-center">
                        <div class="card m-auto text-center rounded" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title text-dark"><i class="fa fa-download"></i></h5>
                            <p class="card-text">Uploaded project document</p>
                            <a href="#" class="btn btn-dark">Download</a>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="card m-auto text-center rounded" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title text-dark"><i class="fa fa-pencil"></i></h5>
                            <p class="card-text">View and edit document</p>
                            <a href="editDocument.php" class="btn btn-dark">View</a>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="card m-auto text-center rounded" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title text-danger"><i class="fa fa-trash"></i></h5>
                            <p class="card-text text-danger">Put document in trash</p>
                            <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#confirmModal">Delete</a>
                        </div>
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