<?php
session_start();
include "dbcon.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
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
                <h1 class="text-center" style="color: #A75D5D" >
                    Register
                    <i class="bi bi-box-arrow-in-right"></i>
                </h1>
            </div>
            <div class="card-body">
                <form class="px-4 py-3" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" placeholder="Enter username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Confirm  Password</label>
                        <input type="password" class="form-control" name="confirm" placeholder="Re-enter password" required>
                    </div>
                    <button type="submit" class="btn btn text-white mb-2" style="background-color: #A75D5D;">Create Account</button>
                    <a class="dropdown-item mt-2 text-center" href="./index.php">Already had an account? Login instead.</a>
                </form>
                <?php 
                if (isset($_POST['username']))
                {
                    if ($_POST['password']==$_POST['confirm'])
                    {
                        $sql = "INSERT INTO `users` (username,`password`,privilege)
                        VALUES('" . $_POST['username'] . "','" . $_POST['password'] . "','user')";
                        if ($conn->query($sql) === TRUE) {
                            echo '<script>alert("Account Created!") 
                            window.location.href="index.php"</script>';
                        } else {
                            echo '<script>alert("Account Creation Failed!") 
                            window.location.href="register.php"</script>';
                        }
                    }
                    else
                    {
                        echo '<script>alert("Passwords do not match. Please try again.") 
                        window.location.href="register.php"</script>';
                    }
                }
                ?>
            </div>
        </div>
    </div>

</body>

</html>