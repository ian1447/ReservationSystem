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
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />
  <link rel="stylesheet" href="css/style.css" />
</head>

<body class="fixed-left">

  <!-- Top Bar Start -->
  <?php include('includes/navbar.php'); ?>
  <!-- ========== Left Sidebar Start ========== -->
  <?php include('includes/sidebar.php'); ?>
  <!-- Left Sidebar End -->

  <main class="mt-5 pt-3">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12 mb-3">
          <div class="card">
            <div class="card-header">
              <span><i class="bi bi-table me-2"></i></span> Supplies
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="example" class="table table-hover data-table" style="width: 100%">

                  <div class="m-2">
                    <!-- Button HTML (to Trigger Modal) -->
                    <button type="button" id="myBtn" class="btn btn-outline-success">
                      <span class="me-2"><i class="bi bi-file-earmark-plus"></i></span>
                      Create Reservation
                    </button>

                    <!-- Modal HTML -->
                    <div id="myModal" class="modal fade" data-bs-backdrop="static" tabindex="-1">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Create Reservation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                          </div>
                          <div class="modal-body">

                            <form class="needs-validation" method="POST">
                              <div class="form-row">
                                </div>
                                <div class="col-md-12 mb-2">
                                  <label for="facility" class="form-label">Facility:</label>
                                  <select id="" class="form-select" name="facility">
                                    <?php
                                    $sql = "SELECT `location` FROM facilities;";
                                    $actresult = mysqli_query($conn, $sql);
                                    while ($result = mysqli_fetch_assoc($actresult)) {
                                      echo "<option>" . $result['location'] . "</option>";
                                    }
                                    ?>
                                  </select>
                                </div>
                                <div class="row">
                                  <div class="col-md-6 mb-2">
                                    <label for="validationCustom01">Date From:</label>
                                    <input type="date" class="form-control" id="date_from" name="date_from" required>
                                    <div class="valid-feedback">
                                      Looks good!
                                    </div>
                                  </div>
                                  <div class="col-md-6 mb-2">
                                    <label for="validationCustom01">Date To:</label>
                                    <input type="date" class="form-control" id="date_to" name="date_to" required>
                                    <div class="valid-feedback">
                                      Looks good!
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button class="btn btn-primary">Reserve</button>
                              </div>
                            </form>
                            <?php
                            if (isset($_POST['facility'])) {
                              $sql = "SELECT * FROM transactions WHERE reserved_facility='" . $_POST['facility'] . "' and DATE('" . $_POST['date_from'] . "') BETWEEN date_from AND date_to";
                              $result = mysqli_query($conn, $sql);
                              if (mysqli_num_rows($result) === 1) {
                                echo '<script>alert("Date not Availabel!") 
                                                window.location.href="reservation.php"</script>';
                              } else {
                                $sql2 = "INSERT INTO `transactions` (transdate,reserver_username,reserved_facility,date_from,date_to)
                                VALUES(NOW(),'" . $_SESSION['username'] . "','" . $_POST['facility'] . "','" . $_POST['date_from'] . "','" . $_POST['date_to'] . "')";
                                if ($conn->query($sql2) === TRUE) {
                                  echo '<script>alert("Reservation Applied!") 
                                  window.location.href="reservation.php"</script>';
                                } else {
                                  echo '<script>alert("Reservation Failed!") 
                                  window.location.href="reservation.php"</script>';
                                }
                              }
                            }
                            ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
          </div>
          <thead class>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Date of Reservation</th>
              <th>Facility</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>

            <?php
            $sql = "SELECT id,reservation_status, transdate, reserver_username,reserved_facility,`status`, CONCAT(date_from,' to ',date_to) AS reserved_date FROM transactions where `status`=0 and reserver_username='" . $_SESSION['username'] . "';";
            $actresult = mysqli_query($conn, $sql);

            while ($result = mysqli_fetch_assoc($actresult)) {
            ?>
              <tr>
                <td>
                  <?php echo $result['id']; ?>
                </td>
                <td>
                  <?php echo $result['reserver_username']; ?>
                </td>
                <td>
                  <?php echo $result['reserved_date']; ?>
                </td>
                <td>
                  <?php echo $result['reserved_facility']; ?>
                </td>
                <td>
                  <?php
                  if ($result['reservation_status'] == 0) {
                    echo "Waiting for Approval";
                  } else {
                    echo "Approved";
                  }
                  ?>
                </td>
                <td>
                  <div class="d-grid gap-2 d-md-flex">
                    <a href="#edit<?php echo $result['id']; ?>" data-toggle="modal" class="btn btn-primary btn-sm me-md-2"><span class="me-2"><i class="bi bi-pencil"></i></span> Edit</a> ||
                    <a href="#del<?php echo $result['id']; ?>" data-toggle="modal" class="btn btn-danger btn-sm"><span class="me-2"><i class="bi bi-trash"></i></span>
                      Delete</a>
                  </div>
                </td>
              </tr>

              <!-- Start of Edit Modal -->
              <!-- Edit Modal HTML -->
              <div class="modal fade" id="edit<?php echo $result['id']; ?>">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Edit Reservation</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                    </div>
                    <div class="modal-body">

                      <form method="POST">
                        <div class="form-row">
                          <?php
                          $edit = mysqli_query($conn, "select * from transactions where id='" . $result['id'] . "';");
                          $erow = mysqli_fetch_array($edit);
                          ?>
                           <input type="hidden" id="id_u" name="editid" value="<?php echo $erow['id']; ?>"
                                class="form-control" required>
                          <div class="col-md-12 mb-2">
                            <label for="validationCustom01">Name:</label>
                            <input type="text" class="form-control" id="editname" name="editname" value="<?php echo $erow['reserver_username']; ?>" disabled>
                            <div class="valid-feedback">
                              Looks good!
                            </div>
                          </div>
                          <div class="col-md-12 mb-2">
                            <label for="facility" class="form-label">Facility:</label>
                            <select id="" class="form-select" name="editfacility">
                              <option selected><?php echo $erow['reserved_facility']; ?> </option>
                              <option>Multimedia Room</option>
                              <option>Conference Room</option>
                              <option>School Bus</option>
                              <option>Chairs and Tables</option>
                              <option>Sound System</option>
                            </select>
                          </div>
                          <div class="row">
                            <div class="col-md-6 mb-2">
                              <label for="validationCustom01">Date From:</label>
                              <input type="date" class="form-control" id="editdatefrom" name="editdatefrom" value="<?php echo $erow['date_from']; ?>" required>
                              <div class="valid-feedback">
                                Looks good!
                              </div>
                            </div>
                            <div class="col-md-6 mb-2">
                              <label for="validationCustom01">Date To:</label>
                              <input type="date" class="form-control" id="editdateto" name="editdateto" value="<?php echo $erow['date_to']; ?>" required>
                              <div class="valid-feedback">
                                Looks good!
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <input type="reset" class="btn btn-secondary">
                          <button class="btn btn-primary">Save</button>
                        </div>
                      </form>
                      <?php
                      if (isset($_POST['editfacility'])) {
                        if (strtotime($_POST['editdatefrom'])>strtotime($_POST['editdateto']))
                        {
                          echo '<script>alert("Date from must come first before Date to!") 
                            window.location.href="reservation.php"</script>';
                        }
                        else{
                          $sql1 = "SELECT COUNT(*) as count FROM `transactions` WHERE reserved_facility='".$_POST['editfacility']."' AND id!=".$_POST['editid']." AND DATE('".$_POST['editdatefrom']."') BETWEEN date_from AND date_to";
                          $result2 = mysqli_query($conn, $sql1);
                          $res = mysqli_fetch_array($result2);

                          if ($res['count'] == 0){
                            $sql = "UPDATE transactions t
                            SET t.reserved_facility='" . $_POST['editfacility'] . "',t.date_from='" . $_POST['editdatefrom'] . "',t.date_to='" . $_POST['editdateto'] . "'
                            WHERE t.id='" .$_POST['editid']. "'";
                            if ($conn->query($sql) === TRUE) {
                              echo '<script>alert("Reservation Edit Successful!") 
                                              window.location.href="reservation.php"</script>';
                            }else{
                              echo '<script>alert("Reservation Edit Failed!") 
                                              window.location.href="reservation.php"</script>';
                            }
                          }else {
                            echo '<script>alert("Date of Reservation with facility is not available!")
                            window.location.href="reservation.php"</script>';
                          }
                        }
                      }
                      ?>

                    </div>
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
                      <?php
                      $del = mysqli_query($conn, "SELECT reserved_facility, CONCAT(date_from,' to ',date_to) AS reserved_date FROM transactions where id='" . $result['id'] . "'");
                      $drow = mysqli_fetch_array($del);
                      ?>
                      <div class="container-fluid">
                        <h5>
                          <center>Are you sure to delete <strong>
                              <?php echo ucwords($drow['reserved_facility']); ?> on <?php echo ucwords($drow['reserved_date']); ?>
                            </strong>This method cannot be undone.</center>
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
                      <?php
                      if (isset($_POST['deleteid'])) {
                        $sql = "DELETE FROM transactions  WHERE id='" . $_POST['deleteid'] . "'";
                        if ($conn->query($sql) === TRUE) {
                          echo '<script>alert("Deleted Successfully!") 
                                                window.location.href="reservation.php"</script>';
                        } else {
                          echo '<script>alert("Deleting Supply Details Failed!\n Please Check SQL Connection String!") 
                                                window.location.href="reservation.php"</script>';
                        }
                      }
                      ?>
                    </form>
                  </div>
                </div>
              </div>
              <!-- /.modal -->
            <?php
            }
            ?>
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