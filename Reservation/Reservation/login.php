<?php
session_start();
include "dbcon.php";
if (isset($_POST['username']) && isset($_POST['passwd'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $username = validate($_POST['username']);
    $password = validate($_POST['passwd']);

    $sql = "SELECT * FROM users WHERE username='$username' and `password`='$password';";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if ($row['username'] === $username && $row['password'] === $password) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['privilege'] = $row['privilege'];
            $_SESSION['passwd'] = $row['password'];
            if ($row['privilege'] === "admin") {
                header("Location: admin/index.php");
            } else {
                header("Location: user/index.php");
            }
        }
    } else {
        echo "<script>
                alert('NO Account Registered under said credentials.');
                window.location.href='index.php';
                </script>";
    }
}
