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
    <title>Settings</title>
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
                            <span><i class="bi bi-gear-fill me-2"></i></span> Account Settings
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-hover data-table" style="width: 100%">

                                    <div class="m-2">

                                    <thead class>
                                        <tr>
                                            <th>Username</th>
                                            <th>Password</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td>
                                                <?php echo $_SESSION['username']; ?>
                                            </td>
                                            <td>
                                                <?php echo $_SESSION['passwd']; ?>
                                            </td>
                                            <td>
                                                <div class="d-grid gap-2 d-md-flex">
                                                    <a href="#edit" data-toggle="modal" class="btn btn-primary btn-sm me-md-2"><span class="me-2"><i class="bi bi-pencil-square"></i></span> Edit</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- Start of Edit Modal -->
                                        <!-- Edit Modal HTML -->
                                        <div id="edit" class="modal fade">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form id="update_form" method="POST">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit Account</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        </div>
                                                        <div class="modal-body">

                                                            <input type="hidden" id="id_u" name="editid" value="<?php echo $_SESSION['id']; ?>" class="form-control" required>
                                                            <div class="form-group">
                                                                <label>ID</label>
                                                                <input type="text" id="name_u" name="editempid" value="" class="form-control" disabled>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Username</label>
                                                                <input type="text" id="username_u" name="editusername" value="<?php echo $_SESSION['username']; ?>" class="form-control" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>New Password</label>
                                                                <input type="password" id="password_u" name="editpassword" value="<?php echo $_SESSION['passwd']; ?>" class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <input type="hidden" value="2" name="type">
                                                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                                            <button class="btn btn-info" id="update">Update</button>
                                                        </div>
                                                    </form>
                                                    <?php
                                                    if (isset($_POST['editid'])){
                                                        $sql = "UPDATE users u SET u.password='" . $_POST['editpassword'] . "', u.username='" . $_POST['editusername'] . "'
                                                        WHERE u.id='" . $_SESSION['id'] . "';";
                                                        if ($conn->query($sql) === TRUE) {
                                                            echo '<script>alert("Credentials Changed Successfully!") 
                                                            window.location.href="settings.php"</script>';
                                                            $_SESSION['username'] = $_POST['editusername'];
                                                            $_SESSION['passwd'] = $_POST['editpassword'];
                                                        } else {
                                                            echo '<script>alert("Changing Credentials Failed!\n Please Check SQL Connection String!") 
                                                            window.location.href="settings.php"</script>';
                                                        }
                                                    }
                                                    ?>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- End of Edit Modal -->

                                        <!-- Delete -->
                                        <div class="modal fade" id="del" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                                                <center>Are you sure to delete <strong>

                                                                    </strong> from Faculty list? This method cannot be undone.</center>
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <form method="POST">
                                                        <input type="hidden" id="id_u" name="deleteid" value="" class="form-control" required>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                                                            <button class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span>
                                                                Delete</button>
                                                        </div>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.modal -->

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