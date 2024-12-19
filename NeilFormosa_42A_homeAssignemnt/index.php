<?php
    require_once "dbfunct.php";
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Document</title>
</head>
<body>
    <h1 class="mx-auto" style="width:500px">Welcome to song saver!</h1>
        <div class= "d-flex align-items-center">
            <div class="container">
                <form method="POST" action="">
                    <label for = "username" class="form-label">Username</label>
                    <input type="text" name ="username" id="username" class="form-control">
                    <label for = "password" class="form-label">Password</label>
                    <input type="password" name ="password" id="password" class="form-control">
                    <button class="btn btn-primary mt-2" name="submit">Log-in</button>
                </form>
                <form method="post" action="register.php">
                    <button class="btn btn-primary mt-2">sign up</button>
                </form>
            </div>
        </div>
        <?php

            if (isset($_POST['submit'])) {
                
                $conn = connectToDB();

                $totalUsersQuery = "SELECT COUNT(`user_Id`) FROM `details`";
                $totalUsersResult = mysqli_query($conn, $totalUsersQuery);
                $rowTotalUser = mysqli_fetch_assoc($totalUsersResult);
                $totalUsers = $rowTotalUser['COUNT(`user_Id`)'];

                $sqlUsername = "SELECT `username` FROM `details`";
                $sqlPassword = "SELECT `password` FROM `details`";

                $usernameResult = mysqli_query($conn, $sqlUsername);
                $passwordResult = mysqli_query($conn, $sqlPassword);

                for ($x = 1; $x <= $totalUsers; $x++){
                    $rowUsername = mysqli_fetch_assoc($usernameResult);
                    $rowPassword = mysqli_fetch_assoc($passwordResult);

                    $username = $rowUsername['username'];
                    $password = $rowPassword['password'];
                    
                    $validPassword = password_verify( trim($_POST['password']) , $password );

                    if ((trim($_POST['username']) == $username) && ($validPassword)) {
                        $_SESSION['username'] = trim($_POST['username']);
                        $_SESSION['password'] = trim($_POST['password']);
                        echo '<script type="text/javascript">';
                        echo 'window.location.href="profileEdit.php";';
                        echo '</script>';
                        exit();
                        break;
                    }
                    
                }
                echo "<p class='mx-auto' style='width:500px'>password or username incorrect!</p>";
            }
        ?>
</body>
<footer>
    <?php include("footer.php") ?>
</footer>
</html>
