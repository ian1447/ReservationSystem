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
    <title>Administrator</title>

    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="css/style.css" />

</head>

<body class="fixed-left">

    <!-- Top Bar Start -->
    <?php include('./includes/navbar.php'); ?>
    <!-- ========== Left Sidebar Start ========== -->
    <?php include('./includes/sidebar.php'); ?>
    <!-- Left Sidebar End -->

    <main class="mt-5 pt-3 px-4">
        <div class="row">
            <div class="col">
                <div class="card mb-3 shadow-lg" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-4" style="background-color: #A75D5D;">
                            <img src="https://img.icons8.com/wired/512/bookmark-ribbon.png" class="img-fluid"
                                alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">Reservations</h5>
                                <h1 class="card-text fw-bold">
                                <?php
                                    $sql = "SELECT count(*) as count FROM transactions where `reservation_status`!=0;";
                                    $result = mysqli_fetch_assoc(mysqli_query($conn, $sql));
                                    echo $result['count'];
                                    ?>
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mb-3 shadow-lg" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-4" style="background-color: #A75D5D;">
                            <img src="https://img.icons8.com/wired/512/home.png"
                                class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">Facilities</h5>
                                <h1 class="card-text fw-bold">
                                <?php
                                    $sql = "SELECT count(*) as count FROM facilities;";
                                    $result = mysqli_fetch_assoc(mysqli_query($conn, $sql));
                                    echo $result['count'];
                                    ?>
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mb-3 shadow-lg" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-4" style="background-color: #A75D5D;">
                            <img src="https://img.icons8.com/dotty/512/conference-call.png"
                                class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">Users</h5>
                                <h1 class="card-text fw-bold">
                                <?php
                                    $sql = "SELECT count(*) as count FROM users where privilege='user';";
                                    $result = mysqli_fetch_assoc(mysqli_query($conn, $sql));
                                    echo $result['count'];
                                    ?>
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Datatable for memo records -->
        <div class="card shadow-lg">
            <div class="card-header">
                <span><i class="bi bi-file-text-fill me-2"></i></span> Reservations
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-hover data-table" style="width: 100%">
                        <div class="m-2">
                            <thead class>
                                <tr>
                                    <th>Facility Reserved</th>
                                    <th>Date From</th>
                                    <th>Date To</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $sql = "SELECT * FROM transactions where `reservation_status`!=0;";
                                $actresult = mysqli_query($conn, $sql);

                                while ($result = mysqli_fetch_assoc($actresult)) {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $result['reserved_facility']; ?>
                                    </td>
                                    <td>
                                        <?php echo $result['date_from']; ?>
                                    </td>
                                    <td>
                                        <?php echo $result['date_to']; ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- end of memo datatable -->
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
        $(document).ready(function () {
            $("#myBtn").click(function () {
                $("#myModal").modal("toggle");
            });
        });
    </script>

</body>

</html>