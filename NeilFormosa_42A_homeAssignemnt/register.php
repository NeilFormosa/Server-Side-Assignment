<?php
    require_once "dbfunct.php";
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
    <h3 class="mx-auto" style="width:500px">Create an account below.</h3>
        <div class= "d-flex align-items-center">
            <div class="container">
                <form method="POST" action="">
                    <label for = "username" class="form-label">Username</label>
                    <input type="text" name ="username" id="username" class="form-control">
                    <label for = "phone" class="form-label">Phone</label>
                    <input type="phone" name ="phone" id="phone" class="form-control">
                    <label for = "password" class="form-label">Password</label>
                    <input type="password" name ="password" id="password" class="form-control">
                    <button class="btn btn-primary mt-2" name="submit">Create account</button>
                </form>
                <form method="post" action="index.php">
                    <button class="btn btn-primary mt-2">Log-in</button>
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

                $validDetails = true;

                $sqlUsername = "SELECT `username` FROM `details`";
                $sqlPhone = "SELECT `phone` FROM `details`";
                $usernameResult = mysqli_query($conn, $sqlUsername);
                $phoneResult = mysqli_query($conn, $sqlPhone);

                for ($x = 1; $x <= $totalUsers; $x++){
                    $rowUsername = mysqli_fetch_assoc($usernameResult);
                    $rowPhone = mysqli_fetch_assoc($phoneResult);

                    $username = $rowUsername['username'];
                    $phone = $rowPhone['phone'];

                    if (($_POST['username'] == $username) || ($_POST['phone'] == $phone)) {
                        $validDetails = false;
                    }
                }
                
                if ($validDetails == true){
                    $usernameEntry = mysqli_real_escape_string($conn, trim($_POST['username']));
                    $phoneEntry = mysqli_real_escape_string($conn,trim($_POST['phone']));
                    $passwordEntry = mysqli_real_escape_string($conn,password_hash(trim($_POST['password']), PASSWORD_DEFAULT));

                    $addDetailsQuery = "INSERT INTO `details`(`username`, `password`, `phone`) VALUES ('$usernameEntry','$passwordEntry','$phoneEntry')";
                    
                    if(strlen($usernameEntry) > 2 && strlen($usernameEntry) < 16 && !empty($phoneEntry) && strlen($usernameEntry) >= 3){
                        $newAccount = mysqli_query($conn, $addDetailsQuery);
                    }else{
                        echo "<p class='mx-auto' style='width:500px'>Make sure that the username is 3 - 15 char and no fields left empty!</p>";
                    }

                    if(isset($newAccount)){
                        echo "<p class='mx-auto' style='width:500px'>Account created succesfully!</p>";
                    }
                    
                }
                else{
                    echo "<p class='mx-auto' style='width:500px'>username or phone already in use!</p>";
                }
            }
        ?>
</body>
<footer>
    <?php include("footer.php") ?>
</footer>
</html>
