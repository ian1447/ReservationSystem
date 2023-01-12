<?php
session_start();
include "../dbcon.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Users Management</title>
</head>

<body class="fixed-left">

  <!-- Top Bar Start -->
  <?php include('./includes/navbar.php'); ?>
  <!-- ========== Left Sidebar Start ========== -->
  <?php include('./includes/sidebar.php'); ?>
  <!-- Left Sidebar End -->

  <main class="mt-5 pt-3 px-4">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12 mb-3">
          <div class="card">
            <div class="card-header">
              <span><i class="bi bi-people-fill me-2"></i></span> Users
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="example" class="table table-hover data-table" style="width: 100%">

                  <div class="m-2">
                    <!-- Button HTML (to Trigger Modal) -->
                    <button type="button" id="myBtn" class="btn btn-outline-success">
                      <span class="me-2"><i class="bi bi-person-plus-fill"></i></span>
                      Add User
                    </button>

                    <!-- Modal HTML -->
                    <div id="myModal" class="modal fade" data-bs-backdrop="static" tabindex="-1">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Add User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                          </div>
                          <div class="modal-body">

                            <form class="needs-validation" method="POST">
                                <div class="col-md-12 mb-2">
                                  <label for="validationCustom01">Username</label>
                                  <input type="text" class="form-control" id="validationCustom01" name="username" placeholder="Enter  Username" required>
                                  <div class="valid-feedback">
                                    Looks good!
                                  </div>
                                </div>
                                <div class="col-md-12 mb-2">
                                  <label for="validationCustom02">Password</label>
                                  <input type="password" class="form-control" id="validationCustom02" name="password" placeholder="Enter Password" required>
                                  <div class="valid-feedback">
                                    Looks good!
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button class="btn" style="background-color: #A75D5D; color: white;">Save</button>
                              </div>
                            </form>
                            <?php
                            if (isset($_POST['username'])){
                              $sql = "INSERT INTO `users` (username,`password`,privilege)
                              VALUES('".$_POST['username']."','" . $_POST['password'] . "','user')";
                              if ($conn->query($sql) === TRUE) {
                                  echo '<script>alert("Account Created!") 
                                  window.location.href="users.php"</script>';
                              } else {
                                  echo '<script>alert("Account Creation Failed!") 
                                  window.location.href="users.php"</script>';
                              }
                            }
                            ?>

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <thead class>
                    <tr>
                      <th>ID</th>
                      <th>Username</th>
                      <th>Password</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                  <?php
                  $sql = "SELECT * from users where privilege='user';";
                  $actresult = mysqli_query($conn, $sql);

                  while ($result = mysqli_fetch_assoc($actresult)) {
                  ?>

                    <tr>
                      <td>
                        <?php echo $result['id']; ?>
                      </td>
                      <td>
                        <?php echo $result['username']; ?>
                      </td>
                      <td>
                        <?php echo $result['password']; ?>
                      </td>
                      <td>
                        <div class="d-grid gap-2 d-md-flex">
                          <a href="#edit<?php echo $result['id']; ?>" data-toggle="modal" class="btn btn-primary btn-sm me-md-2"><span class="me-2"><i class="bi bi-pencil-square"></i></span> Edit</a> ||
                          <a href="#del<?php echo $result['id']; ?>" data-toggle="modal" class="btn btn-danger btn-sm"><span class="me-2"><i class="bi bi-trash"></i></span>
                            Delete</a>
                        </div>
                      </td>
                    </tr>
                    <!-- Start of Edit Modal -->
                    <!-- Edit Modal HTML -->
                    <div id="edit<?php echo $result['id']; ?>" class="modal fade">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <form id="update_form" method="POST">
                              
                            <?php
                            $edit = mysqli_query($conn, "select * from users where id='" . $result['id'] . "';");
                            $erow = mysqli_fetch_array($edit);
                            ?>
                            <div class="modal-header">
                              <h4 class="modal-title">Edit User</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">

                              <input type="hidden" id="id_u" name="editid" value="<?php echo $erow['id']; ?>" class="form-control" required>
                              <div class="form-group">
                                <label>Username</label>
                                <input type="text" id="username_u" name="editusername" value="<?php echo $erow['username']; ?>" class="form-control" required>
                              </div>
                              <div class="form-group">
                                <label>Password</label>
                                <input type="text" id="password_u" name="editpassword" value="<?php echo $erow['password']; ?>" class="form-control" required>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <input type="hidden" value="2" name="type">
                              <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                              <button class="btn btn-info" id="update">Update</button>
                            </div>
                          </form>
                          <?php 
                           if (isset($_POST['editid']))
                           {
                              $sql = "UPDATE users u SET u.password='" . $_POST['editpassword'] . "', u.username='" . $_POST['editusername'] . "'
                              WHERE u.id='" . $_POST['editid'] . "';";
                              if ($conn->query($sql) === TRUE) {
                                  echo '<script>alert("Credentials Changed Successfully!") 
                                  window.location.href="users.php"</script>';
                                  $_SESSION['passwd'] = $_POST['newpassword'];
                              } else {
                                  echo '<script>alert("Changing Credentials Failed!\n Please Check SQL Connection String!") 
                                  window.location.href="users.php"</script>';
                              }
                           }
                           ?>

                        </div>
                      </div>
                    </div>
                    <!-- End of Edit Modal -->

                    <!-- Delete -->
                    <div class="modal fade" id="del<?php echo $result['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <center>
                              <h4 class="modal-title" id="myModalLabel">Delete</h4>
                            </center>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          </div>
                          <div class="modal-body">

                            <div class="container-fluid">
                              <h5>
                                <center>Are you sure to delete user?<strong>

                                  </strong> This method cannot be undone.</center>
                              </h5>
                            </div>
                          </div>
                          <form method="POST">
                            <input type="hidden" id="id_u" name="deleteid" value="<?php echo $result['id']; ?>" class="form-control" required>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                              <button class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span>
                                Delete</button>
                            </div>
                          </form>
                          <?php
                            if(isset($_POST['deleteid']))
                            {
                              $sql = "DELETE from users WHERE id='" . $_POST['deleteid'] . "';";
                              if ($conn->query($sql) === TRUE) {
                                  echo '<script>alert("User Deleted Successfully!") 
                                  window.location.href="users.php"</script>';
                                  $_SESSION['passwd'] = $_POST['newpassword'];
                              } else {
                                  echo '<script>alert("user Deletion Failed!\n Please Check SQL Connection String!") 
                                  window.location.href="users.php"</script>';
                              }
                            }
                          ?>
                        </div>
                      </div>
                    </div>
                    <!-- /.modal -->
                    <?php } ?>
                  </tbody>
                  <tfoot></tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="./js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
  <script src="./js/jquery-3.5.1.js"></script>
  <script src="./js/jquery.dataTables.min.js"></script>
  <script src="./js/dataTables.bootstrap5.min.js"></script>
  <script src="./js/script.js"></script>
  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!-- Popper JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    $(document).ready(function() {
      $("#myBtn").click(function() {
        $("#myModal").modal("toggle");
      });
    });
  </script>

</body>

</html>