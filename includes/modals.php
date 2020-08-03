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
        <h4 class="text-danger">Are you sure you want to <?= $_SESSION['currentUser'] === "admin"? "remove this user account" : "delete your project" ; ?> ?</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal">No</button>
        <?php if($_SESSION['currentUser'] === "admin"): ?>
            <?php $details = $registeredUsers[$_GET['dSelected']]; ?>

            <?php if($_SESSION['adminView'] === "Students"): ?>
              <a href="./includes/adminprocessing.php?delstudent=1&matricno=<?=$details['matricno']?>" type="button" class="btn btn-secondary">Remove</a> 
            <?php elseif($_SESSION['adminView'] === "Lecturers"): ?>
              <a href="./includes/adminprocessing.php?dellecturer=1&id=<?=$details['id']?>" type="button" class="btn btn-secondary">Remove</a> 
            <?php endif; ?>
        <?php else: ?>
            <a href="./includes/studentprocessing.php?delete=confirmed" type="button" class="btn btn-secondary">Delete</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<!-- New account modal  -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content text-center">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New <?=$_SESSION["adminView"] === "Lecturers"? "Lecturer" : "Student"; ?> Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      <?php if($_SESSION["adminView"] === "Students"): ?>
        
        <form type="<?=$_SESSION["adminView"]; ?>" id="" action="#" method="post" class="admin-form m-auto">
        <div class="form-group">
            <label class="text-dark" for="matricno">Matric Number</label>
            <input type="text" class="form-control" placeholder="e.g. 12345678" id="matricno" name="matricno">
        </div>
        <div class="form-group">
            <label class="text-dark" for="name">Full Name</label>
            <input type="text" class="form-control" placeholder="e.g. John Doe" id="name" name="name">
        </div>
        <div class="form-group">
            <label class="text-dark" for="level">Level</label>
            <input type="text" class="form-control" placeholder="e.g. 400" id="level" name="level">
        </div>
        <div class="form-group">
            <label class="text-dark" for="departmentname">Department Name</label>
            <select class="form-control" id="departmentname" name="departmentname">
              <?php foreach($_SESSION['availableDepartments'] as $department): ?>
                <option><?=$department['name']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        <div class="form-group">
            <label class="text-dark" for="lecturerid">Supervisor</label>
            <select class="form-control" id="lecturerid" name="lecturerid">
              <?php foreach($_SESSION['availableLecturers'] as $lecturer): ?>
                <option value="<?=$lecturer['id'] ?>"><?=$lecturer['name']; ?></option>
              <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label class="text-dark" for="password">Temporary Password</label>
            <input type="password" class="form-control" placeholder="* * * * * * * *" id="password" name ="password">
        </div>
        <div class="form-group">
            <label class="text-dark" for="rePassword">Confirm Temporary Password</label>
            <input type="password" class="form-control" placeholder="* * * * * * * *" id="rePassword" name ="rePassword">
        </div>
        <p id="message"></p>
        <div class="form-group">
            <input type="submit" class="form-control btn btn-secondary" value="Create Account" id="ctstudent" name = "ctstudent">
        </div>
        </form>

      <?php elseif($_SESSION["adminView"] === "Lecturers"): ?>

      <form type="<?=$_SESSION["adminView"]; ?>" id="" action="#" method="post" class="admin-form m-auto">
        <div class="form-group">
            <label class="text-dark" for="id">Lecturer Id</label>
            <input type="text" class="form-control" placeholder="e.g. 12345678" id="id" name="id">
        </div>
        <div class="form-group">
            <label class="text-dark" for="name">Full Name</label>
            <input type="text" class="form-control" placeholder="e.g. John Doe" id="name" name="name">
        </div>
        <div class="form-group">
            <label class="text-dark" for="email">Email Address</label>
            <input type="text" class="form-control" placeholder="e.g. john@gmail.com" id="email" name="email">
        </div>
        <div class="form-group">
            <label class="text-dark" for="departmentname">Department Name</label>
            <select class="form-control" id="departmentname" name="departmentname">
              <?php foreach($_SESSION['availableDepartments'] as $department): ?>
                <option><?=$department['name']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        <div class="form-group">
            <label class="text-dark" for="password">Temporary Password</label>
            <input type="password" class="form-control" placeholder="* * * * * * * *" id="password" name ="password">
        </div>
        <div class="form-group">
            <label class="text-dark" for="rePassword">Confirm Temporary Password</label>
            <input type="password" class="form-control" placeholder="* * * * * * * *" id="rePassword" name ="rePassword">
        </div>
        <p id="message"></p>
        <div class="form-group">
            <input type="submit" class="form-control btn btn-secondary" value="Create Account" id="ctlecturer" name = "ctlecturer">
        </div>
        </form>

        <?php endif; ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit modal  -->

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content text-center">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit <?=$_SESSION["adminView"] === "Lecturers"? "Lecturer" : "Student"; ?> Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php $details = $registeredUsers[$_GET['selected']]; ?>

      <?php if($_SESSION["adminView"] === "Students"): ?>
        
        <form mode="edit" type="<?=$_SESSION["adminView"]; ?>" id="" action="#" method="post" class="admin-form m-auto edit-form">
        <div class="form-group">
            <label class="text-dark" for="matricno">Matric Number</label>
            <input value="<?= $details['matricno']; ?>" type="text" class="form-control" placeholder="e.g. 12345678" id="matricno" name="matricno">
        </div>
        <div class="form-group">
            <label class="text-dark" for="name">Full Name</label>
            <input value="<?= $details['name']; ?>" type="text" class="form-control" placeholder="e.g. John Doe" id="name" name="name">
        </div>
        <div class="form-group">
            <label class="text-dark" for="level">Level</label>
            <input value="<?= $details['level']; ?>" type="text" class="form-control" placeholder="e.g. 400" id="level" name="level">
        </div>
        <div class="form-group">
            <label class="text-dark" for="departmentname">Department Name</label>
            <select class="form-control" id="departmentname" name="departmentname">
              <?php foreach($_SESSION['availableDepartments'] as $department): ?>
                <?php if($details['departmentname'] === $department['name']): ?>
                  <option selected><?=$department['name']; ?></option>
                <?php else: ?>
                  <option><?=$department['name']; ?></option>
                <?php endif; ?>
              <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label class="text-dark" for="name">Supervisor</label>
            <select class="form-control" id="lecturerid" name="lecturerid">
              <?php foreach($_SESSION['availableLecturers'] as $lecturer): ?>
                <?php if($details['lecturerid'] === $lecturer['id']): ?>
                  <option value="<?=$lecturer['id']; ?>" selected><?=$lecturer['name']; ?></option>
                <?php else: ?>
                  <option value="<?=$lecturer['id']; ?>"><?=$lecturer['name']; ?></option>
                <?php endif; ?>
              <?php endforeach; ?>
            </select>
        </div>
        <p id="editMessage"></p>
        <div class="form-group">
            <input type="submit" class="form-control btn btn-secondary" value="Update Account" id="etstudent" name = "etstudent">
        </div>
        </form>

      <?php elseif($_SESSION["adminView"] === "Lecturers"): ?>

      <form mode="edit" type="<?=$_SESSION["adminView"]; ?>" id="" action="#" method="post" class="admin-form m-auto edit-form">
        <div class="form-group">
            <label class="text-dark" for="id">Lecturer Id</label>
            <input value="<?= $details['id']; ?>" type="text" class="form-control" placeholder="e.g. 12345678" id="id" name="id">
        </div>
        <div class="form-group">
            <label class="text-dark" for="name">Full Name</label>
            <input value="<?= $details['name']; ?>" type="text" class="form-control" placeholder="e.g. John Doe" id="name" name="name">
        </div>
        <div class="form-group">
            <label class="text-dark" for="email">Email Address</label>
            <input value="<?= $details['email']; ?>" type="text" class="form-control" placeholder="e.g. john@gmail.com" id="email" name="email">
        </div>
        <div class="form-group">
            <label class="text-dark" for="departmentname">Department Name</label>
            <select class="form-control" id="departmentname" name="departmentname">
              <?php foreach($_SESSION['availableDepartments'] as $department): ?>
                <?php if($details['departmentname'] === $department['name']): ?>
                  <option selected><?=$department['name']; ?></option>
                <?php else: ?>
                  <option><?=$department['name']; ?></option>
                <?php endif; ?>
              <?php endforeach; ?>
            </select>
          </div>
        
        <p id="editMessage"></p>
        <div class="form-group">
            <input type="submit" class="form-control btn btn-secondary" value="Update Account" id="etlecturer" name = "etlecturer">
        </div>
        </form>

        <?php endif; ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

