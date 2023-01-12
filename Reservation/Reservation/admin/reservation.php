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
  <title>Reservation Management</title>
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
              <span><i class="bi bi-file-text-fill me-2"></i></span> Manage Reservations
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="example" class="table table-hover data-table" style="width: 100%">
                  
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
                  $sql = "SELECT id,reservation_status, transdate, reserver_username,reserved_facility,`status`, CONCAT(date_from,' to ',date_to) AS reserved_date FROM transactions where `status`=0;";
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
                  } else if ($result['reservation_status'] == 1) {
                    echo "Approved";
                  }else if ($result['reservation_status'] == 2) {
                    echo "Denied";
                  }
                  ?>
                </td>
                <td>
                  <?php
                    if ($result['reservation_status'] == 0) {
                    ?>
                    <div class="d-grid gap-2 d-md-flex">
                      <a href="#approve<?php echo $result['id']; ?>" data-toggle="modal" class="btn btn-primary btn-sm me-md-2"><span class="me-2"><i class="bi bi-pencil"></i></span> Approve</a> ||
                      <a href="#deny<?php echo $result['id']; ?>" data-toggle="modal" class="btn btn-danger btn-sm"><span class="me-2"><i class="bi bi-pencil"></i></span> Deny</a>
                    </div>
                    <?php
                    } else {
                      echo "Not Applicable";
                    }
                    ?>
                </td>
              </tr>

                   <!-- Approve -->
                   <div class="modal fade" id="approve<?php echo $result['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <center>
                              <h4 class="modal-title" id="myModalLabel">Deny</h4>
                            </center>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          </div>
                          <div class="modal-body">

                            <div class="container-fluid">
                              <h5>
                                <center>Are you sure you want to Approve reservation? <strong>

                                  </strong>This method cannot be undone.</center>
                              </h5>
                            </div>
                          </div>
                          <form method="POST">
                            <input type="hidden" id="id_u" name="approveid" value="<?php echo $result['id']; ?>" class="form-control" required>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                              <button class="btn btn-primary"><span class="glyphicon glyphicon-trash"></span>
                                Approve</button>
                            </div>
                          </form>
                          <?php 
                          if (isset($_POST['approveid']))
                          {
                            $sql = "UPDATE transactions t
                            SET t.reservation_status=1
                            WHERE t.id='" .$_POST['approveid']. "'";
                            if ($conn->query($sql) === TRUE) {
                              echo '<script>alert("Reservation Approved") 
                              window.location.href="reservation.php"</script>';
                            }else{
                              echo '<script>alert("Reservation Approval Failed!") 
                                              window.location.href="reservation.php"</script>';
                            }
                          }
                          ?>
                          <?php 
                          ?>
                        </div>
                      </div>
                    </div>
                    <!-- /.modal -->

                    <!-- Deny -->
                    <div class="modal fade" id="deny<?php echo $result['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <center>
                              <h4 class="modal-title" id="myModalLabel">Deny</h4>
                            </center>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          </div>
                          <div class="modal-body">

                            <div class="container-fluid">
                              <h5>
                                <center>Are you sure you want to Deny reservation? <strong>

                                  </strong>This method cannot be undone.</center>
                              </h5>
                            </div>
                          </div>
                          <form method="POST">
                            <input type="hidden" id="id_u" name="denyid" value="<?php echo $result['id']; ?>" class="form-control" required>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                              <button class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span>
                                Deny</button>
                            </div>
                          </form>
                          <?php 
                          if (isset($_POST['denyid']))
                          {
                            $sql = "UPDATE transactions t
                            SET t.reservation_status=2
                            WHERE t.id='" .$_POST['denyid']. "'";
                            if ($conn->query($sql) === TRUE) {
                              echo '<script>alert("Reservation Denied") 
                              window.location.href="reservation.php"</script>'; 
                            }else{
                              echo '<script>alert("Reservation Denial Failed!") 
                                              window.location.href="reservation.php"</script>';
                            }
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                    <!-- /.modal -->
                    
                  <?php
                  } ?>

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