<?php
session_start();

if (isset($_SESSION['username']))
{
    if($_SESSION['privilege']==="admin")
    {
        header("Location: admin/index.php");
    }
    else
    {
        header("Location: user/index.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <script language="javascript" type="text/javascript">
        window.history.forward();
    </script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
    <title>Memorandum Management</title>
</head>

<body style="background-image: url('./images/BISU.png'); 
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: cover;">

    <!-- Navbar -->
    <?php include("./navbar.php") ?>
    <!-- End of navbar -->

    <div class="container d-flex justify-content-md-center align-items-center vh-100">
        <div class="card text-left shadow-lg">
            <div class="card-header px-4"
                style="font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">
                <h1 class="text-center" style="color: #A75D5D">
                    Login
                    <i class="bi bi-box-arrow-in-right"></i>
                </h1>
            </div>
            <div class="card-body">
                <form class="px-4 py-3" action="login.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" id="username" placeholder="Enter username" required>
                    </div>
                    <div class="mb-3"> 
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="passwd" class="form-control" id="passwd" placeholder="Enter password" required>
                    </div>
                    <button type="submit" class="btn btn text-white mb-2" style="background-color: #A75D5D;">Sign in</button>
                    <a class="dropdown-item mt-2 text-center" href="./register.php">No account yet? Sign up here.</a>
                </form>
            </div>
        </div>
    </div>

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